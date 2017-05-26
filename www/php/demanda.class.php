<?php

require_once('database.php');

class Demanda extends DatabaseObject
{
    protected static $table_name = "demanda";
    private $id;
    private $titulo;
    private $detalhes;
    private $data_entrega;
    private $qtd_horas;
    private $id_projeto;
    private $id_recurso;
    private $id_usuario;
    private $id_status;
    private $data_inicio;
    private $projeto_nome;
    private $recurso_nome;
    
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    
    public function getTitulo()
    {
        return $this->titulo;
    }
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }
    
    public function getDetalhes()
    {
        return $this->detalhes;
    }
    public function setDetalhes($detalhes)
    {
        $this->detalhes = $detalhes;
    }
    
    public function getDataInicio()
    {
        return $this->data_inicio;
    }
    public function setDataInicio($data_inicio)
    {
        $this->data_inicio = $data_inicio;
    }
    
    public function getDataEntrega()
    {
        return $this->data_entrega;
    }
    public function setDataEntrega($data_entrega)
    {
        $this->data_entrega = $data_entrega;
    }
    
    public function getQtdHoras()
    {
        return $this->qtd_horas;
    }
    public function setQtdHoras($qtd_horas)
    {
        $this->qtd_horas = $qtd_horas;
    }
    
    public function getIdProjeto()
    {
        return $this->id_projeto;
    }
    public function setIdProjeto($id_projeto)
    {
        $this->id_projeto = $id_projeto;
    }
    
    public function getIdRecurso()
    {
        return $this->id_recurso;
    }
    public function setIdRecurso($id_recurso)
    {
        $this->id_recurso = $id_recurso;
    }
    
    public function getIdUsuario()
    {
        return $this->id_usuario;
    }
    public function setIdUsuario($id_usuario)
    {
        $this->id_usuario = $id_usuario;
    }
    
    public function getIdStatus()
    {
        return $this->id_status;
    }
    public function setIdStatus($id_status)
    {
        $this->id_status = $id_status;
    }
    
    public function getProjetoNome()
    {
        return $this->projeto_nome;
    }
    
    public function getRecursoNome()
    {
        return $this->recurso_nome;
    }
    
    public function adicionar() {
        global $database;
        $sql = "INSERT INTO " . static::$table_name . " (";
        $sql .= "titulo, detalhes, data_inicio, data_entrega, qtd_horas, id_projeto, id_recurso, id_usuario, data_cadastro, id_status";
        $sql .= ") VALUES ('";
        $sql .= $database->escape_value($this->titulo)."', '";
        $sql .= $database->escape_value($this->detalhes)."', '";
        $sql .= $database->escape_value($this->data_inicio)."', '";
        $sql .= $database->escape_value($this->data_entrega)."', ";
        $sql .= $database->escape_value($this->qtd_horas).", ";
        $sql .= $database->escape_value($this->id_projeto).", ";
        $sql .= $database->escape_value($this->id_recurso).", ";
        $sql .= $database->escape_value($this->id_usuario).", ";
        $sql .= "NOW(), ";
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
        $sql .= " titulo='". $database->escape_value($this->titulo) ."',";
        $sql .= " detalhes='". $database->escape_value($this->detalhes) ."',";
        $sql .= " data_inicio='". $database->escape_value($this->data_inicio) ."',";
        $sql .= " data_entrega='". $database->escape_value($this->data_entrega) ."',";
        $sql .= " qtd_horas=". $database->escape_value($this->qtd_horas) .",";
        $sql .= " id_projeto=". $database->escape_value($this->id_projeto) .",";
        $sql .= " id_recurso=". $database->escape_value($this->id_recurso) .",";
        $sql .= " id_status=". $database->escape_value($this->id_status);
        $sql .= " WHERE id=". $database->escape_value($this->id);
        
        $database->query($sql);
        return ($database->affected_rows() == 1) ? true : false;
    }
    
    public function apagar()
    {
        global $database;
        $sql  = "DELETE FROM " . static::$table_name;
        $sql .= " WHERE id=" . $database->escape_value($this->id);
        $sql .= " LIMIT 1";
        $database->query($sql);
        return ($database->affected_rows() == 1) ? true : false;
    }
    
    // Common Database methods
    public static function buscar_todos()
    {
        return self::buscar_por_sql
            ("SELECT 
                    de.*
                    , pr.nome as projeto_nome
                    , substring_index(substring_index(re.nome, ' ', 1), ' ', -1) as recurso_nome 
                FROM ". static::$table_name." de
                inner join projeto pr on de.id_projeto = pr.id
                inner join recurso re on de.id_recurso = re.id
                
             ORDER BY titulo ASC");   
    }
    
    public static function buscar_por_id($id = 0)
    {
        $result_array = self::buscar_por_sql("SELECT * FROM " . static::$table_name . " WHERE id={$id} LIMIT 1");
        return !empty($result_array) ? array_shift($result_array) : false;
    }
    
    public static function buscar_por_titulo($titulo = '')
    {
        $result_array = self::buscar_por_sql(" SELECT * FROM ".static::$table_name." WHERE titulo = '".$titulo."' LIMIT 1");
        return !empty($result_array) ? array_shift($result_array) : false;
    }
    
    public static function buscar_por_id_usuario($id_usuario = 0)
    {
        return self::buscar_por_sql
            ("select 			d.*
                                , date_format(d.data_entrega,'%d/%m') as data_entrega                                
                                , p.nome as projeto_nome, r.nome as recurso_nome
                from 			demanda d
                inner join 		projeto p on p.id = d.id_projeto
                inner join 		recurso r on r.id = d.id_recurso
                inner join 		usuario u on u.id = r.id_usuario
                where			(1=1)
                and				u.id = {$id_usuario}
                order by 		d.data_cadastro");   
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