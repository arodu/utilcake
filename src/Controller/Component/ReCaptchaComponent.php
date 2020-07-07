<?php
declare(strict_types=1);

namespace UtilCake\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Event\EventInterface;

/**
 * ReCaptcha component
 */
class ReCaptchaComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
      'secret_key' => null,
      'public_key' => null,
      'version' => 'v3',
      'input_name' => 'g-recaptcha-response',
      'recaptcha_min_score' => 0.5,
      'recaptcha_url' => 'https://www.google.com/recaptcha/api/siteverify?secret=%s&response=%s',
      'active' => true,
    ];

    public function initialize(array $config): void{
        parent::initialize($config);
        $controller = $this->getController();

        $controller->viewBuilder()->setHelpers(['UtilCake.ReCaptcha' => [
          'public_key' => $this->getConfig('public_key'),
          'input_name' => $this->getConfig('input_name'),
          'active' => $this->getConfig('active'),
        ]]);

    }


      public function verify($data){
        if($this->getConfig('active') === false){
          return true;
        }

        if (isset($data[$this->getConfig('input_name')])) {

            // Build POST request:
            $url = sprintf($this->getConfig('recaptcha_url'), $this->getConfig('secret_key'), $data[$this->getConfig('input_name')]);
    
            // Make and decode POST request:
            $recaptcha = file_get_contents($url);
            $recaptcha = json_decode($recaptcha);
    
            // Take action based on the score returned:
            if ($recaptcha->success && $recaptcha->score >= $this->getConfig('recaptcha_min_score')) {
              return true;
            }
          }
        
        return false;
      }

      public function verifyOrFail($data){
        
      }
    
      public function getPublicKey(){
        return $this->getConfig('public_key');
      }

}
