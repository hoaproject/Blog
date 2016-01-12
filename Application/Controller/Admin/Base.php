<?php

namespace Application\Controller\Admin;

class Base extends \Application\Controller\Base {

  protected function adminGuard ( ) {

    $self = $this;

    event('hoa://Event/Session/user:expired')
      ->attach(function ( \Hoa\Event\Bucket $bucket ) use ( $self ) {
          $self->getKit('Redirector')->redirect('log');
      });

    $user = new \Hoa\Session('user');

    if(false === $user->isEmpty())
        return true;

    $user->hasExpired();

    return false;
  }
}