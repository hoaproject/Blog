<?php

namespace {

from('Hoa')
-> import('Dispatcher.Kit');

}

namespace Hoathis\Kit {

class Redirector extends \Hoa\Dispatcher\Kit {

  public function redirect ( $ruleId, Array $data = array(), $secured = null,
                             $status = 302 ) {

    $uri = $this->router->unroute($ruleId, $data, $secured);

    $response = $this->view->getOutputStream();
    $response->sendHeader('Location', $uri, true, $status);

    exit;
  }

}

}