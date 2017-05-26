<?php

require_once('initialize.php');

$postdata = json_decode(file_get_contents("php://input"));
$login = $postdata->login;
$senha = $postdata->senha;
$found_user = Usuario::authenticate($login, $senha);
 
if (!empty($found_user)) {
    $data = array(
      'id' => $found_user->getId(),  
      'nome' => $found_user->getNome(),  
      'login' => $found_user->getLogin(),
      'senha' => $found_user->getSenha(),
      'id_usuario_perfil' => $found_user->getIdUsuarioPerfil(),
      'id_status' => $found_user->getidStatus()
    );
    
    salva_log('Login', 'Usuário: '.$found_user->getLogin());
    
    $json = json_encode($data);
    echo $json;
} else {
    salva_log('Tentativa de Login', 'Usuário: '.$login);
}


exit;