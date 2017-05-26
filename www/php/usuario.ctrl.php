<?php

require_once('initialize.php');

if(isset($_REQUEST["acao"])){ $acao = $_REQUEST["acao"]; }

switch ($acao) {

    case "buscar_todos":

        $array = Usuario::buscar_todos();
        $c = 0;
        foreach($array as $item):
            $result[$c] = array(
              'id' => $item->getId(),
              'nome' => $item->getNome(),
              'id_usuario_perfil' => $item->getIdUsuarioPerfil(),
              'usuario_perfil_nome' => $item->getUsuarioPerfilNome(),
              'id_status' => $item->getIdStatus(),
              'status_nome' => $item->getStatusNome()
            );
            $c++;
        endforeach;

        $json = json_encode($result);
        if ($c > 0) echo $json;

        break;

    // Pesquisa usuários que nao estao vinculados a nenhum recurso
    // para atribuir ao cadastro de recursos
    case "buscar_usu_sem_rec":

        $array = Usuario::buscar_usu_sem_rec();
        $c = 0;
        foreach($array as $item):
            $result[$c] = array(
              'id' => $item->getId(),
              'nome' => $item->getNome(),
              'id_usuario_perfil' => $item->getIdUsuarioPerfil(),
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

        $item    = Usuario::buscar_por_id($id);

        $result = array(
          'id'   => $item->getId(),
          'nome' => $item->getNome(),
          'login' => $item->getLogin(),
          'senha' => $item->getSenha(),
          'id_usuario_perfil' => $item->getIdUsuarioPerfil(),
          'id_status' => $item->getIdStatus()
        );

        $json = json_encode($result);
        echo $json;

        break;

    case "adicionar":

        $postdata = json_decode(file_get_contents("php://input"));

        $object = new Usuario();

        $object->setNome($postdata->nome);
        $object->setLogin($postdata->login);
        $object->setSenha($postdata->senha);
        $object->setIdUsuarioPerfil($postdata->id_usuario_perfil);
        $object->setIdStatus($postdata->id_status);

      if($object->adicionar()) { echo "User added successfully!"; } else { /* Failure */ }

        break;

    case "atualizar":

        $postdata = json_decode(file_get_contents("php://input"));
        $id       = $postdata->id;

        $object = Usuario::buscar_por_id($id);

        $object->setNome($postdata->nome);
        $object->setLogin($postdata->login);
        $object->setSenha($postdata->senha);
        $object->setIdUsuarioPerfil($postdata->id_usuario_perfil);
        $object->setIdStatus($postdata->id_status);


        if($object->atualizar()) { echo "User added successfully!"; } else { echo "Nothing changed!"; }

        break;

    case "apagar":

        $postdata = json_decode(file_get_contents("php://input"));
        $id = (int)$postdata->recordId;

        $object = Usuario::buscar_por_id($id);

      if($object && $object->apagar()) { echo "User deleted successfully!"; } else { /* Failure */ }

        break;

    default: "";
}

exit;
