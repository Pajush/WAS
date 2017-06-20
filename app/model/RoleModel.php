<?php

namespace App\Model;

use Tracy\Debugger;


class RoleModel extends BaseModel
{
    /**
     * Metoda vrací seznam všech rolí uživatelů
     */
    public function listRoles()
    {
        return $this->database->table('role')->fetchAll();
    }

    /**
     * Metoda vrací roli se zadaným id, pokud neexistuje vrací NoDataFound.
     * @param int  $id
     */
    public function getRole($id)
    {
        $result = $this->database->table('role')->where(array("id" => $id))->fetch();
        if(!$result) {
            throw new NoDataFound();
        }
        return $result;
    }

    /**
     * Metoda vloží novou roli
     * @param array  $values
     * @return $id vložené role
     */
    public function insertRole($values)
    {
        $new = array(
            'name' => $values->name,
        );
        $newRow = $this->database->table('role')->insert($new);
        return $newRow->id;
    }

    /**
     * Metoda edituje roli, pokud neexistuje vrací NoDataFound.
     * @param int  $id
     * @param array  $values
     */
    public function updateRole($id, $values)
    {
        $row = $this->database->table('role')->where(array("id" => $id));
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
     * Metoda odebere roli, pokud neexistuje vrací NoDataFound.
     * @param array  $values
     */
    public function deleteRole($id)
    {
        $row = $this->database->table('role')->where(array("id" => $id));
        if(!$row->fetch()) {
            throw new NoDataFound();
        }
        $row->delete();
    }
}