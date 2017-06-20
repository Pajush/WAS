<?php

namespace App\Model;

use Tracy\Debugger;


class TagModel extends BaseModel
{
    /**
     * Metoda vrací seznam všech tagy příspěvků
     */
    public function listTags()
    {
        return $this->database->table('tag')->where(["deleted" => 0])->fetchAll();
    }

    /**
     * Metoda vrací tag se zadaným id, pokud neexistuje vrací NoDataFound.
     * @param int  $id
     */
    public function getTag($id)
    {
        $result = $this->database->table('tag')->where(array("id" => $id))->fetch();
        if(!$result) {
            throw new NoDataFound();
        }
        return $result;
    }

    /**
     * Metoda vrací tag se zadaným id, pokud neexistuje vrací NoDataFound.
     * @param int  $id
     */
    public function getTagByName($name)
    {
        $result = $this->database->table('tag')->where(array("name" => $name, "deleted" => 0))->fetch();
        return $result;
    }

    /**
     * Metoda vloží nový tag
     * @param array  $values
     * @return $id vloženého tagu
     */
    public function insertTag($values)
    {
        $new = array(
            'name' => $values->name,
        );
        $newRow = $this->database->table('tag')->insert($new);
        return $newRow->id;
    }

    /**
     * Metoda edituje typ, pokud neexistuje vrací NoDataFound.
     * @param int  $id
     * @param array  $values
     */
    public function updateTag($id, $values)
    {
        $row = $this->database->table('tag')->where(array("id" => $id));
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
     * Metoda odebere tag, pokud neexistuje vrací NoDataFound.
     * @param array  $values
     */
    public function deleteTag($id)
    {
        $row = $this->database->table('tag')->where(array("id" => $id));
        if(!$row->fetch()) {
            throw new NoDataFound();
        }
        $row->update(['deleted' => 1]);
    }
}