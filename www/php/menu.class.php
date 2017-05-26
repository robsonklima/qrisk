<?php

require_once('database.php');

class Menu extends DatabaseObject
{
    protected static $table_name = "menu";
    private $id;
    private $nome;
    private $icone;
    private $url;
    private $ordem;
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
    
    public function getIcone()
    {
        return $this->icone;
    }
    public function setIcone($icone)
    {
        $this->icone = $icone;
    }
    
    public function getUrl()
    {
        return $this->url;
    }
    public function setUrl($url)
    {
        $this->url = $url;
    }
    
    public function getOrdem()
    {
        return $this->ordem;
    }
    public function setOrdem($ordem)
    {
        $this->ordem = $ordem;
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
        $sql .= "nome, icone, url, ordem, id_status";
        $sql .= ") VALUES ('";
        $sql .= $database->escape_value($this->nome)."', '";
        $sql .= $database->escape_value($this->icone)."', '";
        $sql .= $database->escape_value($this->url)."', ";
        $sql .= $database->escape_value($this->ordem).", ";
        $sql .= $database->escape_value($this->id_status).")";
        
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
        $sql .= " icone='". $database->escape_value($this->icone) ."', ";
        $sql .= " url='". $database->escape_value($this->url) ."', ";
        $sql .= " ordem=". $database->escape_value($this->ordem) .", ";
        $sql .= " id_status=". $database->escape_value($this->id_status) ."";
        $sql .= " WHERE id=". $database->escape_value($this->id);
        
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
        return self::buscar_por_sql("SELECT * FROM " . static::$table_name. " ORDER BY ordem ASC");
    }
    
    public static function buscar_por_id($id = 0)
    {
        $result_array = self::buscar_por_sql("SELECT * FROM " . static::$table_name . " WHERE id={$id} LIMIT 1");
        return !empty($result_array) ? array_shift($result_array) : false;
    }
    
    public static function buscar_por_id_usuario_perfil($id_usuario_perfil = 0)
    {
        return self::buscar_por_sql("
        SELECT 		me.*
        FROM 		" . static::$table_name . " me
        INNER JOIN 	usuario_perfil_menu up ON up.id_menu = me.id
        WHERE 		(1=1)
        AND			up.id_usuario_perfil = {$id_usuario_perfil}
        AND			me.id_status = 1
        GROUP BY 	me.id
        ORDER BY	me.ordem ASC");
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