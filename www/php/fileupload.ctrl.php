<?php

require_once('initialize.php');

if(isset($_REQUEST["acao"])){ $acao = $_REQUEST["acao"]; } 

switch ($acao) {
        
    case "buscar_todos":  
        
        $array = FileUpload::find_all_join();
        $c = 0;
        foreach($array as $item):
            $result[$c] = array(
              'id' => $item->getId(),
              'descricao' => $item->getDescricao(),
              'nome' => $item->getNome(),
              'tipo' => $item->getTipo(),
              'tamanho' => $item->getTamanho(),
              'data_cadastro' => $item->getDataCadastro()
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

        $item    = FileUpload::buscar_por_id($id);

        $result = array(
          'id'   => $item->getId(),
          'nome' => $item->getNome()
        );

        $json = json_encode($result);
        echo $json;
        
        break;
    
    case "adicionar":
        
        $erro = false;
        $diretorio = "../upload/";
        $descricao = $_POST['descricao'];
        $id_usuario = $_POST['id_usuario'];
        $arquivo = $diretorio . basename($_FILES["file"]["name"]);

        if (pathinfo($arquivo, PATHINFO_EXTENSION) != 'xml') {
            $erro .= "Extensão inválida"; 
        } else if (file_exists($arquivo)) { 
            $erro .= "O arquivo já existe"; 
        } else if (!move_uploaded_file($_FILES["file"]["tmp_name"], $arquivo)) { 
            $erro .= "Não foi possível copiar o arquivo para o seu diretório"; 
        } else {
            // adiciona informacoes do arquivo no banco de dados
            $object = new FileUpload();
            $object->setDescricao($descricao);
            $object->setNome(basename($_FILES["file"]["name"]));
            $object->setTamanho(filesize($arquivo));
            $object->setTipo(pathinfo($arquivo, PATHINFO_EXTENSION));
            $object->setIdUsuario($id_usuario);
            $object->adicionar();
            
            // importa conteudo do arquivo
            $xml=simplexml_load_file($arquivo) or die("Error: Cannot create object");
            foreach($xml->children() as $projeto) {

                // projeto
                if (!$proj = Projeto::buscar_por_nome($projeto->nome)) {
                    $proj = new Projeto();
                    $proj->setNome($projeto->nome);
                    $proj->setEscopo($projeto->escopo);
                    $proj->setIdUsuario($id_usuario);
                    $proj->setIdStatus($projeto->status);
                    $proj->adicionar();
                    
                    salva_log('Projeto Adicionado', $proj->getNome());
                }

                // usuario perfil
                if (!$per = UsuarioPerfil::buscar_por_nome($projeto->demanda->recurso->usuario->perfil->nome)) {
                    $per = new UsuarioPerfil();
                    $per->setNome($projeto->demanda->recurso->usuario->perfil->nome);
                    $per->setIdStatus($projeto->demanda->recurso->usuario->perfil->status);
                    $per->adicionar();
                    
                    salva_log('Perfil Adicionado', $per->getNome());
                }

                // usuario
                if (!$usu = Usuario::buscar_por_nome($projeto->demanda->recurso->usuario->nome)) {
                    $usu = new Usuario();
                    $usu->setNome($projeto->demanda->recurso->usuario->nome);
                    $usu->setLogin($projeto->demanda->recurso->usuario->login);
                    $usu->setSenha($projeto->demanda->recurso->usuario->senha);
                    $usu->setIdUsuarioPerfil($per->getId());
                    $usu->setIdStatus($projeto->demanda->recurso->usuario->status);
                    $usu->adicionar();
                    
                    salva_log('Usuário Adicionado', $usu->getNome());
                }

                // recurso funcao
                if (!$fun = RecursoFuncao::buscar_por_nome($projeto->demanda->recurso->funcao->nome)) {
                    $fun = new RecursoFuncao();
                    $fun->setNome($projeto->demanda->recurso->funcao->nome);
                    $fun->setValorHora($projeto->demanda->recurso->funcao->valor_hora);
                    $fun->setIdStatus($projeto->demanda->recurso->funcao->status);
                    $fun->adicionar();
                    
                    salva_log('Função Adicionada', $fun->getNome());
                }

                // recurso
                if (!$rec = Recurso::buscar_por_nome($projeto->demanda->recurso->nome)) {
                    $rec = new recurso();
                    $rec->setNome($projeto->demanda->recurso->nome);
                    $rec->setIdRecursoFuncao($fun->getId());
                    $rec->setIdUsuario($usu->getId());
                    $rec->setIdStatus($projeto->demanda->recurso->status);
                    $rec->adicionar();
                    
                    salva_log('Recurso Adicionado', $rec->getNome());
                }

                // demanda
                if (!$dem = Demanda::buscar_por_titulo($projeto->demanda->titulo)) {
                    $dem = new Demanda();
                    $dem->setTitulo($projeto->demanda->titulo);
                    $dem->setDetalhes($projeto->demanda->detalhes);
                    $dem->setIdProjeto($proj->getId());
                    $dem->setIdRecurso($rec->getId());
                    $dem->setIdUsuario($usu->getId());
                    $dem->setDataInicio($projeto->demanda->data_inicio);
                    $dem->setDataEntrega($projeto->demanda->data_entrega);
                    $dem->setQtdHoras($projeto->demanda->qtd_horas);
                    $dem->setIdStatus($projeto->demanda->status);
                    $dem->adicionar();
                    
                    salva_log('Demanda Adicionada', $dem->getTitulo());
                }   
            }
        }
        
        if (!$erro) { echo "Arquivo adicionado com sucesso!"; } else { echo $erro; }    

        break;    
    
    case "apagar":
        
        $postdata = json_decode(file_get_contents("php://input"));
        $id = (int)$postdata->recordId;
        
        $object = FileUpload::buscar_por_id($id);
        
        $arquivo = "../upload/".$object->getNome();
        
        if (unlink($arquivo))
        {
            $object && $object->apagar(); 
            echo "Arquivo deletado com sucesso!";
            } else { 
                echo "O arquivo não pode ser deletado!";
            }    
        
        break;
        
    default: "";
}

exit;