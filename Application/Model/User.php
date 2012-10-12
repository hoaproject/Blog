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

class User extends \Hoa\Model {

    /**
     * @invariant name: string(boundinteger(1, 31));
     */
    protected $_name;

    /**
     * @invariant password: string(40);
     */
    protected $_password;



    protected function construct ( ) {

        $this->setMappingLayer(\Hoa\Database\Dal::getLastInstance());

        return;
    }

    public function open ( Array $constraints = array() ) {

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
            throw new \Hoathis\Model\Exception\NotFound("User not found");
        }

        $this->map($data[0]);

        return;
    }
}

}