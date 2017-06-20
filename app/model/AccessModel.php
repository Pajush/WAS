<?php

namespace App\Model;

use Tracy\Debugger;
use Nette;


class AccessModel extends BaseModel
{

    /**
     * Metoda vrací seznam všech přístupů
     */
    public function listAccess()
    {
        return $this->database->table('access')->fetchAll();
    }
    /**
     * Metoda vrací seznam všech přístupů podle zvolenych dvojic
     */
    public function fetchPairsAccess($first, $second)
    {
        return $this->database->table('access')->fetchPairs($first, $second);
    }

    /**
     * Metoda vrací přísup se zadaným id, pokud neexistuje vrací NoDataFound.
     * @param int  $id
     */
    public function getAccess($id)
    {
        $result = $this->database->table('access')->where(array("id" => $id))->fetch();
        if(!$result) {
            throw new NoDataFound();
        }
        return $result;
    }

    /**
     * Metoda vloží nový přístup
     * @param array  $values
     * @return $id vloženého přístupu
     */
    public function insertAccess($values)
    {
        $new = array(
            'id_post' => $values->id_post,
            'id_user' => $values->id_user,
            'id_tag' => $values->id_tag,
            'id_action' => $values->id_action,
            'time_arrived' => new Nette\Utils\DateTime,
            'locality' => $values->locality,
            'source_visit' => $values->source_visit,
            'web_print' => $values->web_print,
        );
        $newRow = $this->database->table('access')->insert($new);
        return $newRow->id;
    }

    /**
     * Metoda edituje přístup, pokud neexistuje vrací NoDataFound.
     * @param array  $values
     */
    public function updateAccess($id, $values)
    {
        $row = $this->database->table('access')->where(array("id" => $id));
        if(!$row->fetch()) {
            throw new NoDataFound();
        }
        $new = array(
            'time_departure' => $values->time_departure
        );
        $row->update($new);
        return $id;
    }

    /**
     * Metoda odebere přístup, pokud neexistuje vrací NoDataFound.
     * @param array  $values
     */
    public function deleteAccess($id)
    {
        $row = $this->database->table('access')->where(array("id" => $id));
        if(!$row->fetch()) {
            throw new NoDataFound();
        }
        $row->delete();
    }
}