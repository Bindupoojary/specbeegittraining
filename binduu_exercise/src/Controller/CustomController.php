<?php

namespace Drupal\binduu_exercise\Controller;

// Base class for controllerdemo.
use Drupal\Core\Controller\ControllerBase;
use Drupal\binduu_exercise\CustomService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * To include custom_service.
 */
class CustomController extends ControllerBase {
  /**
   * The customservice.
   *
   * @var \Drupal\binduu_exercise\CustomService
   */
  protected $customService;

  /**
   * Dependency injection.
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('custom_service')
    );
  }

  /**
   * Constructor.
   */
  public function __construct(CustomService $customService) {
    $this->customService = $customService;
  }
  /**
   * This method gets called when the route is matched.
   */
  public function hello() {
    // getName() method to retrieve data.
    // And Drupal service container called to get an instance of custom service.
    $data = \Drupal::service("custom_service")->getName();
    return [
          // The theme to be rendered.
      '#theme' => "block_plugin_template",
          // Variables.
      '#text' => $data,
      '#hexcode' => '#800080',
    ];

  }

}
