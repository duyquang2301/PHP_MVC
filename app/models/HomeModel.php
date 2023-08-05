<?php
class HomeModel extends Model
{
    protected $_table = 'khachhang';

    function tableFill()
    {
        return 'khachhang';
    }

    function fieldFill()
    {
        return '*';
    }

    public function getList()
    {
        $data = $this->db->query("SELECT * FROM $this->_table")->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
}
