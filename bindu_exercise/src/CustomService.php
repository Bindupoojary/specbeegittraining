<?php

namespace Drupal\bindu_exercise;

use Drupal\Core\Config\ConfigFactory;

/**
 * Describe services.
 *
 * @package Drupal\bindu_exercise\Services
 */
class CustomService {

  /**
   * Configuration Factory.
   *
   * @var \Drupal\Core\Config\ConfigFactory
   */
  protected $configFactory;

  /**
   * Constructor.
   */
  public function __construct(ConfigFactory $configFactory) {
    // The "ConfigFactory" object is a Drupal core service.
    $this->configFactory = $configFactory;
  }

  /**
   * Gets my setting.
   */
  public function getName() {
    // The value of fullname configuration setting is returned by the method.
    $config = $this->configFactory->get('bindu_exercise.settings');
    return $config->get('fullname');
  }

}
