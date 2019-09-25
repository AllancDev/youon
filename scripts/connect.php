<?php

    error_reporting(2); //esconde erros nativos do PHP
    $host   = "208.97.172.139:3306";
    $usuario= "dev_equaliv";
    $senha  = "Selftech";
    $bd     = "db_althaia";

    $mysqli = new mysqli($host, $usuario, $senha, $bd);

    if($mysqli->connect_errno)
        echo "Falha na conexão: (".$mysqli->connect_errno.") ".$mysqli->connect_error;

?>
