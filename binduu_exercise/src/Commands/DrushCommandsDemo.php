<?php

namespace Drupal\binduu_exercise\Commands;

// Namespace.
// To format the output usingRowsOfFields.
use Consolidation\OutputFormatters\StructuredData\RowsOfFields;
// Used as base class.
use Drush\Commands\DrushCommands;
// To use the service.
use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 * Drush demo commands.
 */
class DrushCommandsDemo extends DrushCommands {
  // Extending the base class.

  /**
   * Comment.
   *
   * @var Drupal\Core\Entity\EntityTypeManagerInterface $entityManager
   *    Entity manager service.
   */
  public function __construct(EntityTypeManagerInterface $entityTypeManager) {
    // To load the entity.
    $this->entityManager = $entityTypeManager;
    parent::__construct();
  }

  /**
   * Command that returns a list of all blocked users.
   *
   * @field-labels
   *  id: Node Id
   *  title: Title
   * @default-fields id,title
   *
   * @usage drush-helpers: get-title
   *   Returns all get-title
   *
   * @command drush-helpers:get-title
   * @aliases get-title
   *
   * @return \Consolidation\OutputFormatters\StructuredData\RowsOfFields
   *   description for return
   */
  public function drushDemo() {
    // It will load nodes of type basic page.
    $nodes = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties(['type' => 'page']);
    $rows = [];
    foreach ($nodes as $node) {
      $rows[] = [
      // Returns node id.
        'id' => $node->id(),
      // Returns the title.
        'title' => $node->getTitle(),
      ];
    }
    // Output will be displayed in rows.
    return new RowsOfFields($rows);
  }

}
