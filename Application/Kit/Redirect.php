<?php

namespace {

from('Hoa')
-> import('Dispatcher.Kit');

}

namespace Application\Kit {

    class Redirect extends \Hoa\Dispatcher\Kit {

      public function redirect ( $ruleId, Array $data, $secured = null,
                                 $status = null ) {

          // Le routeur est sur $this->router, facile.
          $uri = $this->router->unroute($ruleId, $data, $secured);
          var_dump($uri);

          // Où est la réponse HTTP ? Dur à dire.
          // En fait, la vue va s'écrire sur un flux qui est le flux sortant.
          // Dans le cas d'une appli Web, ce sera notre réponse HTTP !
          $response = $this->view->getOutputStream();
          $response->sendHeader('Location', $uri, true, $status);

          exit;
      }

    }

}