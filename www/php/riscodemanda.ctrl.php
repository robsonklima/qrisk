<?php

require_once('initialize.php');

if(isset($_REQUEST["acao"])){ $acao = $_REQUEST["acao"]; } 

switch ($acao) {
        
     case "marcar_risco_demanda_problema":
        
        $postdata = json_decode(file_get_contents("php://input"));
        
        $object = RiscoDemanda::marcar_risco_demanda_problema($postdata->id_risco, $postdata->id_demanda, 
                                                                   $postdata->valor);

        echo "Risco marcado com sucesso!"; 
        
        break;
        
    default: "";
}

exit;

  