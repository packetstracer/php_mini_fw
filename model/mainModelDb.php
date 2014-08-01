<?php

/**
 * Description of mainModelDb
 *
 * @author imerin
 */

class mainModelDb extends ModelDb
{

    public function getCentros()
    {
        $sql = "SELECT centro_id, centro FROM centros LIMIT 50";

        return $this->db->queryDb($sql, array(), true);
    }


    public function getCentroById($id)
    {
        $sql = "SELECT centro_id, centro FROM centros WHERE centro_id = ?";

        return $this->db->queryDb($sql, array($id), true);
    }


    public function getCentrosTransaction()
    {
        $sql = "SELECT centro_id, centro FROM centros LIMIT 50";
        $sql2 = "SELECT centro_id, centro FROM centros LIMIT 10";
        $sql_array = array($sql, $sql2);

        return $this->db->transaction($sql_array);
    }
    
}

?>