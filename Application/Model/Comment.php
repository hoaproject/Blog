<?php

namespace {

from('Hoa')
-> import('Model.~')
-> import('Database.Dal');

}

namespace Application\Model {

class Comment extends \Hoa\Model {

    protected $_id;
    protected $_post;
    protected $_author;
    protected $_posted;
    protected $_content;



    protected function construct ( ) {

        $this->setMappingLayer(\Hoa\Database\Dal::getLastInstance());

        $this->posted = time();

        return;
    }

    public function create ( $post_id, Array $attributes) {

        try {
            $this->author  = trim(strip_tags($attributes["author"]));
            $this->content = trim(strip_tags($attributes["comment"]));
        }
        catch (\Hoa\Model\Exception $e) {
            throw new \Hoathis\Model\Exception\ValidationFailed($e->getMessage());
        }

        $this->getMappingLayer()->query('PRAGMA foreign_keys = ON');
        $this->getMappingLayer()
             ->prepare(
                'INSERT INTO comment (post, author, posted, content) ' .
                'VALUES (:post, :author, :posted, :content)'
             )
             ->execute(array_merge(
                $this->getConstraints(),
                array('post' => $post_id)
            ));

        $this->id = $this->getMappingLayer()->lastInsertId();
    }

    static public function deleteByPost( $post_id ) {

      $comment = new Comment();
      $comment->getMappingLayer()
              ->prepare(
                'DELETE FROM comment WHERE post = :post_id'
              )
              ->execute(array(
                'post_id'  => $post_id,
              ));
    }
}

}