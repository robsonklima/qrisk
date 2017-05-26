<?php

require_once('database.php');

class RecursoFuncao extends DatabaseObject
{
    protected static $table_name = "recurso_funcao";
    private $id;
    private $nome;
    private $valor_hora;
    private $id_status;
    
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    
    public function getNome()
    {
        return $this->nome;
    }
    public function setNome($nome)
    {
        $this->nome = $nome;
    }
    
    public function getValorHora()
    {
        return $this->valor_hora;
    }
    public function setValorHora($valor_hora)
    {
        $this->valor_hora = $valor_hora;
    }
    
    public function getIdStatus()
    {
        return $this->id_status;
    }
    public function setIdStatus($id_status)
    {
        $this->id_status = $id_status;
    }
    
    public function adicionar() {
        global $database;
        $sql = "INSERT INTO " . static::$table_name . " (";
        $sql .= "nome, valor_hora, id_status";
        $sql .= ") VALUES ('";
        $sql .= $database->escape_value($this->nome)."', ";
        $sql .= $database->escape_value($this->valor_hora).", ";
        $sql .= $database->escape_value($this->id_status).")";
        
        //echo $sql;
        //die;
        
        if($database->query($sql)) {
            $this->id = $database->insert_id();
            return true;
        } else {
            return false;
        }
    }
    
    public function atualizar() {
        global $database;
        $sql  = "UPDATE " . static::$table_name . " SET ";
        $sql .= " nome='". $database->escape_value($this->nome) ."', ";
        $sql .= " valor_hora=". $database->escape_value($this->valor_hora) .", ";
        $sql .= " id_status=". $database->escape_value($this->id_status) ."";
        $sql .= " WHERE id=". $database->escape_value($this->id);
        
        //echo $sql;
        //die;
        
        $database->query($sql);
        return ($database->affected_rows() == 1) ? true : false;
    }
    
    public function apagar()
    {
        global $database;
        $sql = "DELETE FROM " . static::$table_name;
        $sql .= " WHERE id=" . $database->escape_value($this->id);
        $sql .= " LIMIT 1";
        $database->query($sql);
        return ($database->affected_rows() == 1) ? true : false;
    }
    
    // Common Database methods
    public static function buscar_todos()
    {
        return self::buscar_por_sql
            (
                " SELECT 
                    *
                  FROM 
                    ". static::$table_name."
                  ORDER BY
                    nome ASC"
            );   
    }
    
    public static function buscar_por_id($id = 0)
    {
        $result_array = self::buscar_por_sql("SELECT * FROM " . static::$table_name . " WHERE id={$id} LIMIT 1");
        return !empty($result_array) ? array_shift($result_array) : false;
    }
    
    public static function buscar_por_nome($nome = '')
    {
        $result_array = self::buscar_por_sql(" SELECT * FROM ".static::$table_name." WHERE nome = '".$nome."' LIMIT 1");
        return !empty($result_array) ? array_shift($result_array) : false;
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