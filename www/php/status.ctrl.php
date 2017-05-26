<?php

require_once('initialize.php');

if(isset($_REQUEST["acao"])){ $acao = $_REQUEST["acao"]; }

switch ($acao) {

    case "buscar_todos":

        $array = Status::buscar_todos();
        $c = 0;
        foreach($array as $item):
            $result[$c] = array(
              'id'      => $item->getId(),
              'nome'    => $item->getNome()
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

        $item    = Status::buscar_por_id($id);

        $result = array(
          'id'   => $item->getId(),
          'nome' => $item->getNome()
        );

        $json = json_encode($result);
        echo $json;

        break;

    case "adicionar":

        $postdata = json_decode(file_get_contents("php://input"));

        $object   = new Status();
        $object->setNome($postdata->nome);

      if($object->adicionar()) { echo "Status added successfully!"; } else { /* Failure */ }

        break;

    case "atualizar":

        $postdata = json_decode(file_get_contents("php://input"));
        $id       = $postdata->id;
        $nome     = $postdata->nome;

        $object = Status::buscar_por_id($id);
        $object->setNome($nome);

        if($object->atualizar()) { echo "Status updated successfully!"; } else { echo "Nothing changed!"; }

        break;

    case "apagar":

        $postdata = json_decode(file_get_contents("php://input"));
        $id = (int)$postdata->recordId;

        $object = Status::buscar_por_id($id);

      if($object && $object->apagar()) { echo "Status deleted successfully!"; } else { /* Failure */ }

        break;

    default: "";
}

exit;
