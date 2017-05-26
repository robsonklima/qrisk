<?php

require_once('initialize.php');


if(isset($_REQUEST["acao"])){ $acao = $_REQUEST["acao"]; }

switch ($acao) {

    case "buscar_todos":

        $array = EarCat::find_all_join();
        $c = 0;
        foreach($array as $item):
            $result[$c] = array(
              'id'   => $item->getId(),
              'nome' => $item->getNome(),
              'id_status' => $item->getIdStatus()
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

        $item    = EarCat::buscar_por_id($id);

        $result = array(
          'id'   => $item->getId(),
          'nome' => $item->getNome(),
          'id_status' => $item->getIdStatus()
        );

        $json = json_encode($result);
        echo $json;

        break;

    case "adicionar":

        $postdata = json_decode(file_get_contents("php://input"));

        $object   = new EarCat();
        $object->setNome($postdata->nome);
        $object->setIdStatus($postdata->id_status);

      if($object->adicionar()) { echo "EAR category added successfully!"; } else { /* Failure */ }

        break;

    case "atualizar":

        $postdata = json_decode(file_get_contents("php://input"));

        $object = EarCat::buscar_por_id($postdata->id);
        $object->setNome($postdata->nome);
        $object->setIdStatus($postdata->id_status);

        if($object->atualizar()) { echo "EAR category updated successfully!"; } else { echo "Nothing changed!"; }

        break;

    case "apagar":

        $postdata = json_decode(file_get_contents("php://input"));

        $id = (int)$postdata->recordId;
        $object = EarCat::buscar_por_id($id);

      if($object && $object->apagar()) { echo "EAR category deleted successfully!"; } else { /* Failure */ }

        break;

    default: "";
}

exit;
