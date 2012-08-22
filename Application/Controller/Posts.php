<?php

namespace {

from('Application')
-> import('Model.Post')
-> import('Model.Comment');

}

namespace Application\Controller {

class Posts extends \Hoa\Dispatcher\Kit {

  public function IndexAction ( ) {

    $post                 = new \Application\Model\Post();
    $list                 = $post->getShortList();
    $this->data->title    = 'All posts';
    $this->data->posts    = $list;

    $this->view->addOverlay('hoa://Application/View/Posts/Index.xyl');
    $this->view->render();

    return;
  }

  public function ShowAction ( $_this, $id ) {

    $post                 = new \Application\Model\Post();
    try {
      $post->findById($id);
    }
    catch (\Hoathis\Model\Exception\NotFound $e) {
      $_this->redirect('posts', ['controller' => 'posts', 'action' => 'index']);
    }

    $this->data->title    = $post->title;
    $this->data->post     = $post;
    $this->data->comments = $post->comments;

    $this->view->addOverlay('hoa://Application/View/Posts/Show.xyl');
    $this->view->render();

    return;
  }

  public function NewAction ( ) {

    $post                = new \Application\Model\Post();
    $this->data->title   = 'New post';
    $this->data->post    = $post;

    $this->view->addOverlay('hoa://Application/View/Posts/New.xyl');
    $this->view->render();

    return;
  }

  public function CreateAction ( ) {

    // Todo

    return;
  }

  public function EditAction ( $_this, $id ) {

    $post                = new \Application\Model\Post();
    try {
      $post->findById($id);
    }
    catch (\Hoathis\Model\Exception\NotFound $e) {
      $_this->redirect('posts', ['controller' => 'posts', 'action' => 'index']);
    }

    $this->data->title   = 'Edit post #'.$post->id;
    $this->data->post    = $post;

    $this->view->addOverlay('hoa://Application/View/Posts/Edit.xyl');
    $this->view->render();

    return;
  }

  public function UpdateAction ( $_this, $id ) {

    $post                = new \Application\Model\Post();
    try {
      $post->findById($id);
      $post->update($_POST["post"]);
    }
    catch (\Hoathis\Model\Exception\NotFound $e) {
      $_this->redirect('posts', ['controller' => 'posts', 'action' => 'index']);
    }
    catch (\Hoathis\Model\Exception\ValidationFailed $e) {
      $this->data->title   = 'Edit post #'.$post->id;
      $this->data->post    = $post;

      $this->view->addOverlay('hoa://Application/View/Posts/Edit.xyl');
      $this->view->render();

      return;
    }

    $_this->redirect('post', ['controller' => 'posts',
                              'action'     => 'show',
                              'id'         =>  $post->id]);

    return;
  }
}

}