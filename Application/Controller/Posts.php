<?php

namespace {

from('Application')
-> import('Model.Article')
-> import('Model.Comment');

}

namespace Application\Controller {

class Posts extends \Hoa\Dispatcher\Kit {

  public function IndexAction ( ) {

    $article              = new \Application\Model\Article();
    $list                 = $article->getShortList();
    $this->data->title    = 'All articles';
    $this->data->articles = $list;

    $this->view->addOverlay('hoa://Application/View/Posts/Index.xyl');
    $this->view->render();

    return;
  }

  public function ShowAction ( $_this, $id ) {

    $article              = new \Application\Model\Article();
    $article->id          = $id;

    try {
      $article->open();
    }
    catch (\Hoathis\Model\Exception\NotFound $e) {
      $_this->redirect('posts', ['controller' => 'posts', 'action' => 'index']);
    }

    $this->data->title    = $article->title;
    $this->data->article  = $article;
    $this->data->comments = $article->comments;

    $this->view->addOverlay('hoa://Application/View/Posts/Article.xyl');
    $this->view->render();

    return;
  }

  public function NewAction ( ) {

    $article             = new \Application\Model\Article();
    $this->data->title   = 'New article';
    $this->data->article = $article;

    $this->view->addOverlay('hoa://Application/View/Posts/New.xyl');
    $this->view->render();

    return;
  }

  public function CreateAction ( ) {

    // Todo

    return;
  }

  public function EditAction ( $_this, $id ) {

    $article             = new \Application\Model\Article();
    $article->id         = $id;
    try {
      $article->open();
    }
    catch (\Hoathis\Model\Exception\NotFound $e) {
      $_this->redirect('posts', ['controller' => 'posts', 'action' => 'index']);
    }

    $this->data->title   = 'Edit post #'.$article->id;
    $this->data->article = $article;

    $this->view->addOverlay('hoa://Application/View/Posts/Edit.xyl');
    $this->view->render();

    return;
  }

  public function UpdateAction ( $id ) {

    // Todo

    return;
  }

}

}