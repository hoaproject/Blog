<?php

namespace Application\Model;

use Hoa\Model;
use Hoa\Database;
use Hoathis\Model\Exception;

class Comment extends Model {

    protected $_id;
    protected $_post;
    protected $_author;
    protected $_posted;
    protected $_content;



    protected function construct ( ) {

        $this->setMappingLayer(Database\Dal::getLastInstance());

        $this->posted = time();

        return;
    }

    public function create ( $post_id, Array $attributes) {

        try {
            $this->author  = trim(strip_tags($attributes["author"]));
            $this->content = trim(strip_tags($attributes["comment"]));
        }
        catch (Model\Exception $e) {
            throw new Exception\ValidationFailed($e->getMessage());
        }

        $this->getMappingLayer()->query('PRAGMA foreign_keys = ON');
        $this->getMappingLayer()
             ->prepare(
                'INSERT INTO comment (post, author, posted, content) ' .
                'VALUES (:post, :author, :posted, :content)'
             )
             ->execute(array_merge(
                $this->getConstraints(),
                ['post' => $post_id]
            ));

        $this->id = $this->getMappingLayer()->lastInsertId();
    }

    static public function deleteByPost( $post_id ) {

        $comment = new Comment();
        $comment->getMappingLayer()
                ->prepare(
                    'DELETE FROM comment WHERE post = :post_id'
                )
                ->execute([
                    'post_id' => $post_id,
                ]);
    }
}