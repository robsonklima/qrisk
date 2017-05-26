<?php

require_once('database.php');

class UsuarioPerfilMenu extends DatabaseObject
{
    protected static $table_name = "usuario_perfil_menu";
    private $id_usuario_perfil;
    private $id_menu;
    
    public function getIdUsuarioPerfil()
    {
        return $this->id_usuario_perfil;
    }
    public function setIdUsuarioPerfil($id_usuario_perfil)
    {
        $this->id_usuario_perfil = $id_usuario_perfil;
    }
    
    public function getIdMenu()
    {
        return $this->id_menu;
    }
    public function setIdMenu($id_menu)
    {
        $this->id_menu = $id_menu;
    }
    
    public static function buscar_todos_por_id_usuario_perfil($id_usuario_perfil=0)
    {
        return self::buscar_por_sql("SELECT id_menu FROM " . static::$table_name . " WHERE id_usuario_perfil={$id_usuario_perfil}");
    }
    
    public function adicionar() {
        global $database;
        $sql = "INSERT INTO " . static::$table_name . " (";
        $sql .= "id_usuario_perfil, id_menu";
        $sql .= ") VALUES (";
        $sql .= $database->escape_value($this->id_usuario_perfil).", ";
        $sql .= $database->escape_value($this->id_menu).") ";
        
        if($database->query($sql)) {
            $this->id = $database->insert_id();
            return true;
        } else {
            return false;
        }
    }
    
    public static function apagar($id_usuario_perfil = 0)
    {
        global $database;
        $sql = "DELETE FROM " . static::$table_name;
        $sql .= " WHERE id_usuario_perfil = {$id_usuario_perfil}";
        $database->query($sql);
        return ($database->affected_rows() > 0) ? true : false;
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