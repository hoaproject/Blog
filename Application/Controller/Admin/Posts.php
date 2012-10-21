<?php

namespace {

from('Application')
-> import('Controller.Admin.Base')
-> import('Model.Post')
-> import('Model.Comment');

}

namespace Application\Controller\Admin {

class Posts extends Base {

  public function NewAction ( ) {

    $this->adminGuard();

    $post                = new \Application\Model\Post();
    $this->data->title   = 'New post';
    $this->data->post    = $post;

    $this->view->addOverlay('hoa://Application/View/Posts/New.xyl');
    $this->view->render();

    return;
  }

  public function CreateAction ( ) {

    $this->adminGuard();

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

    $this->getKit('Redirector')
         ->redirect('post', array('controller' => 'posts',
                                  'action'     => 'show',
                                  'id'         =>  $post->id));

    return;
  }

  public function EditAction ( $id ) {

    $this->adminGuard();

    $post              = $this->LoadPost($this, $id);

    $this->data->title = 'Edit post #'.$post->id;
    $this->data->post  = $post;

    $this->view->addOverlay('hoa://Application/View/Posts/Edit.xyl');
    $this->view->render();

    return;
  }

  public function UpdateAction ( $id ) {

    $this->adminGuard();

    $post = $this->LoadPost($this, $id);
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

    $this->getKit('Redirector')
         ->redirect('post', array('controller' => 'posts',
                                  'action'     => 'show',
                                  'id'         =>  $post->id));

    return;
  }

  public function DeleteAction ( $id ) {

    $this->adminGuard();

    $post = $this->LoadPost($this, $id);
    $post->delete();

    $this->getKit('Redirector')
         ->redirect('posts', array('controller' => 'posts',
                                   'action'     => 'list'));

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