<?php
abstract class Model extends Database
{
    protected $db;
    function __construct()
    {
        $this->db =  new Database();
    }

    abstract function tableFill();
    abstract function fieldFill();

    public function get()
    {
        $tableName = $this->tableFill();
        $fieldSelect = $this->fieldFill();

        if (empty($fieldFill)) {
            $fieldSelect = '*';
        }

        $sql = "SELECT $fieldSelect FROM $tableName";
        $query = $this->db->query($sql);
        if (!empty($query)) {
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return false;
    }
}
