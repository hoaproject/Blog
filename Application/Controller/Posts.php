<?php

namespace {

from('Application')
-> import('Controller.Base')
-> import('Model.Post')
-> import('Model.Comment');

}

namespace Application\Controller {

class Posts extends Base {

  private $post_per_page = 4;

  public function IndexAction ( ) {

    $query = $this->router->getQuery();
    $page = isset($query['page']) ? $query['page'] : 1;

    $post                 = new \Application\Model\Post();
    try {
      $list               = $post->getList($page,
                                           $this->post_per_page);
    }
    catch (\Hoathis\Model\Exception\NotFound $e) {
      $this->getKit('Redirector')
           ->redirect('posts', array('controller' => 'posts',
                                     'action' => 'index'));
    }
    $this->data->title    = 'All posts';
    $this->data->posts    = $list;

    // TODO use a single variable for both values
    $this->data->number   = ceil($post->count()/$this->post_per_page);
    $this->data->current  = $page;

    $this->view->addOverlay('hoa://Application/View/Posts/Index.xyl');
    $this->view->render();

    return;
  }

  public function ShowAction ( $id ) {

    $post                 = $this->LoadPost($this, $id);

    $this->data->title    = $post->title;
    $this->data->post     = $post;
    $this->data->comments = $post->comments;

    $this->view->addOverlay('hoa://Application/View/Posts/Show.xyl');
    $this->view->render();

    return;
  }

  private function LoadPost ( $kit, $id ) {

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

}