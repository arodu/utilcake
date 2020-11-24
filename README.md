# UtilCake plugin for CakePHP 4.x

CakePHP Plugin, collection of utilities for CakePHP 4.x

## Installation

You can install this plugin into your CakePHP application using [composer](https://getcomposer.org).

The recommended way to install composer packages is:

```sh
composer require arodu/utilcake
```

## Configuration

You can load the plugin using the shell command:

```sh
bin/cake plugin load UtilCake
```

Or you can manually add the loading statement in the **src/Application.php** file of your application:

```php
public function bootstrap(){
    parent::bootstrap();
    $this->addPlugin('UtilCake');
}
```

## How to use

### Google reCaptcha V3

In the controller file

```php
public function initialize(): void{
  parent::initialize();
  $this->loadComponent('UtilCake.ReCaptcha', [
    'public_key'=>'RECAPTCHA_PUBLIC_KEY',
    'secret_key'=>'RECAPTCHA_SECRET_KEY',
  ]);
}

// any action
public function action(){
  // ...
  if ($this->request->is('post')) {
    if($this->ReCaptcha->verify($this->request->getData())){
      // when the verification is successful
      // ...
    }else{
      // when the verification is not successful
      $this->Flash->error(__('reCaptcha failed, try again'));
    }
  }
  // ...
}
```

In the template `templates/ControllerName/action.php`

```php
echo $this->Form->create(null, ['id'=>'form-id']);
  // ...
echo $this->Form->end();

$this->ReCaptcha->script('#form-id');
```

### Google login

In the controller file

```php
//  /Controller/UsersController.php
public function initialize(): void{
  parent::initialize();
  $this->loadComponent('UtilCake.GoogleLogin', [
    'client_id' => GOOGLE_CLIENT_ID,
    'client_secret' => GOOGLE_CLIENT_SECRET,
    'redirect_uri' => Router::url([
        'controller' => 'Users',
        'action' => 'googleLogin',
        'prefix' => false,
        '_full' => true
      ]),
  ]);
}
```

In the login template

```php
//  /templates/Users/login.php
  echo $this->GoogleLogin->link(__('Sign in with Google'),
    ['class' => 'btn btn-block btn-danger', 'escape' => false]
  );
```
