<?php

require_once('initialize.php');

if(isset($_REQUEST["acao"])){ $acao = $_REQUEST["acao"]; } 

switch ($acao) {
        
    case "adicionar":
        
        $postdata = json_decode(file_get_contents("php://input"));
        
        $demanda = new Demanda();
        $demanda->setTitulo($postdata->titulo);
        $demanda->setDetalhes($postdata->detalhes);
        $demanda->setDataInicio($postdata->data_inicio);
        $demanda->setDataEntrega($postdata->data_entrega);
        $demanda->setQtdHoras($postdata->qtd_horas);
        $demanda->setIdProjeto($postdata->id_projeto);
        $demanda->setIdRecurso($postdata->id_recurso);
        $demanda->setIdUsuario($postdata->id_usuario);
        $demanda->setIdStatus($postdata->id_status);
        
        if($demanda->adicionar()) {
            $riscos = array();
            $riscos = $postdata->riscos;
            
            if (sizeof($riscos)>0) {
                $c = 0;
                foreach($riscos as $risco):  
                    $riscoDemanda = new RiscoDemanda();
                    $riscoDemanda->setIdRisco($risco);
                    $riscoDemanda->setIdDemanda($demanda->getId());
                    $riscoDemanda->adicionar();    
                    $c++;
                endforeach;     
            }
            
            echo "Projeto inserido com sucesso!"; 
        } else { 
            /* Failure */ 
        }

        break;  
        
    case "buscar_todos":
        
        $array = Demanda::buscar_todos();
        $c = 0;
        foreach($array as $item):
            $result[$c] = array(
              'id' => $item->getId(),
              'titulo' => $item->getTitulo(),
              'detalhes' => $item->getDetalhes(),
              'data_inicio' => $item->getDataInicio(),
              'data_entrega' => $item->getDataEntrega(),
              'qtd_horas' => $item->getQtdHoras(),
              'id_projeto' => $item->getIdProjeto(),
              'id_recurso' => $item->getIdRecurso(),
              'id_usuario' => $item->getIdUsuario(),
              'id_status' => $item->getIdStatus(),
              'projeto_nome' => $item->getProjetoNome(),
              'recurso_nome' => $item->getRecursoNome()
            );
            $c++;
        endforeach;

        $json = json_encode($result);
        if ($c > 0) echo $json;
        
        break;
        
    case "buscar_por_id":
        
        $postdata = json_decode(file_get_contents("php://input"));
        
        // riscos da demanda
        $id_demanda = (int)$postdata->id;
        $riscos = RiscoDemanda::buscar_todos_por_id_demanda($id_demanda);
        $c = 0;
        foreach($riscos as $risco):    
            $riscosDemanda[$c] = 
                $risco->getIdRisco()
            ;
            $c++;
        endforeach;
        
        // demanda
        $item = Demanda::buscar_por_id($postdata->id);
        $result = array(
          'id' => $item->getId(),
          'titulo' => $item->getTitulo(),
          'detalhes' => $item->getdetalhes(),
          'data_inicio' => $item->getDataInicio(),
          'data_entrega' => $item->getDataEntrega(),
          'qtd_horas' => $item->getQtdHoras(),
          'id_projeto' => $item->getIdProjeto(),
          'id_recurso' => $item->getIdRecurso(),
          'id_usuario' => $item->getIdUsuario(),
          'id_status' => $item->getIdStatus(),
          'riscos' => $riscosDemanda
        );

        $json = json_encode($result);
        echo $json;
        
        break;
        
    case "buscar_por_id_usuario":
        
        $postdata = json_decode(file_get_contents("php://input"));
        $array = Demanda::buscar_por_id_usuario($postdata->id_usuario);
        
        $c = 0;
        foreach($array as $item):
        
            // riscos da demanda
            $riscos = RiscoDemanda::buscar_todos_por_id_demanda($item->getId());
            $c1 = 0;
        
            foreach($riscos as $risco):    
                $riscosDemanda[$c1] = array(
                    'id' => $risco->getIdRisco(),
                    'titulo' => $risco->getRiscoTitulo(),
                    'is_problema' => $risco->getIsProblema()
                );
        
                //echo $risco->getIdRisco() . $risco->getRiscoTitulo();
        
                $c1++;
            endforeach;
        
            // demanda
            $result[$c] = array(
              'id' => $item->getId(),
              'titulo' => $item->getTitulo(),
              'detalhes' => $item->getDetalhes(),
              'data_inicio' => $item->getDataInicio(),
              'data_entrega' => $item->getDataEntrega(),
              'qtd_horas' => $item->getQtdHoras(),
              'id_projeto' => $item->getIdProjeto(),
              'id_recurso' => $item->getIdRecurso(),
              'id_usuario' => $item->getIdUsuario(),
              'id_status' => $item->getIdStatus(),
              'projeto_nome' => $item->getProjetoNome(),
              'recurso_nome' => $item->getRecursoNome(),
              'riscos' => $riscosDemanda
            );
            $c++;
        
            $riscosDemanda = null;
        endforeach;

        $json = json_encode($result);
        if ($c > 0) echo $json;
        
        break;
    
    case "atualizar":
        
        $postdata = json_decode(file_get_contents("php://input"));
        $demanda = Demanda::buscar_por_id($postdata->id);
        
        $demanda->setTitulo($postdata->titulo);
        $demanda->setDetalhes($postdata->detalhes);
        $demanda->setDataInicio($postdata->data_inicio);
        $demanda->setDataEntrega($postdata->data_entrega);
        $demanda->setQtdHoras($postdata->qtd_horas);
        $demanda->setIdProjeto($postdata->id_projeto);
        $demanda->setIdRecurso($postdata->id_recurso);
        $demanda->setIdStatus($postdata->id_status);
        
        RiscoDemanda::apagar($postdata->id);
        
        $demanda->atualizar();
        $riscos = array();
        $riscos = $postdata->riscos;

        if (sizeof($riscos)>0) {
            $c = 0;
            foreach($riscos as $risco):  
                $riscoDemanda = new RiscoDemanda();
                $riscoDemanda->setIdRisco($risco);
                $riscoDemanda->setIdDemanda($demanda->getId());
                $riscoDemanda->adicionar();    
                $c++;
            endforeach;     
        }
            
        echo "Demanda atualizada com sucesso!"; 
        
        break;
        
    case "apagar":
        
        $postdata = json_decode(file_get_contents("php://input"));
        $id = (int)$postdata->recordId;
        
        $object = Demanda::buscar_por_id($id);

        if($object && $object->apagar()) { echo "Demanda deletada com sucesso!"; } else { /* Failure */ }
        
        break;
        
    default: "";
}

exit;

  