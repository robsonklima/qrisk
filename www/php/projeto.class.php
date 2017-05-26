<?php

require_once('database.php');

class Projeto extends DatabaseObject
{
    protected static $table_name = "projeto";
    
    // atributos
    private $id;
    private $nome;
    private $escopo;
    private $data_cadastro;
    private $id_usuario;
    private $id_status;
    private $usuario_nome;
    private $status_nome;
    private $qtd_riscos;
    private $categoria_nome;
    private $risco_titulo;
    private $risco_tipo_nome;
    private $analise_probabilidade;
    private $analise_custo;
    private $projeto_valor;
    private $projeto_impacto;
    private $valor_esperado;
    
    // getters and setters
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
    
    public function getEscopo()
    {
        return $this->escopo;
    }
    public function setEscopo($escopo)
    {
        $this->escopo = $escopo;
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
    
    public function getDataCadastro()
    {
        return $this->data_cadastro;
    }
    
    public function getUsuarioNome()
    {
        return $this->usuario_nome;
    }
    
    public function getStatusNome()
    {
        return $this->status_nome;
    }
    
    public function getQtdRiscos()
    {
        return $this->qtd_riscos;
    }
    
    public function getCategoriaNome()
    {
        return $this->categoria_nome;
    }
    
    public function getRiscoTitulo()
    {
        return $this->risco_titulo;
    }
    
    public function getRiscoTipoNome()
    {
        return $this->risco_tipo_nome;
    }
    
    public function getAnaliseProbabilidade()
    {
        return $this->analise_probabilidade;
    }
    
    public function getAnaliseCusto()
    {
        return $this->analise_custo;
    }
    
    public function getProjetoValor()
    {
        return $this->projeto_valor;
    }
    
    public function getProjetoImpacto()
    {
        return $this->projeto_impacto;
    }
    
    public function getValorEsperado()
    {
        return $this->valor_esperado;
    }
    
    // metodos de manipulacao de dados
    public function adicionar() 
    {
        global $database;
        $sql  = "INSERT INTO ".static::$table_name." (";
        $sql .= "nome, escopo, id_usuario, data_cadastro, id_status";
        $sql .= ") VALUES ('";
        $sql .= $database->escape_value($this->nome)."', '";
        $sql .= $database->escape_value($this->escopo)."', ";
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
    
    public function atualizar() 
    {
        global $database;
        $sql  = "UPDATE " . static::$table_name . " SET ";
        $sql .= " nome='". $database->escape_value($this->nome) ."', ";
        $sql .= " escopo='". $database->escape_value($this->escopo) ."', ";
        $sql .= " data_atualizacao = NOW(), ";
        $sql .= " id_status=". $database->escape_value($this->id_status) ."";
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
    
    // metodos de pesquisa
    public static function buscar_por_id($id = 0)
    {
        $result_array = self::buscar_por_sql("
            SELECT      
                        pr.id
                        , pr.nome
                        , pr.escopo
                        , pr.id_usuario
                        , date_format(pr.data_cadastro,'%d/%m/%Y às %H:%i') as data_cadastro
                        , pr.id_status
                        , us.nome as usuario_nome
                        , st.nome as status_nome
                        , (SELECT COUNT(*) FROM risco_projeto rp WHERE rp.id_projeto = {$id}) as qtd_riscos
                        , CONCAT('R$ ', format((select ROUND(IFNULL(SUM(rf.valor_hora * de.qtd_horas),0),2)
                            from projeto pr
                            inner join demanda de on de.id_projeto = pr.id
                            inner join recurso re on de.id_recurso = re.id
                            inner join recurso_funcao rf on re.id_recurso_funcao = rf.id
                            WHERE pr.id = {$id}), 2)) projeto_valor
            FROM        " . static::$table_name . " pr
            INNER JOIN	usuario us on pr.id_usuario = us.id
            INNER JOIN	status st on pr.id_status = st.id
            WHERE       (1=1)
            AND         pr.id={$id} 
            LIMIT 1");
        return !empty($result_array) ? array_shift($result_array) : false;
    }
    
    public static function buscar_por_nome($nome = '')
    {
        $result_array = self::buscar_por_sql(" SELECT * FROM ".static::$table_name." WHERE nome = '".$nome."' LIMIT 1");
        return !empty($result_array) ? array_shift($result_array) : false;
    }
    
    public static function buscar_todos()
    {
        return self::buscar_por_sql("
            SELECT      pr.* 
                        , (select count(1) from risco_projeto rp where rp.id_projeto = pr.id) as qtd_riscos
            FROM        ". static::$table_name." pr
            ORDER BY    pr.nome ASC");
    }
    
    public static function buscar_todos_por_id_risco($id_risco = 0)
    {
        return self::buscar_por_sql("
            SELECT      
                        pr.id
                        , pr.nome
            FROM        projeto pr
            inner join	risco_projeto rp on rp.id_projeto = pr.id
            WHERE       (1=1)
            AND         rp.id_risco = {$id_risco}
            Order by	pr.nome ASC");
    }
    
    // projetos vinculados ao recurso do usuario
    public static function buscar_todos_por_id_usuario($id_usuario = 0)
    {
        return self::buscar_por_sql("
            SELECT      
                        p.*
            FROM        projeto p
            inner join	demanda d on p.id = d.id_projeto
            inner join	recurso r on r.id = d.id_recurso
            inner join	usuario u on u.id = r.id_usuario
            WHERE       (1=1)
            and			u.id = {$id_usuario}
            Group By    p.id
            Order by	p.nome ASC");
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
    
    // metodos internos da classe
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