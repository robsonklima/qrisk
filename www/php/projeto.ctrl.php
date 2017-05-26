<?php

require_once('initialize.php');

if(isset($_REQUEST["acao"])){ $acao = $_REQUEST["acao"]; }

switch ($acao) {

    case "adicionar":

        $postdata = json_decode(file_get_contents("php://input"));

        $projeto = new Projeto();
        $projeto->setNome($postdata->nome);
        $projeto->setEscopo($postdata->escopo);
        $projeto->setIdUsuario($postdata->id_usuario);
        $projeto->setIdStatus($postdata->id_status);

        if($projeto->adicionar()) {
            $riscos = array();
            $riscos = $postdata->riscos;

            if (sizeof($riscos)>0) {
                $c = 0;
                foreach($riscos as $risco):
                    $riscoProjeto = new RiscoProjeto();
                    $riscoProjeto->setIdRisco($risco);
                    $riscoProjeto->setIdProjeto($projeto->getId());
                    $riscoProjeto->adicionar();
                    $c++;
                endforeach;
            }

            echo "Project added successfully!";
        } else {
            /* Failure */
        }

        break;

    case "atualizar":

        $postdata = json_decode(file_get_contents("php://input"));

        $projeto = Projeto::buscar_por_id($postdata->id);

        $projeto->setNome($postdata->nome);
        $projeto->setEscopo($postdata->escopo);
        $projeto->setIdStatus($postdata->id_status);

        RiscoProjeto::apagar($postdata->id);

        if($projeto->atualizar()) {
            $riscos = array();
            $riscos = $postdata->riscos;

            if (sizeof($riscos)>0) {
                $c = 0;
                foreach($riscos as $risco):
                    $riscoProjeto = new RiscoProjeto();
                    $riscoProjeto->setIdRisco($risco);
                    $riscoProjeto->setIdProjeto($projeto->getId());
                    $riscoProjeto->adicionar();
                    $c++;
                endforeach;
            }

            echo "Project updated successfully!";
        } else {
            /* Failure */
        }

        break;

    case "apagar":

        $postdata = json_decode(file_get_contents("php://input"));

        $id = (int)$postdata->recordId;
        $object = Projeto::buscar_por_id($id);

      if($object && $object->apagar()) { echo "Project deleted successfully!"; } else { /* Failure */ }

        break;

    case "buscar_todos":

        $array = Projeto::buscar_todos();

        $c = 0;
        foreach($array as $item):
            $result[$c] = array(
              'id' => $item->getId(),
              'nome' => $item->getNome(),
              'escopo' => $item->getEscopo(),
              'qtd_riscos' => $item->getQtdRiscos(),
              'id_usuario' => $item->getIdstatus(),
              'id_status' => $item->getIdstatus()
            );
            $c++;
        endforeach;

        $json = json_encode($result);
        if ($c > 0) echo $json;

        break;

    case "buscar_por_id":

        $postdata = json_decode(file_get_contents("php://input"));

        // riscos do projeto
        $id_projeto = (int)$postdata->id;
        $riscos = RiscoProjeto::buscar_todos_por_id_projeto($id_projeto);
        $c = 0;
        foreach($riscos as $risco):
            $riscosProjeto[$c] =
                $risco->getIdRisco()
            ;
            $c++;
        endforeach;

        // projeto
        $projeto = Projeto::buscar_por_id($id_projeto);
        $result = array(
          'id' => $projeto->getId(),
          'nome' => $projeto->getNome(),
          'escopo' => $projeto->getEscopo(),
          'data_cadastro' => $projeto->getDataCadastro(),
          'id_usuario' => $projeto->getIdstatus(),
          'id_status' => $projeto->getIdstatus(),
          'usuario_nome' => $projeto->getUsuarioNome(),
          'status_nome' => $projeto->getStatusNome(),
          'projeto_valor' => $projeto->getProjetoValor(),
          'qtd_riscos' => $projeto->getQtdRiscos(),
          'riscos' => $riscosProjeto
        );

        $json = json_encode($result);
        echo $json;

        break;

    case "buscar_todos_por_id_risco":

        $postdata = json_decode(file_get_contents("php://input"));

        $array = Projeto::buscar_todos_por_id_risco((int)$postdata->id_risco);

        $c = 0;
        foreach($array as $item):
            $result[$c] = array(
              'id' => $item->getId(),
              'nome' => $item->getNome()
            );
            $c++;
        endforeach;

        $json = json_encode($result);
        if ($c > 0) echo $json;

        break;

    case "buscar_todos_por_id_usuario":

        $postdata = json_decode(file_get_contents("php://input"));

        $array = Projeto::buscar_todos_por_id_usuario($postdata->id_usuario);

        $c = 0;
        foreach($array as $item):

            // riscos do projeto
            $riscos = RiscoProjeto::buscar_todos_por_id_projeto($item->getId());
            $c1 = 0;

            foreach($riscos as $risco):
                $riscosProjeto[$c1] = array(
                    'id' => $risco->getIdRisco(),
                    'titulo' => $risco->getRiscoTitulo(),
                    'is_problema' => $risco->getIsProblema()
                );
                $c1++;
            endforeach;

            $result[$c] = array(
              'id' => $item->getId(),
              'nome' => $item->getNome(),
              'riscos' => $riscosProjeto
            );
            $c++;

            $riscosProjeto = null;
        endforeach;

        $json = json_encode($result);
        if ($c > 0) echo $json;

        break;

    default: "";
}

exit;
