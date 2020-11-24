<?php

declare(strict_types=1);

namespace UtilCake\View\Helper;

use Cake\View\Helper;

/**
 * ReCaptcha helper
 */
class GoogleLoginHelper extends Helper {
  /**
   * Default configuration.
   *
   * @var array
   */
  protected $_defaultConfig = [
    'login_link' => null,
  ];

  public $helpers = ['Html'];

  public function getLoginLink() {
    return $this->getConfig('login_link');
  }

  public function link($title, array $options = []): string {
    return $this->Html->link($title, $this->getConfig('login_link'), $options);
  }
}
