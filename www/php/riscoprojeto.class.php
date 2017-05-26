<?php

require_once('database.php');

class RiscoProjeto extends DatabaseObject
{
    protected static $table_name = "risco_projeto";
    private $id_risco;
    private $id_projeto;
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
    
    public function getIdProjeto()
    {
        return $this->id_projeto;
    }
    public function setIdProjeto($id_projeto)
    {
        $this->id_projeto = $id_projeto;
    }
    
    public function getRiscoTitulo()
    {
        return $this->risco_titulo;
    }
    
    public function getIsProblema()
    {
        return $this->is_problema;
    }
    
    public static function buscar_todos_por_id_projeto($id_projeto = 0)
    {
        return self::buscar_por_sql("
            select 		rp.*, 
                        r.titulo as risco_titulo 
            from 		" . static::$table_name . " rp
            inner join 	risco r on r.id = rp.id_risco
            where 		(1=1)
            and			rp.id_projeto = '$id_projeto'");
    }
    
    public function adicionar() {
        global $database;
        $sql = "INSERT INTO " . static::$table_name . " (";
        $sql .= "id_risco, id_projeto";
        $sql .= ") VALUES (";
        $sql .= $database->escape_value($this->id_risco).", ";
        $sql .= $database->escape_value($this->id_projeto).") ";
        
        if($database->query($sql)) {
            $this->id = $database->insert_id();
            return true;
        } else {
            return false;
        }
    }
    
    public static function apagar($id_projeto = 0)
    {
        global $database;
        $sql = "DELETE FROM " . static::$table_name;
        $sql .= " WHERE id_projeto = {$id_projeto}";
        $database->query($sql);
        return ($database->affected_rows() > 0) ? true : false;
    }
    
    public static function marcar_risco_projeto_problema($id_risco=0, $id_projeto=0, $valor=0) {
        global $database;
        $sql  = "UPDATE " . static::$table_name . " SET ";
        $sql .= " is_problema='$valor', ";
        $sql .= " data_edicao=NOW()";
        $sql .= " WHERE id_risco=". $id_risco. " AND id_projeto=". $id_projeto;
        
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