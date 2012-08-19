<?php

namespace {

from('Hoa')
-> import('Model.~')
-> import('Database.Dal');

}

namespace Application\Model {

class Comment extends \Hoa\Model {

    /**
     * @invariant id: boundinteger(0);
     */
    protected $_id;

    /**
     * @invariant post: relation('Application\Model\Post', 1);
     */
    protected $_post;

    /**
     * @invariant author: regex('[\w\d\'\- ]+', boundinteger(1, 42));
     */
    protected $_author;

    /**
     * @invariant posted: boundinteger(
     *                        timestamp('1 january 1999'),
     *                        timestamp('now')
     *                    );
     */
    protected $_posted;

    /**
     * @invariant content: string(boundinteger(1, 4096));
     */
    protected $_content;



    protected function construct ( ) {

        $this->setMappingLayer(\Hoa\Database\Dal::getLastInstance());

        return;
    }
}

}