<?php

require_once('initialize.php');

if(isset($_REQUEST["acao"])){ $acao = $_REQUEST["acao"]; } 

switch ($acao) {
        
    case "buscar_riscos_disp_analise":
        
        $postdata = json_decode(file_get_contents("php://input"));
        $id_usuario = (int)$postdata->id_usuario;
        
        $array = Risco::buscar_riscos_disp_analise($id_usuario);
        $c = 0;
        foreach($array as $item):
            $result[$c] = array(
              'id' => $item->getId(),
              'titulo' => $item->getTitulo(),
              'projeto_nome' => $item->getProjetoNome(),
              'causa' => $item->getCausa(),
              'efeito' => $item->getEfeito(),
              'id_risco_tipo' => $item->getIdRiscoTipo(),
              'id_projeto' => $item->getIdProjeto(),
              'id_ear_categoria' => $item->getIdEarCategoria(),
              'id_usuario' => $item->getIdUsuario(),
              'id_status' => $item->getIdStatus(),
              'is_analisado' => $item->getIsAnalisado()
            );
            $c++;
        endforeach;

        $json = json_encode($result);
        if ($c > 0) echo $json;
        
        break;
        
    case "buscar_tipo_custo":
        
        $array = RiscoAnaliseReferencia::buscar_tipo_custo();
        $c = 0;
        foreach($array as $item):
            $result[$c] = array(
              'id' => $item->getId(),
              'descricao' => $item->getDescricao(),
              'tipo' => $item->getTipo(),
              'peso' => $item->getPeso(),
              'id_status' => $item->getIdStatus()
            );
            $c++;
        endforeach;

        $json = json_encode($result);
        if ($c > 0) echo $json;
        
        break;
        
    case "buscar_tipo_cronograma":
        
        $array = RiscoAnaliseReferencia::buscar_tipo_cronograma();
        $c = 0;
        foreach($array as $item):
            $result[$c] = array(
              'id' => $item->getId(),
              'descricao' => $item->getDescricao(),
              'tipo' => $item->getTipo(),
              'peso' => $item->getPeso(),
              'id_status' => $item->getIdStatus()
            );
            $c++;
        endforeach;

        $json = json_encode($result);
        if ($c > 0) echo $json;
        
        break;
        
    case "buscar_tipo_escopo":
        
        $array = RiscoAnaliseReferencia::buscar_tipo_escopo();
        $c = 0;
        foreach($array as $item):
            $result[$c] = array(
              'id' => $item->getId(),
              'descricao' => $item->getDescricao(),
              'tipo' => $item->getTipo(),
              'peso' => $item->getPeso(),
              'id_status' => $item->getIdStatus()
            );
            $c++;
        endforeach;

        $json = json_encode($result);
        if ($c > 0) echo $json;
        
        break;
        
    case "buscar_tipo_qualidade":
        
        $array = RiscoAnaliseReferencia::buscar_tipo_qualidade();
        $c = 0;
        foreach($array as $item):
            $result[$c] = array(
              'id' => $item->getId(),
              'descricao' => $item->getDescricao(),
              'tipo' => $item->getTipo(),
              'peso' => $item->getPeso(),
              'id_status' => $item->getIdStatus()
            );
            $c++;
        endforeach;

        $json = json_encode($result);
        if ($c > 0) echo $json;
        
        break;
        
    case "buscar_tipo_probabilidade":
        
        $array = RiscoAnaliseReferencia::buscar_tipo_probabilidade();
        $c = 0;
        foreach($array as $item):
            $result[$c] = array(
              'id' => $item->getId(),
              'descricao' => $item->getDescricao(),
              'tipo' => $item->getTipo(),
              'peso' => $item->getPeso(),
              'id_status' => $item->getIdStatus()
            );
            $c++;
        endforeach;

        $json = json_encode($result);
        if ($c > 0) echo $json;
        
        break;
        
    case "buscar_por_id":
        
        $postdata = json_decode(file_get_contents("php://input"));
        $id = (int)$postdata->id;
        $result = array();

        $item = RiscoAnalise::buscar_por_id($id);

        $result = array(
          'id' => $item->getId(),
          'titulo' => $item->getTitulo(),
          'causa' => $item->getCausa(),
          'efeito' => $item->getEfeito(),
          'id_risco_tipo' => $item->getIdRiscoTipo(),
          'id_projeto' => $item->getIdProjeto(),
          'id_ear_categoria' => $item->getIdEarCategoria(),
          'id_usuario' => $item->getIdUsuario(),
          'id_status' => $item->getIdStatus()
        );

        $json = json_encode($result);
        echo $json;
        
        break;
        
    case "buscar_analise_projeto":
        
        $postdata = json_decode(file_get_contents("php://input"));
        $item = RiscoAnalise::buscar_analise_projeto((int)$postdata->id);

        $result = array(
          'grau_qualificacao' => $item->getGrauQualificacao(),
          'impacto_consolidado' => $item->getImpactoConsolidado(),
          'probabilidade' => $item->getProbabilidade(),
          'peso_geral' => $item->getPesoGeral(),
          'qtd_riscos' => $item->getQtdRiscos(),
          'risco_geral' => $item->getRiscoGeral()  
        );

        $json = json_encode($result);
        echo $json;
        
        break;
        
    case "buscar_analise_geral_risco":
        
        $postdata = json_decode(file_get_contents("php://input"));
        $result = array();
        
        $array = RiscoAnalise::buscar_analise_geral_risco((int)$postdata->id);
        
        $c = 0;
        foreach($array as $item):
            $result[$c] = array(
              'id_projeto' => $item->getIdProjeto(),
              'projeto_nome' => $item->getProjetoNome(),
              'custo' => $item->getCusto(),
              'cronograma' => $item->getCronograma(),
              'escopo' => $item->getEscopo(),
              'qualidade' => $item->getQualidade(),
              'impacto_consolidado' => $item->getImpactoConsolidado(),
              'probabilidade' => $item->getProbabilidade(),
              'grau_qualificacao' => $item->getGrauQualificacao(),
              'prioridade' => $item->getPrioridade()
            );
            $c++;
        endforeach;

        $json = json_encode($result);
        if ($c > 0) echo $json;
        
        break;
     
    case "buscar_analise_detalhada_risco":
        
        $postdata = json_decode(file_get_contents("php://input"));
        $result = array();
        
        $array = RiscoAnalise::buscar_analise_detalhada_risco((int)$postdata->id);
        
        $c = 0;
        foreach($array as $item):
            $result[$c] = array(
              'id' => $item->getId(),
              'projeto_nome' => $item->getProjetoNome(),
              'id_risco' => $item->getIdRisco(),
              'risco_nome' => $item->getRiscoNome(),  
              'usuario_nome' => $item->getUsuarioNome(),
              'data_cadastro' => $item->getDataCadastro(),
              'custo' => $item->getCusto(),
              'cronograma' => $item->getCronograma(),
              'escopo' => $item->getEscopo(),
              'qualidade' => $item->getQualidade(),
              'probabilidade' => $item->getProbabilidade()
            );
            $c++;
        endforeach;

        $json = json_encode($result);
        if ($c > 0) echo $json;
        
        break;
        
    case "buscar_analise_detalhada_risco_por_usuario":
        
        $postdata = json_decode(file_get_contents("php://input"));
        $result = array();
        
        $array = RiscoAnalise::buscar_analise_detalhada_risco_por_usuario((int)$postdata->id);
        
        $c = 0;
        foreach($array as $item):
            $result[$c] = array(
              'id' => $item->getId(),
              'projeto_nome' => $item->getProjetoNome(),
              'id_risco' => $item->getIdRisco(),
              'risco_nome' => $item->getRiscoNome(),  
              'usuario_nome' => $item->getUsuarioNome(),
              'data_cadastro' => $item->getDataCadastro(),
              'custo' => $item->getCusto(),
              'cronograma' => $item->getCronograma(),
              'escopo' => $item->getEscopo(),
              'qualidade' => $item->getQualidade(),
              'probabilidade' => $item->getProbabilidade()
            );
            $c++;
        endforeach;

        $json = json_encode($result);
        if ($c > 0) echo $json;
        
        break;
        
    case "buscar_valores_esperados_por_id_proj":
        
        $postdata = json_decode(file_get_contents("php://input"));
        
        $result = array();
        $item = RiscoAnalise::buscar_valores_esperados_por_id_proj((int)$postdata->id);

        $result = array(
          'melhor_caso' => $item->getMelhorCaso(),
          'valor_base' => $item->getValorBase(),
          'valor_esperado' => $item->getValorEsperado(),
          'pior_caso' => $item->getPiorCaso(),
        );

        $json = json_encode($result);
        echo $json;
        
        break;
        
    case "buscar_riscos_mais_criticos":
        
        $array = RiscoAnalise::buscar_riscos_mais_criticos();
        $c = 0;
        foreach($array as $item):
            $result[$c] = array(
              'id_risco' => $item->getIdRisco(),
              'id_projeto' => $item->getIdProjeto(),
              'risco_nome' => $item->getRiscoNome(),
              'projeto_nome' => $item->getProjetoNome(),
              'probabilidade' => $item->getProbabilidade(),
              'impacto_consolidado' => $item->getImpactoConsolidado(),
              'grau_qualificacao' => $item->getGrauQualificacao(),
              'prioridade' => $item->getPrioridade()
            );
            $c++;
        endforeach;

        $json = json_encode($result);
        if ($c > 0) echo $json;
        
        break;
    
    case "adicionar":
        
        $postdata = json_decode(file_get_contents("php://input"));
        
        $object = new RiscoAnalise();
        
        $object->setCusto($postdata->custo);
        $object->setCronograma($postdata->cronograma);
        $object->setEscopo($postdata->escopo);
        $object->setQualidade($postdata->qualidade);
        $object->setProbabilidade($postdata->probabilidade);
        $object->setIdUsuario($postdata->id_usuario);
        $object->setIdRisco($postdata->id_risco);
        $object->setIdProjeto($postdata->id_projeto);

        if($object->adicionar()) { 
            echo "Análise adicionada com sucesso!"; 
            
            salva_log('Análise de Risco Adicionada', 'Usuário Id: '.$postdata->id_usuario);
        } else { /* Failure */ }

        break;  
        
     case "apagar":
        
        $postdata = json_decode(file_get_contents("php://input"));
        
        $object = RiscoAnalise::buscar_por_id((int)$postdata->recordId);

        if($object && $object->apagar()) { echo "Análise deletada com sucesso!"; } else { /* Failure */ }
        
        break;
        
    default: "";
        
    default: "";
}

exit;

  