<?php

namespace App\Model;

use Nette;

class NoDataFound extends \Exception {};
class InvalidArgument extends \Exception {};


class BaseModel extends Nette\Object {



    protected $database;
/**
* @brief Konstruktor vytvarejici base model.
*/
    public function __construct(Nette\Database\Context $database) {
        $this->database = $database;

    }
}