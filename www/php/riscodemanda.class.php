<?php

require_once('database.php');

class RiscoDemanda extends DatabaseObject
{
    protected static $table_name = "risco_demanda";
    private $id_risco;
    private $id_demanda;
    private $risco_titulo;
    private $is_problema;
    
    public function getIdRisco()
    {
        return $this->id_risco;
    }
    public function setIdRisco($id_risco)
    {
        $this->id_risco = $id_risco;
    }
    
    public function getIdDemanda()
    {
        return $this->id_demanda;
    }
    public function setIdDemanda($id_demanda)
    {
        $this->id_demanda = $id_demanda;
    }
    
    public function getRiscoTitulo()
    {
        return $this->risco_titulo;
    }
    
    public function getIsProblema()
    {
        return $this->is_problema;
    }
    
    public static function buscar_todos_por_id_demanda($id_demanda=0)
    {
        return self::buscar_por_sql(" 
            select 		rd.*, 
                        r.titulo as risco_titulo 
            from 		" . static::$table_name . " rd
            inner join 	risco r on r.id = rd.id_risco
            where 		(1=1)
            and			rd.id_demanda = '$id_demanda'");
    }
    
    public function adicionar() {
        global $database;
        $sql = "INSERT INTO " . static::$table_name . " (";
        $sql .= "id_risco, id_demanda";
        $sql .= ") VALUES (";
        $sql .= $database->escape_value($this->id_risco).", ";
        $sql .= $database->escape_value($this->id_demanda).") ";
        
        if($database->query($sql)) {
            $this->id = $database->insert_id();
            return true;
        } else {
            return false;
        }
    }
    
    public static function apagar($id_demanda = 0)
    {
        global $database;
        $sql = "DELETE FROM " . static::$table_name;
        $sql .= " WHERE id_demanda = {$id_demanda}";
        
        $database->query($sql);
        return ($database->affected_rows() > 0) ? true : false;
    }
    
    public static function marcar_risco_demanda_problema($id_risco=0, $id_demanda=0, $valor=0) {
        global $database;
        $sql  = "UPDATE " . static::$table_name . " SET ";
        $sql .= " is_problema='$valor', ";
        $sql .= " data_edicao=NOW()";
        $sql .= " WHERE id_risco=". $id_risco. " AND id_demanda=". $id_demanda;
        
        $database->query($sql);
        return ($database->affected_rows() == 1) ? true : false;
    }
    
    public static function buscar_por_sql($sql = "")
    {
        global $database;
        $result_set   = $database->query($sql);
        $object_array = array();
        while ($row = $database->fetch_array($result_set)) {
            $object_array[] = self::instantiate($row);
        }
        return $object_array;
    }
    
    // Others
    private static function instantiate($record)
    {
        $class_name = get_called_class();
        $object     = new $class_name;
        
        foreach ($record as $attribute => $value) {
            if ($object->has_attribute($attribute)) {
                $object->$attribute = $value;
            }
        }
        return $object;
    }
    
    private function has_attribute($attribute)
    {
        $object_vars = get_object_vars($this);
        return array_key_exists($attribute, $object_vars);
    }
    
}