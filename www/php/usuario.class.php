<?php

require_once('database.php');

class Usuario extends DatabaseObject
{   
    protected static $table_name = "usuario";
    private $id;
    private $nome;
    private $login;
    private $senha;
    private $id_usuario_perfil;
    private $usuario_perfil_nome;
    private $id_status;
    private $status_nome;
    
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
    
    public function getLogin()
    {
        return $this->login;
    }
    public function setLogin($login)
    {
        $this->login = $login;
    }
    
    public function getSenha()
    {
        return $this->senha;
    }
    public function setSenha($senha)
    {
        $this->senha = $senha;
    }
    
    public function getIdUsuarioPerfil()
    {
        return $this->id_usuario_perfil;
    }
    public function setIdUsuarioPerfil($id_usuario_perfil)
    {
        $this->id_usuario_perfil = $id_usuario_perfil;
    }
    
    public function getIdStatus()
    {
        return $this->id_status;
    }
    public function setIdStatus($id_status)
    {
        $this->id_status = $id_status;
    }
    
    public function getUsuarioPerfilNome()
    {
        return $this->usuario_perfil_nome;
    }
    
    public function getStatusNome()
    {
        return $this->status_nome;
    }
    
    public static function authenticate($login = "", $senha = "")
    {
        global $database;
        $login = $database->escape_value($login);
        $senha = $database->escape_value($senha);
        
        $sql = "SELECT * FROM " . self::$table_name;
        $sql .= " WHERE login = '{$login}'";
        $sql .= " AND senha = '{$senha}'";
        $sql .= " LIMIT 1";
        $result_array = self::buscar_por_sql($sql);
        return !empty($result_array) ? array_shift($result_array) : false;
    }
    
    public function adicionar() {
        global $database;
        $sql = "INSERT INTO " . static::$table_name . " (";
        $sql .= "nome, login, senha, id_usuario_perfil, id_status";
        $sql .= ") VALUES ('";
        $sql .= $database->escape_value($this->nome)."', '";
        $sql .= $database->escape_value($this->login)."', '";
        $sql .= $database->escape_value($this->senha)."', ";
        $sql .= $database->escape_value($this->id_usuario_perfil).", ";
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
        $sql  = " UPDATE " . static::$table_name . " SET ";
        $sql .= " nome='". $database->escape_value($this->nome) ."',";
        $sql .= " login='". $database->escape_value($this->login) ."',";
        $sql .= " senha='". $database->escape_value($this->senha) ."',";
        $sql .= " id_usuario_perfil=". $database->escape_value($this->id_usuario_perfil) .",";
        $sql .= " id_status=". $database->escape_value($this->id_status)."";
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
    
    public static function buscar_todos()
    {
        return self::buscar_por_sql
            (" select 		
                usuario.id
                , usuario.nome
                , usuario.id_usuario_perfil
                , usuario.id_status
                , usuario_perfil.nome as usuario_perfil_nome
                , status.nome as status_nome
               FROM 		
                ". static::$table_name."
               inner join 	status on usuario.id_status = status.id
               inner join 	usuario_perfil on usuario.id_usuario_perfil = usuario_perfil.id
               order by 	
                usuario.nome ASC");   
    }
    
    public static function buscar_usu_sem_rec()
    {
        return self::buscar_por_sql
            (" SELECT * FROM ". static::$table_name." WHERE id NOT IN (select id_usuario from recurso) order by nome ASC");   
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