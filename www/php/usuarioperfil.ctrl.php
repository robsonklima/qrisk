<?php

require_once('initialize.php');

if(isset($_REQUEST["acao"])){ $acao = $_REQUEST["acao"]; }

switch ($acao) {

    case "buscar_todos":

        $array = UsuarioPerfil::buscar_todos();
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
        if ($c > 0) echo $json;

        break;

    case "buscar_por_id":

        $postdata = json_decode(file_get_contents("php://input"));
        $id = (int)$postdata->id;

        // menus do perfil
        $menus = UsuarioPerfilMenu::buscar_todos_por_id_usuario_perfil($id);
        $c = 0;
        foreach($menus as $menu):
            $menusUsuarioPerfil[$c] =
                $menu->getIdMenu()
            ;
            $c++;
        endforeach;

        $result = array();

        $item    = UsuarioPerfil::buscar_por_id($id);

        $result = array(
          'id' => $item->getId(),
          'nome' => $item->getNome(),
          'id_status' => $item->getIdStatus(),
          'menus' => $menusUsuarioPerfil
        );

        $json = json_encode($result);
        echo $json;

        break;

    case "adicionar":

        $postdata = json_decode(file_get_contents("php://input"));

        $object = new UsuarioPerfil();
        $object->setNome($postdata->nome);
        $object->setIdStatus($postdata->id_status);

        if($object->adicionar()) {
            $menus = array();
            $menus = $postdata->menus;

            if (sizeof($menus)>0) {
                $c = 0;
                foreach($menus as $menu):
                    $usuarioPerfilMenu = new UsuarioPerfilMenu();
                    $usuarioPerfilMenu->setIdUsuarioPerfil($object->getId());
                    $usuarioPerfilMenu->setIdMenu($menu);
                    $usuarioPerfilMenu->adicionar();
                    $c++;
                endforeach;
            }

            echo "User profile added successfully!";
        } else {
            /* Failure */
        }

        break;

    case "atualizar":

        $postdata = json_decode(file_get_contents("php://input"));

        $object = UsuarioPerfil::buscar_por_id($postdata->id);
        $object->setNome($postdata->nome);
        $object->setIdStatus($postdata->id_status);
        $object->atualizar();

        UsuarioPerfilMenu::apagar($postdata->id);

        $menus = array();
        $menus = $postdata->menus;

        if (sizeof($menus)>0) {
            $c = 0;
            foreach($menus as $menu):
                $usuarioPerfilMenu = new UsuarioPerfilMenu();
                $usuarioPerfilMenu->setIdUsuarioPerfil($object->getId());
                $usuarioPerfilMenu->setIdMenu($menu);
                $usuarioPerfilMenu->adicionar();
                $c++;
            endforeach;
        }

        echo "User profile updated successfully!";

        break;

    case "apagar":

        $postdata = json_decode(file_get_contents("php://input"));
        $id = (int)$postdata->recordId;

        $object = UsuarioPerfil::buscar_por_id($id);

      if($object && $object->apagar()) { echo "User profile deleted successfully!"; } else { /* Failure */ }

        break;

    default: "";
}

exit;
