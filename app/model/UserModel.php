<?php

namespace App\Model;

use Tracy\Debugger;
use Nette;


class UserModel extends BaseModel
{

    /**
     * Metoda vrací seznam všech uživatelů
     */
    public function listUsers()
    {
        return $this->database->table('user')->fetchAll();
    }
    /**
     * Metoda vrací seznam všech uživatelů podle zvolenych dvojic
     */
    public function fetchPairsUsers($first, $second)
    {
        return $this->database->table('user')->fetchPairs($first, $second);
    }

    /**
     * Metoda vrací uživatele se zadaným id, pokud neexistuje vrací NoDataFound.
     * @param int  $id
     */
    public function getUser($id)
    {
        $result = $this->database->table('user')->where(array("id" => $id))->fetch();
        if(!$result) {
            throw new NoDataFound();
        }
        return $result;
    }

    /**
     * Metoda vloží nového uživatele
     * @param array  $values
     * @return $id vloženého uživatele
     */
    public function insertUser($values)
    {
        $new = array(
            'firstname' => $values->firstname,
            'surname' => $values->surname,
            'password' => md5($values->password),
            'id_role' => $values->id_role,
            'street' => $values->street,
            'city' => $values->city,
            'zip_code' => $values->zip_code,
            'state' => $values->state,
            'registered' => new Nette\Utils\DateTime
        );
        $newRow = $this->database->table('user')->insert($new);
        return $newRow->id;
    }

    /**
     * Metoda edituje uživatele, pokud neexistuje vrací NoDataFound.
     * @param array  $values
     */
    public function updateUser($id, $values)
    {
        $row = $this->database->table('user')->where(array("id" => $id));
        if(!$row->fetch()) {
            throw new NoDataFound();
        }
        $new = array(
            'firstname' => $values->firstname,
            'surname' => $values->surname,
            'password' => md5($values->password),
            'role' => $values->role,
            'street' => $values->street,
            'city' => $values->city,
            'zip_code' => $values->zip_code,
            'state' => $values->state,
        );
        $row->update($new);
        return $id;
    }

    /**
     * Metoda odebere uživatele, pokud neexistuje vrací NoDataFound.
     * @param array  $values
     */
    public function deleteUser($id)
    {
        $row = $this->database->table('user')->where(array("id" => $id));
        if(!$row->fetch()) {
            throw new NoDataFound();
        }
        $row->delete();
    }
}