<?php

namespace {

from('Hoa')
-> import('Dispatcher.Kit')
-> import('Session.~')
-> import('Session.QNamespace');

from('Hoathis')
-> import('Kit.Aggregator');

}

namespace Application\Controller {

class Generic extends \Hoathis\Kit\Aggregator {

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