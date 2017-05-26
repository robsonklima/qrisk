<?php

function salva_log($titulo, $mensagem="") {
  $logfile = '../logs/log.txt';
  $new = file_exists($logfile) ? false : true;
  if($handle = fopen($logfile, 'a')) { // append
    date_default_timezone_set('America/Sao_Paulo');
    //$timestamp = strftime("%Y-%m-%d %H:%M:%S", time()); // formato americano
    $timestamp = date('d/m/Y H:i:s', time());             // formato brasileiro
    // \r\n windows \n OSX e Linux
    $content = "{$timestamp} | {$titulo}: {$mensagem}\r\n";
    fwrite($handle, $content);
    fclose($handle);
    if($new) { chmod($logfile, 0755); }
  } else {
    echo "Could not open log file for writing.";
  }
}