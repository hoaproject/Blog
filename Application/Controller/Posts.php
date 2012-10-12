<?php

namespace {

from('Application')
-> import('Controller.Generic')
-> import('Model.Post')
-> import('Model.Comment');

}

namespace Application\Controller {

class Posts extends Generic {

  private $post_per_page = 4;

  public function IndexAction ( $_this, $page ) {

    $post                 = new \Application\Model\Post();
    try {
      $list               = $post->getList($page,
                                           $this->post_per_page);
    }
    catch (\Hoathis\Model\Exception\NotFound $e) {
      $_this->getKit('Redirector')
            ->redirect('posts', array('controller' => 'posts',
                                      'action' => 'index'));
    }
    $this->data->title    = 'All posts';
    $this->data->posts    = $list;

    $this->view->addOverlay('hoa://Application/View/Posts/Index.xyl');
    $this->view->render();

    return;
  }

  public function ShowAction ( $_this, $id ) {

    $post                 = $this->LoadPost($_this, $id);

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

  public function CreateAction ( $_this ) {

    $post                = new \Application\Model\Post();
    try {
      $post->create($_POST["post"]);
    }
    catch (\Hoathis\Model\Exception\ValidationFailed $e) {
      $this->data->title = 'New post';
      $this->data->post  = $post;

      $this->view->addOverlay('hoa://Application/View/Posts/New.xyl');
      $this->view->render();

      return;
    }

    $_this->getKit('Redirector')
          ->redirect('post', array('controller' => 'posts',
                                   'action'     => 'show',
                                   'id'         =>  $post->id));

    return;
  }

  public function EditAction ( $_this, $id ) {

    $post              = $this->LoadPost($_this, $id);

    $this->data->title = 'Edit post #'.$post->id;
    $this->data->post  = $post;

    $this->view->addOverlay('hoa://Application/View/Posts/Edit.xyl');
    $this->view->render();

    return;
  }

  public function UpdateAction ( $_this, $id ) {

    $post = $this->LoadPost($_this, $id);
    try {
      $post->update($_POST["post"]);
    }
    catch (\Hoathis\Model\Exception\ValidationFailed $e) {
      $this->data->title   = 'Edit post #'.$post->id;
      $this->data->post    = $post;

      $this->view->addOverlay('hoa://Application/View/Posts/Edit.xyl');
      $this->view->render();

      return;
    }

    $_this->getKit('Redirector')
          ->redirect('post', array('controller' => 'posts',
                                   'action'     => 'show',
                                   'id'         =>  $post->id));

    return;
  }

  public function DeleteAction ( $_this, $id ) {

    $post = $this->LoadPost($_this, $id);
    $post->delete();

    $_this->getKit('Redirector')
          ->redirect('posts', array('controller' => 'posts',
                                    'action'     => 'list'));

    return;
  }

  private function LoadPost ( $kit, $id ) {

    $post = new \Application\Model\Post();
    try {
      $post->findById($id);
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