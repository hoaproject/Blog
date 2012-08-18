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

  public function ShowAction ( $id ) {

    $article              = new \Application\Model\Article();
    $article->id          = $id;
    $article->open();
    $this->data->title    = $article->title;
    $this->data->article  = $article;
    $this->data->comments = $article->comments;

    $this->view->addOverlay('hoa://Application/View/Posts/Article.xyl');
    $this->view->render();

    return;
  }

  public function NewAction ( ) {

    $this->view->addOverlay('hoa://Application/View/Posts/New.xyl');
    $this->view->render();

    return;
  }

  public function EditAction ( $id ) {

    $this->data->id = $id;

    $this->view->addOverlay('hoa://Application/View/Posts/Edit.xyl');
    $this->view->render();

    return;
  }

}

}