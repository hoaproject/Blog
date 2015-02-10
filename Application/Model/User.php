<?php

namespace Application\Model;

use Hoa\Model;
use Hoa\Database;
use Hoathis\Model\Exception;

class User extends Model {

    protected $_name;
    protected $_password;



    protected function construct ( ) {

        $this->setMappingLayer(Database\Dal::getLastInstance());

        return;
    }

    public function open ( Array $constraints = [] ) {

        $constraints = array_merge($this->getConstraints(), $constraints);

        $data = $this->getMappingLayer()
                     ->prepare(
                         'SELECT name, password ' .
                         'FROM   user ' .
                         'WHERE  name = :name'
                     )
                     ->execute($constraints)
                     ->fetchAll();

        if(empty($data)) {
            throw new Exception\NotFound('User not found');
        }

        $this->map($data[0]);

        return;
    }
}