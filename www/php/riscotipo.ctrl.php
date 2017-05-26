<?php

require_once('initialize.php');

if(isset($_REQUEST["acao"])){ $acao = $_REQUEST["acao"]; }

switch ($acao) {

    case "buscar_todos":

        $array = RiscoTipo::buscar_todos();
        $c = 0;
        foreach($array as $item):
            $result[$c] = array(
              'id' => $item->getId(),
              'nome' => $item->getNome(),
              'id_status' => $item->getIdStatus()
            );
            $c++;
        endforeach;

        $json = json_encode($result);
        echo $json;

        break;

    case "buscar_por_id":

        $postdata = json_decode(file_get_contents("php://input"));
        $id       = (int)$postdata->id;
        $result = array();

        $item    = RiscoTipo::buscar_por_id($id);

        $result = array(
          'id' => $item->getId(),
          'nome' => $item->getNome(),
          'id_status' => $item->getIdStatus()
        );

        $json = json_encode($result);
        echo $json;

        break;

    case "adicionar":

        $postdata = json_decode(file_get_contents("php://input"));

        $object   = new RiscoTipo();
        $object->setNome($postdata->nome);
        $object->setIdStatus($postdata->id_status);

      if($object->adicionar()) { echo "Risk type added successfully!"; } else { /* Failure */ }

        break;

    case "atualizar":

        $postdata = json_decode(file_get_contents("php://input"));
        $id = $postdata->id;
        $object = RiscoTipo::buscar_por_id($id);
        $object->setNome($postdata->nome);
        $object->setIdStatus($postdata->id_status);

        if($object->atualizar()) { echo "Risk type updated successfully!"; } else { echo "Nothing changed!"; }

        break;

    case "apagar":

        $postdata = json_decode(file_get_contents("php://input"));
        $id = (int)$postdata->recordId;

        $object = RiscoTipo::buscar_por_id($id);

      if($object && $object->apagar()) { echo "Risk type deleted successfully!"; } else { /* Failure */ }

        break;

    default: "";
}

exit;
