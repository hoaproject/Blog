<?php

namespace {

from('Application')
-> import('Controller.Base')
-> import('Model.Post')
-> import('Model.Comment');

from('Hoa')
-> import('Stringbuffer.Read');

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

    $post              = $this->LoadPost($this, $id);

    $this->data->title = $post->title;
    $this->data->post  = $post;

    $buffer = new \Hoa\Stringbuffer\Read();
    $buffer->initializeWith(
        '<?xml version="1.0" encoding="utf-8"?>' . "\n\n" .
        '<fragment xmlns="http://hoa-project.net/xyl/xylophone">' . "\n".
        '  <snippet id="main">' . "\n" .
        $post->content .
        '  </snippet>' . "\n" .
        '</fragment>'
    );
    $this->view->addFragment(
        $buffer->getStreamName(),
        'content'
    );

    // TODO use post id from post in view
    $this->data->post_id  = $post->id;
    $this->data->comments = $post->comments;

    $this->view->addOverlay('hoa://Application/View/Posts/Show.xyl');
    $this->view->render();

    return;
  }
}

}