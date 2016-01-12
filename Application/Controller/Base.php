<?php

namespace Application\Controller;

class Base extends \Hoathis\Kit\Aggregator {

  protected function LoadPost ( $kit, $id ) {

    try {
      $post = \Application\Model\Post::findById($id);
    }
    catch (\Hoathis\Model\Exception\NotFound $e) {
      $kit->getKit('Redirector')
          ->redirect('posts', array('controller' => 'posts',
                                    'action' => 'index'));
    }

    return $post;
  }

}