<?php

require_once('database.php');

class RiscoAnaliseReferencia extends DatabaseObject
{
    protected static $table_name = "risco_analise_referencia";
    
    private $id;
    private $descricao;
    private $tipo;
    private $peso;
    private $id_status;
    
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    
    public function getDescricao()
    {
        return $this->descricao;
    }
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }
    
    public function getTipo()
    {
        return $this->tipo;
    }
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }
    
    public function getPeso()
    {
        return $this->peso;
    }
    public function setPeso($peso)
    {
        $this->peso = $peso;
    }
    
    public function getIdStatus()
    {
        return $this->id_status;
    }
    public function setIdStatus($id_status)
    {
        $this->id_status = $id_status;
    }
   
    // Common Database methods
    public static function buscar_tipo_custo()
    {
        return self::buscar_por_sql
            ("SELECT * FROM ". static::$table_name." WHERE tipo='CUSTO' AND id_status = 1 ORDER BY peso ASC");   
    }
    
    public static function buscar_tipo_cronograma()
    {
        return self::buscar_por_sql
            ("SELECT * FROM ". static::$table_name." WHERE tipo='CRONOGRAMA' AND id_status = 1 ORDER BY peso ASC");   
    }
    
    public static function buscar_tipo_escopo()
    {
        return self::buscar_por_sql
            ("SELECT * FROM ". static::$table_name." WHERE tipo='ESCOPO' AND id_status = 1 ORDER BY peso ASC");   
    }
    
    public static function buscar_tipo_qualidade()
    {
        return self::buscar_por_sql
            ("SELECT * FROM ". static::$table_name." WHERE tipo='QUALIDADE' AND id_status = 1 ORDER BY peso ASC");   
    }
    
    public static function buscar_tipo_probabilidade()
    {
        return self::buscar_por_sql
            ("SELECT * FROM ". static::$table_name." WHERE tipo='PROBABILIDADE' AND id_status = 1 ORDER BY peso ASC");   
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