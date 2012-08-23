<?php

namespace {

from('Hoa')
-> import('Model.~')
-> import('Model.Exception')
-> import('Database.Dal');

from('Hoathis')
-> import('Model.Exception.*');

}

namespace Application\Model {

class Post extends \Hoa\Model {

    /**
     * @invariant id: boundinteger(0);
     */
    protected $_id;

    /**
     * @invariant title: string(boundinteger(1, 255));
     */
    protected $_title;

    /**
     * @invariant posted: boundinteger(
     *                        timestamp('1 january 1999'),
     *                        timestamp('now')
     *                    );
     */
    protected $_posted;

    /**
     * @invariant content: string(boundinteger(1));
     */
    protected $_content;

    /**
     * @invariant comments: relation('Application\Model\Comment', boundinteger(0));
     */
    protected $_comments;



    protected function construct ( ) {

        $this->setMappingLayer(\Hoa\Database\Dal::getLastInstance());

        return;
    }

    public function findById ( $id ) {

        $data = $this->getMappingLayer()
                     ->prepare(
                         'SELECT id, title, content ' .
                         'FROM   post ' .
                         'WHERE  id = :id'
                     )
                     ->execute(['id' => $id])
                     ->fetchAll();

        if(!empty($data)) {
            $this->map($data[0]);
            $this->comments->map(
                $this->getMappingLayer()
                     ->prepare(
                         'SELECT id, posted, author, content ' .
                         'FROM   comment '.
                         'WHERE  post = :post'
                     )
                     ->execute(['post' => $id])
                     ->fetchAll()
            );
        }
        else
        {
            throw new \Hoathis\Model\Exception\NotFound("Post not found");
        }

        return;
    }

    public function update ( Array $attributes = array() ) {

        try {
            $this->title   = trim(strip_tags($attributes["title"]));
            $this->content = trim(strip_tags($attributes["content"]));
        }
        catch (\Hoa\Model\Exception $e) {
            throw new \Hoathis\Model\Exception\ValidationFailed($e->getMessage());
        }

        return $this->getMappingLayer()
                    ->prepare(
                        'UPDATE post SET title = :title, content = :content ' .
                        'WHERE  id = :id'
                    )
                    ->execute([
                        'title'   => $this->title,
                        'content' => $this->content,
                        'id'      => $this->id
                    ]);
    }

    public function create ( Array $attributes = array() ) {

        try {
            $this->title   = trim(strip_tags($attributes["title"]));
            $this->content = trim(strip_tags($attributes["content"]));
            $this->posted  = strtotime(trim(strip_tags($attributes["posted"])));
        }
        catch (\Hoa\Model\Exception $e) {
            throw new \Hoathis\Model\Exception\ValidationFailed($e->getMessage());
        }

        $this->getMappingLayer()
             ->prepare(
                'INSERT INTO post (title, content, posted) ' .
                'VALUES (:title, :content, :posted)'
             )
             ->execute([
                'title'   => $this->title,
                'content' => $this->content,
                'posted'  => $this->posted
             ]);
        $this->id = $this->getMappingLayer()->lastInsertId();
    }

    public function delete ( ) {

      return $this->getMappingLayer()
                  ->prepare(
                    'DELETE FROM post WHERE id = :id'
                  )
                  ->execute([
                    'id'  => $this->id,
                  ]);
    }

    public function getShortList ( ) {

        return $this->getMappingLayer()->query(
            'SELECT id, title, posted FROM post ORDER BY id DESC'
        )->fetchAll();
    }
}

}