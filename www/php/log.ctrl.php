<?php

require_once('initialize.php');
$logfile = '../logs/log.txt';

if(isset($_REQUEST["acao"])){ $acao = $_REQUEST["acao"]; }

switch ($acao) {

    case "buscar_todos":

        $c=0;
        if( file_exists($logfile) && is_readable($logfile) &&
            $handle = fopen($logfile, 'r')) {
            while(!feof($handle)) {
                $entry = fgets($handle);
                if(trim($entry) != "") {
                    $result[$c] = array(
                      'log' => $entry
                    );
                }
                $c++;
            }
            fclose($handle);
        } else {
            echo "Could not read from {$logfile}.";
        }

        $json = json_encode($result);
        if ($c > 0) echo $json;

        break;

    case "apagar":

        $postdata = json_decode(file_get_contents("php://input"));

        file_put_contents($logfile, '');
        salva_log('Logs deleted', "User Id: ".$postdata->id_usuario);
        echo "Logs deleted successfully!";

        break;

    default: "";
}

exit;
