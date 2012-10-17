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
                         'SELECT * ' .
                         'FROM   post ' .
                         'WHERE  id = :id'
                     )
                     ->execute(array('id' => $id))
                     ->fetchAll();

        if(!empty($data)) {
            $this->map($data[0]);
            $this->comments->map(
                $this->getMappingLayer()
                     ->prepare(
                         'SELECT * ' .
                         'FROM   comment '.
                         'WHERE  post = :post'
                     )
                     ->execute(array('post' => $id))
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
                    ->execute(array(
                        'title'   => $this->title,
                        'content' => $this->content,
                        'id'      => $this->id
                    ));
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
             ->execute(array(
                'title'   => $this->title,
                'content' => $this->content,
                'posted'  => $this->posted
             ));
        $this->id = $this->getMappingLayer()->lastInsertId();
    }

    public function delete ( ) {

      return $this->getMappingLayer()
                  ->prepare(
                    'DELETE FROM post WHERE id = :id'
                  )
                  ->execute(array(
                    'id'  => $this->id,
                  ));
    }

    public function getList ( $current_page, $post_per_page ) {

        if( $current_page > ceil($this->count()/$post_per_page) ) {
            throw new \Hoathis\Model\Exception\NotFound("Page not found");
        }

        $first_entry = ($current_page - 1) * $post_per_page;

        return $this->getMappingLayer()
                    ->prepare(
                        'SELECT id, title, posted ' .
                        'FROM post ' .
                        'ORDER BY posted DESC ' .
                        'LIMIT :first_entry, :post_per_page'
                    )
                    ->execute(array(
                        'first_entry'   => $first_entry,
                        'post_per_page' => $post_per_page,
                    ))
                    ->fetchAll();
    }

    public function count ( ) {

        return $this->getMappingLayer()
                    ->query(
                        'SELECT COUNT(*) FROM post'
                    )
                    ->fetchColumn();
    }
}

}