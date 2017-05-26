<?php

require_once('initialize.php');

if(isset($_REQUEST["acao"])){ $acao = $_REQUEST["acao"]; } 

switch ($acao) {
        
    case "adicionar":
        
        $postdata = json_decode(file_get_contents("php://input"));
        
        $object = new Risco();
        
        $object->setTitulo($postdata->titulo);
        $object->setCausa($postdata->causa);
        $object->setEfeito($postdata->efeito);
        $object->setIdRiscoTipo($postdata->id_risco_tipo);
        $object->setIdEarCategoria($postdata->id_ear_categoria);
        $object->setIdUsuario($postdata->id_usuario);
        $object->setIdStatus($postdata->id_status);

        if($object->adicionar()) { echo "Risco adicionado com sucesso!"; } else { /* Failure */ }

        break;    
    
    case "atualizar":
        
        $postdata = json_decode(file_get_contents("php://input"));

        $object = Risco::buscar_por_id($postdata->id);
        
        $object->setTitulo($postdata->titulo);
        $object->setCausa($postdata->causa);
        $object->setEfeito($postdata->efeito);
        $object->setIdRiscoTipo($postdata->id_risco_tipo);
        $object->setIdEarCategoria($postdata->id_ear_categoria);
        $object->setIdStatus($postdata->id_status);

        if($object->atualizar()) { echo "Risco atualizado com sucesso!"; } else { echo "Nenhuma alteração realizada!"; }
        
        break;
        
    case "apagar":
        
        $postdata = json_decode(file_get_contents("php://input"));
        
        $risco = Risco::buscar_por_id($postdata->recordId);

        if($risco && $risco->apagar()) { echo "Risco deletado com sucesso!"; } else { /* Failure */ }
        
        break;
        
    case "buscar_todos":
        
        $array = Risco::buscar_todos();
        $c = 0;
        foreach($array as $item):
            $result[$c] = array(
              'id' => $item->getId(),
              'titulo' => $item->getTitulo(),
              'causa' => $item->getCausa(),
              'efeito' => $item->getEfeito(),
              'id_risco_tipo' => $item->getIdRiscoTipo(),
              'risco_tipo_nome' => $item->getRiscoTipoNome(),
              'id_ear_categoria' => $item->getIdEarCategoria(),
              'ear_categoria_nome' => $item->getEarCategoriaNome(),
              'id_usuario' => $item->getIdUsuario(),
              'id_status' => $item->getIdStatus(),
              'nome_status' => $item->getStatusNome(),
              'qtd_analises' => $item->getQtdAnalises()
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

        $item = Risco::buscar_por_id($id);

        $result = array(
          'id' => $item->getId(),
          'titulo' => $item->getTitulo(),
          'causa' => $item->getCausa(),
          'efeito' => $item->getEfeito(),
          'id_risco_tipo' => $item->getIdRiscoTipo(),
          'id_ear_categoria' => $item->getIdEarCategoria(),
          'id_usuario' => $item->getIdUsuario(),
          'id_status' => $item->getIdStatus(),
          'status_nome' => $item->getStatusNome(),
          'risco_tipo_nome' => $item->getRiscoTipoNome(),
          'ear_categoria_nome' => $item->getEarCategoriaNome(),
          'qtd_analises' => $item->getQtdAnalises()
        );

        $json = json_encode($result);
        echo $json;
        
        break;
        
    case "buscar_por_id_risco_e_id_projeto":
        
        $postdata = json_decode(file_get_contents("php://input"));
        $id_risco = (int)$postdata->id_risco;
        $id_projeto = (int)$postdata->id_projeto;
        $result = array();

        $item = Risco::buscar_por_id_risco_e_id_projeto($id_risco, $id_projeto);

        $result = array(
          'id' => $item->getId(),
          'titulo' => $item->getTitulo(),
          'id_projeto' => $item->getIdProjeto(),
          'projeto_nome' => $item->getProjetoNome(),
          'causa' => $item->getCausa(),
          'efeito' => $item->getEfeito(),
          'id_risco_tipo' => $item->getIdRiscoTipo(),
          'id_ear_categoria' => $item->getIdEarCategoria(),
          'id_usuario' => $item->getIdUsuario(),
          'id_status' => $item->getIdStatus()
        );

        $json = json_encode($result);
        echo $json;
        
        break;
        
    case "buscar_riscos_por_id_projeto":
        
        $postdata = json_decode(file_get_contents("php://input"));
        $array = Risco::buscar_riscos_por_id_projeto((int)$postdata->id);
        
        $c = 0;
        foreach($array as $item):  
            $result[$c] = array(
              'id' => $item->getId(),
              'titulo' => $item->getTitulo(),
              'risco_tipo_nome' => $item->getRiscoTipoNome(),
              'qtd_analises' => $item->getQtdAnalises(),
              'analise_custo' => $item->getCusto(),
              'analise_cronograma' => $item->getCronograma(),
              'analise_escopo' => $item->getEscopo(),
              'analise_qualidade' => $item->getQualidade(),
              'analise_probabilidade' => $item->getProbabilidade(),
              'impacto_consolidado' => $item->getImpactoConsolidado(),
              'grau_qualificacao' => $item->getGrauQualificacao(),
              'prioridade' => $item->getPrioridade(),
              'projeto_impacto' => $item->getProjetoImpacto(),
              'valor_esperado' => $item->getValorEsperado()
            );
            $c++;
        endforeach;

        $json = json_encode($result);
        if ($c > 0) echo $json;
        
        break;
        
    case "buscar_grafico_riscos_por_categorias":
        
        $array = Risco::buscar_grafico_riscos_por_categorias();
        
        $result = array(
            "chart" => array(
              "caption" => "Riscos por Categoria",
              "subCaption" => "Quantidade de Riscos por Categoria",
              "xaxisname" => "Categorias",
              "yaxisname" => "Quantidade de Riscos (Todos)",
              "theme" => "fint",
              "toolTipBorderColor" => "#FFFFFF",
              "toolTipBgColor" => "#666666",
              "toolTipBgAlpha" => "90",
              //"showToolTip" => "0",
              "placeValuesInside" => "0",
              "rotateValues" => "0",
              "valueFontColor" => "#000000",
              "decimals" => "2",
              "usePlotGradientColor" => "1"
            )
        );

        $result["data"] = array();
        
        $c = 0;
        foreach($array as $item):
            array_push($result["data"], array(
                "label" => $item->getEarCategoriaNome(),
                "value" => $item->getQtdRiscos()
                )
            );
        
            $c++;
        endforeach;

        $json = json_encode($result);
        if ($c > 0) echo $json;
        
        break;
        
    case "buscar_grafico_riscos_por_projetos":
        
        $array = Risco::buscar_grafico_riscos_por_projetos();
        
        $result["chart"] = array();
        $result = array(
            "chart" => array(
                "caption" => "Riscos por Projeto",
                "subcaption" => "Quantidade de Riscos por Projeto",
                "startingangle" => "120",
                "showlabels" => "0",
                "showlegend" => "1",
                "enablemultislicing" => "0",
                "slicingdistance" => "8",
                "showpercentvalues" => "1",
                "showpercentintooltip" => "0",
                "plottooltext" => 'Projeto : $label Total de Riscos : $datavalue',
                "theme" => "fint",
                //"showToolTip" => "0",
                "toolTipBorderColor" => "#FFFFFF",
                "toolTipBgColor" => "#666666",
                "toolTipBgAlpha" => "90"
            )
        );

        $result["data"] = array();
        $c = 0;
        foreach($array as $item):
            array_push($result["data"], array(
                "label" => $item->getProjetoNome(),
                "value" => $item->getQtdRiscos()
                )
            );
        
            $c++;
        endforeach;

        $json = json_encode($result);
        if ($c > 0) echo $json;
        
        break;
        
    case "buscar_grafico_riscos_por_demandas":
        
        $array = Risco::buscar_grafico_riscos_por_demandas();
        
        $result["chart"] = array();
        $result = array(
            "chart" => array(
                "caption" => "Riscos por Atividade",
                "subcaption" => "Quantidade de Riscos por Atividade",
                "startingangle" => "120",
                "showlabels" => "0",
                "showlegend" => "1",
                "enablemultislicing" => "0",
                "slicingdistance" => "8",
                "showpercentvalues" => "1",
                "showpercentintooltip" => "0",
                "plottooltext" => 'Atividade : $label Total de Riscos : $datavalue',
                "theme" => "fint",
                //"showToolTip" => "0",
                "toolTipBorderColor" => "#FFFFFF",
                "toolTipBgColor" => "#666666",
                "toolTipBgAlpha" => "90"
            )
        );

        $result["data"] = array();
        $c = 0;
        foreach($array as $item):
            array_push($result["data"], array(
                "label" => $item->getDemandaTitulo(),
                "value" => $item->getQtdRiscos()
                )
            );
        
            $c++;
        endforeach;

        $json = json_encode($result);
        if ($c > 0) echo $json;
        
        break;
        
    case "buscar_grafico_problemas_por_projetos":
        
        $array = Risco::buscar_grafico_problemas_por_projetos();
        
        $result["chart"] = array();
        $result = array(
            "chart" => array(
                "caption" => "Problemas por Projeto",
                "subcaption" => "Quantidade de Problemas por Projeto",
                "startingangle" => "120",
                "showlabels" => "0",
                "showlegend" => "1",
                "enablemultislicing" => "0",
                "slicingdistance" => "8",
                "showpercentvalues" => "1",
                "showpercentintooltip" => "0",
                "plottooltext" => 'Projeto : $label Total de Problemas : $datavalue',
                "theme" => "fint",
                //"showToolTip" => "0",
                "toolTipBorderColor" => "#FFFFFF",
                "toolTipBgColor" => "#666666",
                "toolTipBgAlpha" => "90"
            )
        );

        $result["data"] = array();
        $c = 0;
        foreach($array as $item):
            array_push($result["data"], array(
                "label" => $item->getProjetoNome(),
                "value" => $item->getQtdProblemas()
                )
            );
        
            $c++;
        endforeach;

        $json = json_encode($result);
        if ($c > 0) echo $json;
        
        break;
        
    case "buscar_grafico_problemas_por_demandas":
        
        $array = Risco::buscar_grafico_problemas_por_demandas();
        
        $result["chart"] = array();
        $result = array(
            "chart" => array(
                "caption" => "Problemas por Atividade",
                "subcaption" => "Quantidade de Problemas por Atividade",
                "startingangle" => "120",
                "showlabels" => "0",
                "showlegend" => "1",
                "enablemultislicing" => "0",
                "slicingdistance" => "8",
                "showpercentvalues" => "1",
                "showpercentintooltip" => "0",
                "plottooltext" => 'Atividade : $label Total de Problemas : $datavalue',
                "theme" => "fint",
                //"showToolTip" => "0",
                "toolTipBorderColor" => "#FFFFFF",
                "toolTipBgColor" => "#666666",
                "toolTipBgAlpha" => "90"
            )
        );

        $result["data"] = array();
        $c = 0;
        foreach($array as $item):
            array_push($result["data"], array(
                "label" => $item->getDemandaTitulo(),
                "value" => $item->getQtdProblemas()
                )
            );
        
            $c++;
        endforeach;

        $json = json_encode($result);
        if ($c > 0) echo $json;
        
        break;
        
    default: "";
}

exit;

  