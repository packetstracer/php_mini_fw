<?php

class mainModel extends Model
{

    public function getArrayContent()
    {
        return array('1' => 1, '2' => 2, '3' => 3, '4' => 4);
    }


    public function getCentros()
    {
        return $this->db_model->getCentros();
    }


    public function getCentroById($id)
    {
        if (!is_numeric($id))
        {
            return false;
        }

        return $this->db_model->getCentroById($id);
    }


    public function getCentrosTransaction()
    {
        return $this->db_model->getCentrosTransaction();
    }

}

?>