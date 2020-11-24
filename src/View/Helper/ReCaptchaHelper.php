<?php

declare(strict_types=1);

namespace UtilCake\View\Helper;

use Cake\View\Helper;

/**
 * ReCaptcha helper
 */
class ReCaptchaHelper extends Helper {
  /**
   * Default configuration.
   *
   * @var array
   */
  protected $_defaultConfig = [
    'url' => 'https://www.google.com/recaptcha/api.js?render=%s',
    'input_name' => null,
    'public_key' => null,
    'active' => true,
  ];

  public $helpers = ['Html', 'Form'];

  protected function _googleUrl() {
    return sprintf($this->getConfig('url'), $this->getConfig('public_key'));
  }

  public function getInputName() {
    return $this->getConfig('input_name');
  }

  public function getPublicKey() {
    return $this->getConfig('public_key');
  }

  public function script($form_target, $action = 'app') {
    if ($this->getConfig('active')) {
      $script_code = 'document.querySelector("' . $form_target . '").addEventListener("submit", function(e){
    e.preventDefault();
      grecaptcha.ready(async function() {
        let token = await grecaptcha.execute("' . $this->getConfig('public_key') . '", {action: "' . $action . '"})
        let form = e.originalTarget

        let input = document.createElement("input");
          input.type = "hidden";
          input.name = "' . $this->getConfig('input_name') . '";
          input.value = token;

        form.appendChild(input);

        form.submit();
      });
  });';

      $this->Html->script($this->_googleUrl(), ['block' => true]);
      $this->Html->scriptBlock($script_code, ['block' => true]);
    }

    return null;
  }
}
