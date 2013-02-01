<?php

namespace {

from('Application')
-> import('Controller.Base')
-> import('Model.Post');

}

namespace Application\Controller\Api {

class Posts extends \Application\Controller\Base {

  public function IndexAction ( ) {

    $query = $this->router->getQuery();
    $limit = isset($query['limit']) ? $query['limit'] : 1;

    $post = new \Application\Model\Post();
    $list = $post->getList(1, $limit);

    echo json_encode($list);

    return;
  }
}

}