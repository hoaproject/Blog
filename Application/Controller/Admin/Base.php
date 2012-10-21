<?php

namespace {

from('Hoa')
-> import('Dispatcher.Kit')
-> import('Session.~')
-> import('Session.QNamespace');

from('Application')
-> import('Controller.Base');

}

namespace Application\Controller\Admin {

class Base extends \Application\Controller\Base {

  protected function adminGuard ( ) {

      try {
          \Hoa\Session::start();
      }
      catch( \Hoa\Core\Exception $e ) {
          \Hoa\Session::destroy();
          $this->getKit('Redirector')->redirect('log');
          return null;
      }

      if(true === \Hoa\Session::isNamespaceSet('user'))
          return true;

      $this->getKit('Redirector')->redirect('log');
      return false;
  }
}

}