<?php

require_once('database.php');

class RiscoAnalise extends DatabaseObject
{
    protected static $table_name = "risco_analise";
    
    // atributos
    private $id;
    private $id_usuario;
    private $usuario_nome;
    private $id_risco;
    private $risco_nome;
    private $id_projeto;
    private $projeto_nome;
    private $data_cadastro;
    private $custo;
    private $cronograma;
    private $escopo;
    private $qualidade;
    private $prioridade;
    private $probabilidade;
    private $impacto_consolidado;
    private $grau_qualificacao;
    private $peso_geral;
    private $risco_geral;
    private $qtd_riscos;
    
    private $valor_esperado;
    private $valor_base;
    private $pior_caso;
    private $melhor_caso;
    
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    
    public function getCusto()
    {
        return $this->custo;
    }
    public function setCusto($custo)
    {
        $this->custo = $custo;
    }
    
    public function getCronograma()
    {
        return $this->cronograma;
    }
    public function setCronograma($cronograma)
    {
        $this->cronograma = $cronograma;
    }
    
    public function getEscopo()
    {
        return $this->escopo;
    }
    public function setEscopo($escopo)
    {
        $this->escopo = $escopo;
    }
    
    public function getQualidade()
    {
        return $this->qualidade;
    }
    public function setQualidade($qualidade)
    {
        $this->qualidade = $qualidade;
    }
    
    public function getProbabilidade()
    {
        return $this->probabilidade;
    }
    public function setProbabilidade($probabilidade)
    {
        $this->probabilidade = $probabilidade;
    }
    
    public function getIdUsuario()
    {
        return $this->id_usuario;
    }
    public function setIdUsuario($id_usuario)
    {
        $this->id_usuario = $id_usuario;
    }
    
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
    
    public function getDataCadastro()
    {
        return $this->data_cadastro;
    }
    public function setDataCadastro($data_cadastro)
    {
        $this->data_cadastro = $data_cadastro;
    }
    
    public function getImpactoConsolidado()
    {
        return $this->impacto_consolidado;
    }
    
    public function getGrauqualificacao()
    {
        return $this->grau_qualificacao;
    }
    
    public function getPrioridade()
    {
        return $this->prioridade;
    }
    
    public function getPesoGeral()
    {
        return $this->peso_geral;
    }
    
    public function getRiscoGeral()
    {
        return $this->risco_geral;
    }
    
    public function getQtdRiscos()
    {
        return $this->qtd_riscos;
    }
    
    public function getValorEsperado()
    {
        return $this->valor_esperado;
    }
    
    public function getValorBase()
    {
        return $this->valor_base;
    }
    
    public function getPiorCaso()
    {
        return $this->pior_caso;
    }
    
    public function getMelhorCaso()
    {
        return $this->melhor_caso;
    }
    
    public function getRiscoNome()
    {
        return $this->risco_nome;
    }
    
    public function getProjetoNome()
    {
        return $this->projeto_nome;
    }
    
    public function getUsuarioNome()
    {
        return $this->usuario_nome;
    }
    
    // metodos de manupulacao de dados
    public function adicionar() 
    {
        global $database;
        $sql = "INSERT INTO " . static::$table_name . " (";
        $sql .= "custo, cronograma, escopo, qualidade, probabilidade, id_usuario, id_risco, id_projeto, data_cadastro";
        $sql .= ") VALUES (";
        $sql .= $database->escape_value($this->custo).", ";
        $sql .= $database->escape_value($this->cronograma).", ";
        $sql .= $database->escape_value($this->escopo).", ";
        $sql .= $database->escape_value($this->qualidade).", ";
        $sql .= $database->escape_value($this->probabilidade).", ";
        $sql .= $database->escape_value($this->id_usuario).", ";
        $sql .= $database->escape_value($this->id_risco).", ";
        $sql .= $database->escape_value($this->id_projeto).", ";
        $sql .= "NOW())";
        
        if($database->query($sql)) {
            $this->id = $database->insert_id();
            return true;
        } else {
            return false;
        }
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
    
    // metodos de pesquisa de dados
    public static function buscar_analise_projeto($id_projeto = 0)
    {
        $result_array = self::buscar_por_sql("
            SELECT 		   MAX(grau_qualificacao) as grau_qualificacao
                            , MAX(impacto_consolidado) as impacto_consolidado
                            , MAX(probabilidade) as probabilidade
                            , SUM(grau_qualificacao) as peso_geral
                            , COUNT(id) as qtd_riscos
                            , CONCAT(ROUND(((SUM(grau_qualificacao) / COUNT(id)) / MAX(grau_qualificacao)), 2) *
                                100, '%') as risco_geral
            FROM
            (
                SELECT 
                                  ri.id
                                  , ROUND(AVG(ra.probabilidade),2) as probabilidade
                                  , GREATEST(ROUND(AVG(custo),2), ROUND(AVG(ra.cronograma),2)
                                      , ROUND(AVG(ra.escopo),2), ROUND(AVG(ra.qualidade),2)) as impacto_consolidado
                                  , (GREATEST(ROUND(AVG(custo),2), ROUND(AVG(ra.cronograma),2)
                                      , ROUND(AVG(ra.escopo),2), ROUND(AVG(ra.qualidade),2)) * ROUND(AVG(ra.probabilidade),2)) as grau_qualificacao
                FROM 			  risco_analise ra
                INNER JOIN		  risco ri on ra.id_risco = ri.id
                INNER JOIN		  projeto pr on ra.id_projeto = pr.id
                WHERE 			  (1=1)
                AND 			  ra.id_projeto = {$id_projeto}
                GROUP BY		  ri.id
            ) as dados");
        
        return !empty($result_array) ? array_shift($result_array) : false;
    }
   
    public static function buscar_analise_geral_risco($id = 0)
    {
        return self::buscar_por_sql("
            SELECT 
                         pr.id as id_projeto
                         , pr.nome as projeto_nome
                         , ri.titulo
                         , ifnull(ROUND(AVG(ra.custo),2), 'Pendente') as custo
                         , ifnull(ROUND(AVG(ra.cronograma),2), 'Pendente') as cronograma
                         , ifnull(ROUND(AVG(ra.escopo),2), 'Pendente') as escopo
                         , ifnull(ROUND(AVG(ra.qualidade),2), 'Pendente') as qualidade
                         , ifnull(ROUND(AVG(ra.probabilidade),2), 'Pendente') as probabilidade
                         , ifnull(GREATEST(ROUND(AVG(ra.custo),2), ROUND(AVG(ra.cronograma),2)
                             , ROUND(AVG(ra.escopo),2), ROUND(AVG(ra.qualidade),2)), 'Pendente') as impacto_consolidado
                         , ifnull((GREATEST(ROUND(AVG(custo),2), ROUND(AVG(cronograma),2)
                             , ROUND(AVG(ra.escopo),2), ROUND(AVG(ra.qualidade),2)) * ROUND(AVG(probabilidade),2)), 'Pendente') as grau_qualificacao
                         , CASE 
                             WHEN (GREATEST(ROUND(AVG(ra.custo),2), ROUND(AVG(ra.cronograma),2)
                                 , ROUND(AVG(ra.escopo),2), ROUND(AVG(ra.qualidade),2)) * ROUND(AVG(ra.probabilidade),2)) <= 0.3   
                             THEN 'Baixo'    
                             WHEN ((GREATEST(ROUND(AVG(ra.custo),2), ROUND(AVG(ra.cronograma),2)
                                 , ROUND(AVG(ra.escopo),2), ROUND(AVG(ra.qualidade),2)) * ROUND(AVG(ra.probabilidade),2)) > 0.3 
                                 AND (GREATEST(ROUND(AVG(ra.custo),2), ROUND(AVG(ra.cronograma),2)
                                 , ROUND(AVG(ra.escopo),2), ROUND(AVG(ra.qualidade),2)) * ROUND(AVG(ra.probabilidade),2)) <= 0.7)
                             THEN 'Medio'
                             WHEN (GREATEST(ROUND(AVG(ra.custo),2), ROUND(AVG(ra.cronograma),2)
                                 , ROUND(AVG(ra.escopo),2), ROUND(AVG(ra.qualidade),2)) * ROUND(AVG(ra.probabilidade),2)) > 0.7 
                             THEN 'Alto'
                             ELSE 'Pendente'
                           END AS prioridade
            FROM 		   risco_analise ra
            INNER JOIN	   projeto pr on ra.id_projeto = pr.id
            INNER JOIN	   risco ri on ra.id_risco = ri.id
            where 		   (1=1)
            AND			   ra.id_risco = {$id}
            Group By 	   pr.id");                                        
    }
    
    public static function buscar_analise_detalhada_risco($id = 0)
    {
        return self::buscar_por_sql("
            SELECT 			ra.*
                            , DATE_FORMAT(ra.data_cadastro, '%d/%c/%Y') as data_cadastro
                            , pr.nome as projeto_nome
                            , ri.titulo as risco_nome
                            , substring_index(substring_index(us.nome, ' ', 1), ' ', -1) as usuario_nome 
            FROM 			risco_analise ra
            INNER JOIN		projeto pr on ra.id_projeto = pr.id
            INNER JOIN		risco ri on ra.id_risco = ri.id
            INNER JOIN		usuario us on ra.id_usuario = us.id
            WHERE			(1=1)
            AND				ra.id_risco = {$id}");                                        
    }
    
    public static function buscar_analise_detalhada_risco_por_usuario($id = 0)
    {
        return self::buscar_por_sql("
            SELECT 			ra.*
                            , DATE_FORMAT(ra.data_cadastro, '%d/%c/%Y') as data_cadastro
                            , pr.nome as projeto_nome
                            , ri.titulo as risco_nome
                            , substring_index(substring_index(us.nome, ' ', 1), ' ', -1) as usuario_nome 
            FROM 			risco_analise ra
            INNER JOIN		projeto pr on ra.id_projeto = pr.id
            INNER JOIN		risco ri on ra.id_risco = ri.id
            INNER JOIN		usuario us on ra.id_usuario = us.id
            WHERE			(1=1)
            AND				ra.id_usuario = {$id}");                                        
    }
    
    public static function buscar_valores_esperados_por_id_proj($id = 0)
    {
        $result_array = self::buscar_por_sql("
            SELECT 	
                        CONCAT('R$ ', format((SUM(projeto_valor)/SUM(qtd_riscos)) - SUM(valor_impacto_oportunidade), 2)) as melhor_caso
                        , CONCAT('R$ ', format(SUM(projeto_valor)/SUM(qtd_riscos), 2)) as valor_base
                        , CONCAT('R$ ', format((SUM(projeto_valor)/SUM(qtd_riscos)) + SUM(valor_esperado_ameaca) - SUM(valor_esperado_oportunidade), 2)) as valor_esperado
                        , CONCAT('R$ ', format((SUM(projeto_valor)/SUM(qtd_riscos)) + SUM(valor_impacto_ameaca), 2)) as pior_caso
            FROM 
            (
                SELECT 			
                                risco_tipo_nome
                                , qtd_analises
                                , qtd_riscos
                                , projeto_valor
                                , (projeto_valor * custo) as projeto_impacto
                                , CASE WHEN risco_tipo_nome = 'Ameaça' THEN (probabilidade * (projeto_valor * custo)) ELSE 0 END as valor_esperado_ameaca
                                , CASE WHEN risco_tipo_nome = 'Ameaça' THEN (projeto_valor * custo) ELSE 0 END as valor_impacto_ameaca
                                , CASE WHEN risco_tipo_nome = 'Oportunidade' THEN (probabilidade * (projeto_valor * custo)) ELSE 0 END as valor_esperado_oportunidade
                                , CASE WHEN risco_tipo_nome = 'Oportunidade' THEN (projeto_valor * custo) ELSE 0 END as valor_impacto_oportunidade
                FROM
                (
                    SELECT 
                                    rt.nome as risco_tipo_nome
                                    , ROUND(AVG(ra.custo),2) as custo
                                    , ROUND(AVG(ra.probabilidade),2) as probabilidade
                                    , COUNT(distinct ra.id) as qtd_analises
                                    , COUNT(distinct ri.id) as qtd_riscos
                                    , (select 			ROUND(SUM(rf.valor_hora * de.qtd_horas), 2) as valor_base
                                        from 			projeto pr
                                        inner join 		demanda de on de.id_projeto = pr.id
                                        inner join 		recurso re on de.id_recurso = re.id
                                        inner join 		recurso_funcao rf on re.id_recurso_funcao = rf.id
                                        WHERE 			pr.id = {$id}
                                        Group by 		pr.id) as projeto_valor
                    FROM 			risco_analise ra
                    INNER JOIN		risco ri on ra.id_risco = ri.id
                    INNER JOIN		risco_tipo rt on ri.id_risco_tipo = rt.id
                    INNER join		ear_categoria ec on ri.id_ear_categoria = ec.id
                    INNER JOIN		projeto pr on ra.id_projeto = pr.id
                    WHERE 			(1=1)
                    AND 			ra.id_projeto = {$id}
                    GROUP BY		ri.id
                ) as dados
            ) as dados_2");
            
        return !empty($result_array) ? array_shift($result_array) : false;
    }
    
    public static function buscar_riscos_mais_criticos()
    {
        return self::buscar_por_sql ("
            SELECT 
                         ri.id as id_risco
                         , ri.titulo as risco_nome 
                         , pr.id as id_projeto
                         , pr.nome as projeto_nome
                         , GREATEST(ROUND(AVG(ra.custo),2), ROUND(AVG(ra.cronograma),2)
                             , ROUND(AVG(ra.escopo),2), ROUND(AVG(ra.qualidade),2)) as impacto_consolidado
						 , ROUND(AVG(ra.probabilidade),2) as probabilidade
                         , (GREATEST(ROUND(AVG(ra.custo),2), ROUND(AVG(ra.cronograma),2)
                             , ROUND(AVG(ra.escopo),2), ROUND(AVG(ra.qualidade),2)) * ROUND(AVG(ra.probabilidade),2)) as grau_qualificacao
                         , CASE 
                             WHEN (GREATEST(ROUND(AVG(custo),2), ROUND(AVG(ra.cronograma),2)
                                 , ROUND(AVG(ra.escopo),2), ROUND(AVG(ra.qualidade),2)) * ROUND(AVG(ra.probabilidade),2)) <= 0.3   
                             THEN 'Baixo'    
                             WHEN ((GREATEST(ROUND(AVG(ra.custo),2), ROUND(AVG(ra.cronograma),2)
                                 , ROUND(AVG(ra.escopo),2), ROUND(AVG(ra.qualidade),2)) * ROUND(AVG(ra.probabilidade),2)) > 0.3 
                                 AND (GREATEST(ROUND(AVG(custo),2), ROUND(AVG(cronograma),2)
                                 , ROUND(AVG(ra.escopo),2), ROUND(AVG(ra.qualidade),2)) * ROUND(AVG(ra.probabilidade),2)) <= 0.7)
                             THEN 'Medio'
                             WHEN (GREATEST(ROUND(AVG(ra.custo),2), ROUND(AVG(ra.cronograma),2)
                                 , ROUND(AVG(ra.escopo),2), ROUND(AVG(ra.qualidade),2)) * ROUND(AVG(ra.probabilidade),2)) > 0.7 
                             THEN 'Alto'
                             ELSE 'Pendente'
                           END AS prioridade
            FROM 		   risco_analise ra
            INNER JOIN	   risco ri on ra.id_risco = ri.id
            INNER JOIN	   projeto pr on ra.id_projeto = pr.id
            where 		   (1=1)
            Group by	   ri.id, pr.id
            Order By	   grau_qualificacao DESC
            LIMIT          0,10");   
    }
    
    public static function buscar_todos()
    {
        return self::buscar_por_sql
            ("SELECT * FROM ". static::$table_name." ORDER BY titulo ASC");   
    }
    
    public static function buscar_por_id($id = 0)
    {
        $result_array = self::buscar_por_sql("SELECT * FROM " . static::$table_name . " WHERE id={$id} LIMIT 1");
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