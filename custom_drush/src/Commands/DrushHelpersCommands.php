<?php

namespace Drupal\custom_drush\Commands;

use Consolidation\OutputFormatters\StructuredData\RowsOfFields;
use Drush\Commands\DrushCommands;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\node\Entity\Node;

class DrushHelpersCommands extends DrushCommands {

  /**
   * @var Drupal\Core\Entity\EntityTypeManagerInterface $entityManager
   *    Entity manager service.
   */

  public function __construct(EntityTypeManagerInterface $entityTypeManager) {
    $this->entityManager = $entityTypeManager;
    parent::__construct();
  }

  /**
   * Command that returns a list of all node id and title for article.
   *
   * @field-labels
   *  id: node Id
   *  title: node title
   * @default-fields id,title
   *
   * @usage drush-helpers:article-node
   *   Returns all article node
   *
   * @command drush-helpers:article-node
   * @aliases article-node
   *
   * @return \Consolidation\OutputFormatters\StructuredData\RowsOfFields
   */
  public function loadArticleNodes() {

    $nodes = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties([ 'type' => 'article'] ); //select node which is of type article
    $rows = [];
    foreach ($nodes as $node) {
      $rows[] = [
        'id' => $node->id(), //get the id
        'title' => $node->getTitle(), //get he title
      ];
    }
    return new RowsOfFields($rows);
  }

}