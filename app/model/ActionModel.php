<?php

namespace App\Model;

use Tracy\Debugger;


class ActionModel extends BaseModel
{
    /**
     * Metoda vrací seznam všech akcí přístupů
     */
    public function listActions()
    {
        return $this->database->table('action')->fetchAll();
    }

    /**
     * Metoda vrací akci se zadaným id, pokud neexistuje vrací NoDataFound.
     * @param int  $id
     */
    public function getAction($id)
    {
        $result = $this->database->table('action')->where(array("id" => $id))->fetch();
        if(!$result) {
            throw new NoDataFound();
        }
        return $result;
    }

    /**
     * Metoda vloží novou akci
     * @param array  $values
     * @return $id vložené akce
     */
    public function insertAction($values)
    {
        $new = array(
            'name' => $values->name,
        );
        $newRow = $this->database->table('action')->insert($new);
        return $newRow->id;
    }

    /**
     * Metoda edituje akci, pokud neexistuje vrací NoDataFound.
     * @param int  $id
     * @param array  $values
     */
    public function updateAction($id, $values)
    {
        $row = $this->database->table('action')->where(array("id" => $id));
        if(!$row->fetch()) {
            throw new NoDataFound();
        }
        $new = array(
            'name' => $values->name,
        );
        $row->update($new);
        return $id;
    }

    /**
     * Metoda odebere akci, pokud neexistuje vrací NoDataFound.
     * @param array  $values
     */
    public function deleteAction($id)
    {
        $row = $this->database->table('action')->where(array("id" => $id));
        if(!$row->fetch()) {
            throw new NoDataFound();
        }
        $row->delete();
    }
}