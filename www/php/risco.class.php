<?php

require_once('database.php');

class Risco extends DatabaseObject
{
    protected static $table_name = "risco";
    
    // atributos
    private $id;
    private $titulo;
    private $causa;
    private $efeito;
    private $id_risco_tipo;
    private $id_ear_categoria;
    private $id_usuario;
    private $id_status;
    private $is_analisado;
    private $id_projeto;
    private $projeto_nome;
    private $demanda_titulo;
    private $risco_tipo_nome;
    private $ear_categoria_nome;
    private $usuario_nome;
    private $status_nome;
    private $qtd_analises;
    private $custo;
    private $cronograma;
    private $escopo;
    private $qualidade;
    private $probabilidade;
    private $impacto_consolidado;
    private $grau_qualificacao;
    private $prioridade;
    private $qtd_riscos;
    private $qtd_problemas;
    private $mes_nome;
    private $valor_esperado;
    private $projeto_impacto;
    
    //getters and setters
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
    
    public function getCausa()
    {
        return $this->causa;
    }
    public function setCausa($causa)
    {
        $this->causa = $causa;
    }
    
    public function getEfeito()
    {
        return $this->efeito;
    }
    public function setEfeito($efeito)
    {
        $this->efeito = $efeito;
    }
    
    public function getIdRiscoTipo()
    {
        return $this->id_risco_tipo;
    }
    public function setIdRiscoTipo($id_risco_tipo)
    {
        $this->id_risco_tipo = $id_risco_tipo;
    }
    
    public function getIdEarCategoria()
    {
        return $this->id_ear_categoria;
    }
    public function setIdEarCategoria($id_ear_categoria)
    {
        $this->id_ear_categoria = $id_ear_categoria;
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
    
    public function getIsAnalisado()
    {
        return $this->is_analisado;
    }
    
    public function getRiscoTipoNome()
    {
        return $this->risco_tipo_nome;
    }
    
    public function getEarCategoriaNome()
    {
        return $this->ear_categoria_nome;
    }
    
    public function getUsuarioNome()
    {
        return $this->usuario_nome;
    }
    
    public function getStatusNome()
    {
        return $this->status_nome;
    }
    
    public function getQtdAnalises()
    {
        return $this->qtd_analises;
    }
    
    public function getCusto()
    {
        return $this->custo;
    }
    
    public function getCronograma()
    {
        return $this->cronograma;
    }
    
    public function getEscopo()
    {
        return $this->escopo;
    }
    
    public function getQualidade()
    {
        return $this->qualidade;
    }
    
    public function getProbabilidade()
    {
        return $this->probabilidade;
    }
    
    public function getImpactoConsolidado()
    {
        return $this->impacto_consolidado;
    }
    
    public function getGrauQualificacao()
    {
        return $this->grau_qualificacao;
    }
    
    public function getPrioridade()
    {
        return $this->prioridade;
    }
    
    public function getQtdRiscos()
    {
        return $this->qtd_riscos;
    }
    
    public function getQtdProblemas()
    {
        return $this->qtd_problemas;
    }
    
    public function getMesNome()
    {
        return $this->mes_nome;
    }
    
    public function getIdProjeto()
    {
        return $this->id_projeto;
    }
    
    public function getProjetoNome()
    {
        return $this->projeto_nome;
    }
    
    public function getDemandaTitulo()
    {
        return $this->demanda_titulo;
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
        $sql = "INSERT INTO " . static::$table_name . " (";
        $sql .= "titulo, causa, efeito, id_risco_tipo, id_ear_categoria, id_usuario, data_cadastro, id_status";
        $sql .= ") VALUES ('";
        $sql .= $database->escape_value($this->titulo)."', '";
        $sql .= $database->escape_value($this->causa)."', '";
        $sql .= $database->escape_value($this->efeito)."', ";
        $sql .= $database->escape_value($this->id_risco_tipo).", ";
        $sql .= $database->escape_value($this->id_ear_categoria).", ";
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
        $sql .= " titulo='". $database->escape_value($this->titulo)."',";
        $sql .= " causa='". $database->escape_value($this->causa)."',";
        $sql .= " efeito='". $database->escape_value($this->efeito)."',";
        $sql .= " id_risco_tipo=". $database->escape_value($this->id_risco_tipo).",";
        $sql .= " id_ear_categoria=". $database->escape_value($this->id_ear_categoria).",";
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
    
    // busca de dados
    public static function buscar_por_id($id = 0)
    {
        $result_array = self::buscar_por_sql("
            SELECT 
                        ri.id
						, ri.titulo
						, ri.causa
						, ri.efeito
						, ri.id_risco_tipo
						, ri.id_ear_categoria
						, ri.id_usuario
						, ri.data_cadastro
						, ri.id_status
                        , st.nome as status_nome
                        , rt.nome as risco_tipo_nome
                        , ec.nome as ear_categoria_nome
                        , (SELECT COUNT(1) FROM risco_analise ra where ra.id_risco = ri.id) as qtd_analises
            FROM 
                        risco ri
            INNER JOIN	risco_tipo rt on ri.id_risco_tipo = rt.id
            INNER JOIN	usuario us on ri.id_usuario = us.id
            INNER JOIN	ear_categoria ec on ri.id_ear_categoria = ec.id
            INNER JOIN	status st on ri.id_status = st.id
            WHERE		(1=1)
            AND			ri.id = {$id}");
        
        return !empty($result_array) ? array_shift($result_array) : false;
    }
    
    public static function buscar_todos()
    {
        return self::buscar_por_sql("
            SELECT 
                        ri.*
                        , rt.nome as risco_tipo_nome
                        , ec.nome as ear_categoria_nome
                        , st.nome as status_nome
                        , (SELECT COUNT(1) FROM risco_analise ra WHERE ra.id_risco = ri.id) as qtd_analises
            FROM ". static::$table_name." ri
            INNER JOIN risco_tipo rt on ri.id_risco_tipo = rt.id
            INNER JOIN ear_categoria ec on ri.id_ear_categoria = ec.id
            INNER JOIN status st on ri.id_status = st.id
            ORDER BY titulo ASC");   
    }
    
    public static function buscar_riscos_disp_analise($id_usuario = 0)
    {
        return self::buscar_por_sql("
            SELECT 
                        distinct ri.id
                        , ri.titulo
                        , pr.nome as projeto_nome
                        , ri.causa
                        , ri.efeito
                        , ri.id_risco_tipo
                        , rp.id_projeto
                        , ri.id_ear_categoria
                        , ri.id_usuario
                        , ri.id_status
                        , (select 1 from risco_analise 
                            where risco_analise.id_risco = ri.id and risco_analise.id_projeto = pr.id
                            and risco_analise.id_usuario = {$id_usuario}) as is_analisado
            FROM 
                        risco ri
            INNER JOIN	risco_projeto rp on rp.id_risco = ri.id
            INNER JOIN  projeto pr on rp.id_projeto = pr.id
            INNER JOIN	demanda de on de.id_projeto = pr.id
            INNER JOIN  recurso re on de.id_recurso = re.id
            Where		(1=1)
            and			re.id_usuario = {$id_usuario}
            and			ri.id_status = 1
            and         (select 1 from risco_analise 
                            where risco_analise.id_risco = ri.id and risco_analise.id_projeto = pr.id
                            and risco_analise.id_usuario = {$id_usuario}) is null");
    }
    
    public static function buscar_por_id_risco_e_id_projeto($id_risco = 0, $id_projeto = 0)
    {
        $result_array = self::buscar_por_sql("
            SELECT 
                        ri.id
						, ri.titulo
                        , pr.id as id_projeto
						, pr.nome as projeto_nome
						, ri.causa
						, ri.efeito
						, ri.id_risco_tipo
						, ri.id_ear_categoria
						, ri.id_usuario
						, ri.data_cadastro
						, ri.id_status
            FROM 
                        risco ri
			INNER join	risco_projeto rp on rp.id_risco = ri.id
			INNER join	projeto pr on rp.id_projeto = pr.id
            INNER JOIN	risco_tipo rt on ri.id_risco_tipo = rt.id
            INNER JOIN	usuario us on ri.id_usuario = us.id
            INNER JOIN	ear_categoria ec on ri.id_ear_categoria = ec.id
            INNER JOIN	status st on ri.id_status = st.id
            WHERE		(1=1)
            AND			ri.id = {$id_risco}
			AND			rp.id_projeto = {$id_projeto}");
        
        return !empty($result_array) ? array_shift($result_array) : false;
    }
    
    public static function buscar_riscos_por_id_projeto($id_projeto = 0)
    {
        return self::buscar_por_sql("
            select 			
                            id
                            , titulo
                            , risco_tipo_nome
                            , ear_categoria_nome
                            , custo
                            , cronograma
                            , escopo
                            , qualidade
                            , CONCAT(probabilidade * 100, '%') as probabilidade
                            , impacto_consolidado
                            , grau_qualificacao
                            , prioridade
                            , qtd_analises
                            , projeto_valor
                            , concat('R$ ', format(projeto_valor * custo, 2)) as projeto_impacto
                            , concat('R$ ', format(probabilidade * (projeto_valor * custo), 2)) as valor_esperado
            FROM
            (
                SELECT 
                                ri.id
                                , ri.titulo
                                , rt.nome as risco_tipo_nome
                                , ec.nome as ear_categoria_nome
                                , ROUND(AVG(ra.custo),2) as custo
                                , ROUND(AVG(ra.cronograma),2) as cronograma
                                , ROUND(AVG(ra.escopo),2) as escopo
                                , ROUND(AVG(ra.qualidade),2) as qualidade
                                , ROUND(AVG(ra.probabilidade),2) as probabilidade
                                , GREATEST(ROUND(AVG(custo),2), ROUND(AVG(ra.cronograma),2)
                                    , ROUND(AVG(ra.escopo),2), ROUND(AVG(ra.qualidade),2)) as impacto_consolidado
                                , (GREATEST(ROUND(AVG(custo),2), ROUND(AVG(ra.cronograma),2)
                                    , ROUND(AVG(ra.escopo),2), ROUND(AVG(ra.qualidade),2)) * ROUND(AVG(ra.probabilidade),2)) as grau_qualificacao
                                , CASE 
                                    WHEN (GREATEST(ROUND(AVG(ra.custo),2), ROUND(AVG(ra.cronograma),2)
                                        , ROUND(AVG(ra.escopo),2), ROUND(AVG(qualidade),2)) * ROUND(AVG(probabilidade),2)) <= 0.3   
                                    THEN 'Baixo'    
                                    WHEN ((GREATEST(ROUND(AVG(custo),2), ROUND(AVG(ra.cronograma),2)
                                        , ROUND(AVG(ra.escopo),2), ROUND(AVG(qualidade),2)) * ROUND(AVG(ra.probabilidade),2)) > 0.3 
                                        AND (GREATEST(ROUND(AVG(custo),2), ROUND(AVG(ra.cronograma),2)
                                        , ROUND(AVG(ra.escopo),2), ROUND(AVG(ra.qualidade),2)) * ROUND(AVG(ra.probabilidade),2)) <= 0.7)
                                    THEN 'Medio'
                                    WHEN (GREATEST(ROUND(AVG(ra.custo),2), ROUND(AVG(ra.cronograma),2)
                                        , ROUND(AVG(ra.escopo),2), ROUND(AVG(ra.qualidade),2)) * ROUND(AVG(ra.probabilidade),2)) > 0.7 
                                    THEN 'Alto'
                                  ELSE 'Pendente'
                                END AS prioridade
                                , COUNT(ra.id) as qtd_analises
                                , (select 			ROUND(SUM(rf.valor_hora * de.qtd_horas), 2) as valor_base
                                    from 			projeto pr
                                    INNER JOIN 		demanda de on de.id_projeto = pr.id
                                    INNER JOIN 		recurso re on de.id_recurso = re.id
                                    INNER JOIN 		recurso_funcao rf on re.id_recurso_funcao = rf.id
                                    WHERE 			pr.id = {$id_projeto}
                                    GROUP BY 		pr.id) as projeto_valor
                FROM 			risco_analise ra
                INNER JOIN		risco ri on ra.id_risco = ri.id
                INNER JOIN		risco_tipo rt on ri.id_risco_tipo = rt.id
                INNER join		ear_categoria ec on ri.id_ear_categoria = ec.id
                INNER JOIN		projeto pr on ra.id_projeto = pr.id
                WHERE 			(1=1)
                AND 			ra.id_projeto = {$id_projeto}
                GROUP BY		ri.id
            ) as dados");
    }
    
    // metodos de montagem dos graficos
    public static function buscar_grafico_riscos_por_categorias()
    {
        return self::buscar_por_sql("
            SELECT 			ec.nome as ear_categoria_nome, count(ri.id) as qtd_riscos
            FROM 			risco ri
            INNER JOIN		ear_categoria ec on ri.id_ear_categoria = ec.id
            GROUP BY		ec.nome");
    }
    
    
    public static function buscar_grafico_riscos_por_projetos()
    {
        return self::buscar_por_sql("
            SELECT 			pr.nome as projeto_nome, count(ri.id) as qtd_riscos
            FROM 			risco ri
            INNER JOIN		risco_projeto rp on rp.id_risco = ri.id
            INNER JOIN		projeto pr on rp.id_projeto = pr.id
            GROUP BY		pr.nome");
    }
    
    public static function buscar_grafico_riscos_por_demandas()
    {
        return self::buscar_por_sql("
            SELECT 			de.titulo as demanda_titulo, count(ri.id) as qtd_riscos
            FROM 			risco ri
            INNER JOIN		risco_demanda rd on rd.id_risco = ri.id    
            INNER JOIN		demanda de on de.id = rd.id_demanda
            GROUP BY		de.titulo");
    }
    
    public static function buscar_grafico_problemas_por_projetos()
    {
        return self::buscar_por_sql("
            SELECT 			pr.nome as projeto_nome, count(rp.is_problema) as qtd_problemas
            FROM			risco_projeto rp
            INNER JOIN		projeto pr on rp.id_projeto = pr.id
            WHERE			(1=1)
            and				rp.is_problema = 1
            GROUP BY		pr.nome");
    }
    
    public static function buscar_grafico_problemas_por_demandas()
    {
        return self::buscar_por_sql("
            SELECT 			de.titulo as demanda_titulo, count(rd.is_problema) as qtd_problemas
            FROM			risco_demanda rd
            INNER JOIN		demanda de on rd.id_demanda = de.id
            WHERE			(1=1)
            and				rd.is_problema = 1
            GROUP BY		de.titulo");
    }
    
    public static function buscar_grafico_riscos_por_meses()
    {
        return self::buscar_por_sql("
            SELECT 
                        COUNT(id) as qtd_riscos
                        , MONTH(ri.data_cadastro) as mes_numero
                        , YEAR(ri.data_cadastro) as ano_numero
                        , CASE MONTHNAME(ri.data_cadastro)
                            when 'January' then 'Janeiro'
                            when 'February' then 'Fevereiro'
                            when 'March' then 'Março'
                            when 'April' then 'Abril'
                            when 'May' then 'Maio'
                            when 'June' then 'Junho'
                            when 'July' then 'Julho'
                            when 'August' then 'Agosto'
                            when 'September' then 'Setembro'
                            when 'October' then 'Outubro'
                            when 'November' then 'Novembri'
                            when 'December' then 'Dezembro' END as mes_nome
            FROM risco ri
            GROUP BY mes_numero, ano_numero, mes_nome
            ORDER BY ano_numero, mes_numero ASC");
    }
    
    // metodos internos da classe
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