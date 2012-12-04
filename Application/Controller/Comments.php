<?php

namespace {

from('Application')
-> import('Controller.Base')
-> import('Model.Comment')
-> import('Model.Post');

}

namespace Application\Controller {

class Comments extends Base {

  public function CreateAction ( $post_id ) {

    $post = $this->LoadPost($this, $post_id);

    $this->view->addOverlay('hoa://Application/View/Posts/Show.xyl');
    $this->view->interprete();
    $form = $this->view->getElement('comment_submit');

    if(   true === $form->hasBeenSent()
       && true === $form->isValid()) {

        $formData         = $form->getData();
        $comment          = new \Application\Model\Comment();
        $comment->author  = $formData['author'];
        $comment->posted  = time();
        $comment->content = $formData['comment'];
        $comment->create($post->id);
    }

    $this->getKit('Redirector')
         ->redirect('post', array('controller' => 'posts',
                                  'action'     => 'show',
                                  'id'         => $post->id,
                                  '_fragment'  => 'comment-'.$comment->id));

    return;
  }
}

}