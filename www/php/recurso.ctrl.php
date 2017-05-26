<?php

require_once('initialize.php');

if(isset($_REQUEST["acao"])){ $acao = $_REQUEST["acao"]; } 

switch ($acao) {
        
    case "buscar_todos":
        
        $array = Recurso::buscar_todos();
        $c = 0;
        foreach($array as $item):
            $result[$c] = array(
              'id' => $item->getId(),
              'nome' => $item->getNome(),
              'id_recurso_funcao' => $item->getIdRecursoFuncao(),
              'recurso_funcao_nome' => $item->getRecursoFuncaoNome(),
              'id_usuario' => $item->getIdUsuario(),
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

        $item = Recurso::buscar_por_id($id);

        $result = array(
          'id' => $item->getId(),
          'nome' => $item->getNome(),
          'id_recurso_funcao' => $item->getIdRecursoFuncao(),
          'id_usuario' => $item->getIdUsuario(),
          'id_status' => $item->getIdStatus()
        );

        $json = json_encode($result);
        echo $json;
        
        break;
    
    case "adicionar":
        
        $postdata = json_decode(file_get_contents("php://input"));
        
        $object = new Recurso();
        $object->setNome($postdata->nome);
        $object->setIdRecursoFuncao($postdata->id_recurso_funcao);
        $object->setIdUsuario($postdata->id_usuario);
        $object->setIdstatus($postdata->id_status);

        if($object->adicionar()) { echo "Recurso adicionado com sucesso!"; } else { /* Failure */ }

        break;    
    
    case "atualizar":
        
        $postdata = json_decode(file_get_contents("php://input"));

        $object = Recurso::buscar_por_id($postdata->id);
        
        $object->setNome($postdata->nome);
        $object->setIdRecursoFuncao($postdata->id_recurso_funcao);
        $object->setIdUsuario($postdata->id_usuario);
        $object->setIdStatus($postdata->id_status);

        if($object->atualizar()) { echo "Recurso atualizado com sucesso!"; } else { echo "Nenhuma alteração realizada!"; }
        
        break;
        
    case "apagar":
        
        $postdata = json_decode(file_get_contents("php://input"));
        $id = (int)$postdata->recordId;
        
        $object = Recurso::buscar_por_id($id);

        if($object && $object->apagar()) { echo "Recurso deletado com sucesso!"; } else { /* Failure */ }
        
        break;
        
    default: "";
}

exit;

  