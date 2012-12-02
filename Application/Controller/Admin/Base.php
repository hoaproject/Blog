<?php

namespace {

from('Hoa')
-> import('Dispatcher.Kit')
-> import('Session.~');

from('Application')
-> import('Controller.Base');

}

namespace Application\Controller\Admin {

class Base extends \Application\Controller\Base {

  protected function adminGuard ( ) {

    $self = $this;

    event('hoa://Event/Session/user:expired')
      ->attach(function ( \Hoa\Core\Event\Bucket $bucket ) use ( $self ) {
          $self->getKit('Redirector')->redirect('log');
      });

    $user = new \Hoa\Session('user');

    if(false === $user->isEmpty())
        return true;

    $user->hasExpired();

    return false;
  }
}

}