<?php

require_once('initialize.php');

if(isset($_REQUEST["acao"])){ $acao = $_REQUEST["acao"]; }

switch ($acao) {

    case "buscar_todos":

        $array = RecursoFuncao::buscar_todos();
        $c = 0;
        foreach($array as $item):
            $result[$c] = array(
              'id'   => $item->getId(),
              'nome' => $item->getNome(),
              'valor_hora' => $item->getValorHora(),
              'id_status' => $item->getidStatus()
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

        $item    = RecursoFuncao::buscar_por_id($id);

        $result = array(
          'id'   => $item->getId(),
          'nome' => $item->getNome(),
          'valor_hora' => $item->getValorHora(),
          'id_status' => $item->getidStatus()
        );

        $json = json_encode($result);
        echo $json;

        break;

    case "adicionar":

        $postdata = json_decode(file_get_contents("php://input"));

        $object = new RecursoFuncao();
        $object->setNome($postdata->nome);
        $object->setValorHora($postdata->valor_hora);
        $object->setIdStatus($postdata->id_status);

      if($object->adicionar()) { echo "Function added successfully!"; } else { /* Failure */ }

        break;

    case "atualizar":

        $postdata = json_decode(file_get_contents("php://input"));
        $id = $postdata->id;
        $nome = $postdata->nome;
        $valor_hora = $postdata->valor_hora;
        $id_status = $postdata->id_status;

        $object = RecursoFuncao::buscar_por_id($id);

        $object->setNome($nome);
        $object->setValorHora($valor_hora);
        $object->setIdStatus($id_status);

        if($object->atualizar()) { echo "Function updated successfully!"; } else { echo "Nothing changed!"; }

        break;

    case "apagar":

        $postdata = json_decode(file_get_contents("php://input"));
        $id = (int)$postdata->recordId;

        $object = RecursoFuncao::buscar_por_id($id);

      if($object && $object->apagar()) { echo "Function deleted successfully!"; } else { /* Failure */ }

        break;

    default: "";
}

exit;
