<?php

namespace App\Model;

use Tracy\Debugger;


class PostsModel extends BaseModel
{
    /**
     * Metoda vrací seznam všech příspěvků
     */
    public function listPosts()
    {
        return $this->database->table('posts')->fetchAll();
    }

    /**
     * Metoda vrací příspěvěk se zadaným id, pokud neexistuje vrací NoDataFound.
     * @param int  $id
     */
    public function getPost($id)
    {
        $result = $this->database->table('posts')->where(array("id" => $id))->fetch();
        if(!$result) {
            throw new NoDataFound();
        }
        return $result;
    }

    /**
     * Metoda vloží nový příspěvěk
     * @param array  $values
     * @return $id vloženého příspěvku
     */
    public function insertPost($values)
    {
        $new = array(
            'table_to_exist' => $values->table_to_exist,
            'id_to_exist' => $values->id_to_exist,
            'id_type' => $values->id_type,
            'name' => $values->name,
            'short_text' => $values->short_text,
            'photo' => $values->photo,
            'price' => $values->price,
            'long_text' => $values->long_text,
            'properties' => $values->properties,
            'id_tag' => $values->id_tag,
            'priority' => $values->priority
        );
        $newRow = $this->database->table('posts')->insert($new);
        return $newRow->id;
    }

    /**
     * Metoda edituje příspěvěk, pokud neexistuje vrací NoDataFound.
     * @param int  $id
     * @param array  $values
     */
    public function updatePost($id, $values)
    {
        $row = $this->database->table('posts')->where(array("id" => $id));
        if(!$row->fetch()) {
            throw new NoDataFound();
        }
        $new = array(
            'table_to_exist' => $values->table_to_exist,
            'id_to_exist' => $values->id_to_exist,
            'id_type' => $values->id_type,
            'name' => $values->name,
            'short_text' => $values->short_text,
            'photo' => $values->photo,
            'price' => $values->price,
            'long_text' => $values->long_text,
            'properties' => $values->properties,
            'id_tag' => $values->id_tag,
            'priority' => $values->priority
        );
        $row->update($new);
        return $id;
    }

    /**
     * Metoda odebere příspěvěk, pokud neexistuje vrací NoDataFound.
     * @param array  $values
     */
    public function deletePost($id)
    {
        $row = $this->database->table('posts')->where(array("id" => $id));
        if(!$row->fetch()) {
            throw new NoDataFound();
        }
        $row->delete();
    }
}