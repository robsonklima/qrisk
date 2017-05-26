<?php

require_once('initialize.php');

if(isset($_REQUEST["acao"])){ $acao = $_REQUEST["acao"]; } 

switch ($acao) {
        
    case "buscar_todos":
        
        $array = Menu::buscar_todos();
        $c = 0;
        foreach($array as $item):
            $result[$c] = array(
              'id' => $item->getId(),
              'nome' => $item->getNome(),
              'icone' => $item->getIcone(),
              'url' => $item->getUrl(),
              'ordem' => $item->getOrdem(),
              'id_status' => $item->getIdstatus()
            );
            $c++;
        endforeach;

        $json = json_encode($result);
        if ($c > 0) echo $json;
        
        break;
        
    case "buscar_por_id":
        
        $postdata = json_decode(file_get_contents("php://input"));
        $id       = (int)$postdata->id;
        $result = array();

        $item    = Menu::buscar_por_id($id);

        $result = array(
          'id' => $item->getId(),
          'nome' => $item->getNome(),
          'icone' => $item->getIcone(),
          'url' => $item->getUrl(),
          'ordem' => $item->getOrdem(),
          'id_status' => $item->getIdstatus()
        );

        $json = json_encode($result);
        echo $json;
        
        break;
        
    case "buscar_por_id_usuario_perfil":
        
        $postdata = json_decode(file_get_contents("php://input"));
        $array = Menu::buscar_por_id_usuario_perfil($postdata->id_usuario_perfil);
        $c = 0;
        foreach($array as $item):
            $result[$c] = array(
              'id' => $item->getId(),
              'nome' => $item->getNome(),
              'icone' => $item->getIcone(),
              'url' => $item->getUrl(),
              'ordem' => $item->getOrdem(),
              'id_status' => $item->getIdstatus()
            );
            $c++;
        endforeach;

        $json = json_encode($result);
        if ($c > 0) echo $json;
        
        break;
    
    case "adicionar":
        
        $postdata = json_decode(file_get_contents("php://input"));
        
        $object = new Menu();
        $object->setNome($postdata->nome);
        $object->setIcone($postdata->icone);
        $object->setUrl($postdata->url);
        $object->setOrdem($postdata->ordem);
        $object->setIdStatus($postdata->id_status);

        if($object->adicionar()) { echo "Menu adicionado com sucesso!"; } else { /* Failure */ }

        break;    
    
    case "atualizar":
        
        $postdata = json_decode(file_get_contents("php://input"));
        $id = $postdata->id;

        $object = Menu::buscar_por_id($id);
        $object->setNome($postdata->nome);
        $object->setIcone($postdata->icone);
        $object->setUrl($postdata->url);
        $object->setOrdem($postdata->ordem);
        $object->setIdStatus($postdata->id_status);

        if($object->atualizar()) { echo "Menu atualizado com sucesso!"; } else { echo "Nenhuma alteração realizada!"; }
        
        break;
        
    case "apagar":
        
        $postdata = json_decode(file_get_contents("php://input"));
        $id = (int)$postdata->recordId;
        
        $object = Menu::buscar_por_id($id);

        if($object && $object->apagar()) { echo "Menu deletado com sucesso!"; } else { /* Failure */ }
        
        break;
        
        
    default: "";
}

exit;

  