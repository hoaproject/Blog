<?php

namespace Application\Model;

use Hoa\Model;
use Hoa\Database;
use Hoa\String;
use Hoathis\Model\Exception;

class Post extends Model {

    protected $_id;
    protected $_title;
    protected $_posted;
    protected $_content;

    /**
     * @invariant comments: relation('Application\Model\Comment', boundinteger(0));
     */
    protected $_comments;

    protected function construct ( ) {

        $this->setMappingLayer(Database\Dal::getLastInstance());

        $this->posted = time();

        return;
    }

    static public function findById ( $id ) {

        $post = new Post();
        $data = $post->getMappingLayer()
                     ->prepare(
                         'SELECT id, posted, title, content ' .
                         'FROM   post ' .
                         'WHERE  id = :id'
                     )
                     ->execute(['id' => $id])
                     ->fetchAll();

        if(!empty($data)) {
            $post->map($data[0]);
            $post->comments->map(
                $post->getMappingLayer()
                     ->prepare(
                         'SELECT id, posted, author, content ' .
                         'FROM   comment ' .
                         'WHERE  post = :post'
                     )
                     ->execute(['post' => $id])
                     ->fetchAll()
            );
        }
        else
        {
            throw new Exception\NotFound('Post not found');
        }

        return $post;
    }

    public function update ( Array $attributes = [] ) {

        try {
            $this->title   = trim(strip_tags($attributes['title']));
            $this->content = trim($attributes['content']);
            $this->posted  = strtotime(trim(strip_tags($attributes['posted'])));
        }
        catch (Model\Exception $e) {
            throw new Exception\ValidationFailed($e->getMessage());
        }

        return $this->getMappingLayer()
                    ->prepare(
                        'UPDATE post SET title = :title, content = :content, ' .
                        'posted = :posted ' .
                        'WHERE  id = :id'
                    )
                    ->execute([
                        'title'   => $this->title,
                        'content' => $this->content,
                        'posted'  => $this->posted,
                        'id'      => $this->id
                    ]);
    }

    public function create ( Array $attributes = [] ) {

        try {
            $this->title   = trim(strip_tags($attributes['title']));
            $this->content = trim(strip_tags($attributes['content']));
            $this->posted  = strtotime(trim(strip_tags($attributes['posted'])));
        }
        catch (Model\Exception $e) {
            throw new Exception\ValidationFailed($e->getMessage());
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

      Comment::deleteByPost($this->id);

      return $this->getMappingLayer()
                  ->prepare(
                    'DELETE FROM post WHERE id = :id'
                  )
                  ->execute([
                    'id' => $this->id,
                  ]);
    }

    public function getList ( $current_page, $post_per_page ) {

        if( $current_page > ceil($this->count()/$post_per_page) ) {
            throw new Exception\NotFound("Page not found");
        }

        $first_entry = ($current_page - 1) * $post_per_page;

        $list = $this->getMappingLayer()
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

        foreach($list as &$post) {

          $post['normalized_title'] = Post::getNormalizedTitle($post['title']);
        }

        return $list;
    }

    public static function getNormalizedTitle( $title ) {

      $normalized_title = new String($title);
      $normalized_title = $normalized_title->toAscii()
                                           ->replace('/\s/', '-')
                                           ->replace('/[^a-zA-Z0-9\-]+/', '')
                                           ->reduce(0, 32)
                                           ->toLowerCase();

      // force cast because json_encode (used for API) try to return this as an
      // object without it
      return (string)$normalized_title;
    }

    public function count ( ) {

        return $this->getMappingLayer()
                    ->query(
                        'SELECT COUNT(*) FROM post'
                    )
                    ->fetchColumn();
    }
}