<?php

namespace UtilCake\Controller\Component;

use Cake\Controller\Component;
use Cake\Http\Exception\NotFoundException;

/*
  public function initialize(){
    parent::initialize();

    $this->loadComponent('GoogleLogin', [
      'client_id' => GOOGLE_CLIENT_ID,
      'client_secret' => GOOGLE_CLIENT_SECRET,
      'redirect_uri' => Router::url(['controller' => 'Users', 'action' => 'googleLogin', 'prefix'=>false, '_full'=>true]),
    ]);

  }
*/

class GoogleLoginComponent extends Component {

  protected $_defaultConfig = [
    'client_id' => null,
    'client_secret' => null,
    'redirect_uri' => null,
    'result_fields' => ['given_name', 'family_name', 'email', 'gender', 'id', 'picture', 'verified_email'],
  ];

  public function initialize(array $config): void {
    parent::initialize($config);
    $controller = $this->getController();

    $controller->viewBuilder()->setHelpers(['UtilCake.GoogleLogin' => [
      'login_link' => $this->getLoginLink(),
    ]]);
  }

  public function getLoginLink() {
    $data = [
      'scope' => 'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email',
      'redirect_uri' => $this->getConfig('redirect_uri'),
      'response_type' => 'code',
      'client_id' => $this->getConfig('client_id'),
      'access_type' => 'online'
    ];
    return 'https://accounts.google.com/o/oauth2/auth?' . http_build_query($data);
  }

  public function getAccessToken($code) {
    $url = 'https://www.googleapis.com/oauth2/v4/token';
    $data = [
      'client_id' => $this->getConfig('client_id'),
      'redirect_uri' => $this->getConfig('redirect_uri'),
      'client_secret' => $this->getConfig('client_secret'),
      'code' => $code,
      'grant_type' => 'authorization_code',
    ];
    $curlPost = http_build_query($data);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
    $data = json_decode(curl_exec($ch), true);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($http_code != 200) {
      throw new NotFoundException(__('Failed to receieve access token'));
    }

    return $data;
  }

  public function getUserProfileInfo($access_token) {
    $url = 'https://www.googleapis.com/oauth2/v2/userinfo?fields=' . implode(',', $this->getConfig('result_fields'));

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $access_token));
    $data = json_decode(curl_exec($ch), true);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($http_code != 200) {
      throw new NotFoundException(__('Failed to get user information'));
    }

    return $data;
  }
}
