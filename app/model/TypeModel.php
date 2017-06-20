<?php

namespace App\Model;

use Tracy\Debugger;


class TypeModel extends BaseModel
{
    /**
     * Metoda vrací seznam všech typů příspěvků
     */
    public function listTypes()
    {
        return $this->database->table('type')->where(["deleted" => 0])->fetchAll();
    }

    /**
     * Metoda vrací typ se zadaným id, pokud neexistuje vrací NoDataFound.
     * @param int  $id
     */
    public function getType($id)
    {
        $result = $this->database->table('type')->where(array("id" => $id))->fetch();
        if(!$result) {
            throw new NoDataFound();
        }
        return $result;
    }

    /**
     * Metoda vrací tag se zadaným id, pokud neexistuje vrací NoDataFound.
     * @param int  $id
     */
    public function getTypeByName($name)
    {
        $result = $this->database->table('type')->where(array("name" => $name, "deleted" => 0))->fetch();
        return $result;
    }

    /**
     * Metoda vloží nový typ
     * @param array  $values
     * @return $id vloženého typu
     */
    public function insertType($values)
    {
        $new = array(
            'name' => $values->name,
        );
        $newRow = $this->database->table('type')->insert($new);
        return $newRow->id;
    }

    /**
     * Metoda edituje typ, pokud neexistuje vrací NoDataFound.
     * @param int  $id
     * @param array  $values
     */
    public function updateType($id, $values)
    {
        $row = $this->database->table('type')->where(array("id" => $id));
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
     * Metoda odebere typ, pokud neexistuje vrací NoDataFound.
     * @param array  $values
     */
    public function deleteType($id)
    {
        $row = $this->database->table('type')->where(array("id" => $id));
        if(!$row->fetch()) {
            throw new NoDataFound();
        }
        $row->update(['deleted' => 1]);
    }
}