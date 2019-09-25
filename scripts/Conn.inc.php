<?php
    /**
     * Conexão com o Banco de dados
     * 
     * @author Allan Camargo, 25/09/2019 
     */

    require "environment.php"; // Verificar se esta no ambiente de produção ou desenvolvimento
    global $config; // Setando variavel como global
    $config = array(); 

    if(ENVIRONMENT == 'development') {
        $config['db_name'] = "db_althaia"; // Nome do Banco
        $config['db_host'] = "208.97.172.139:3306"; // Nome do servidor
        $config['db_user'] = "db_althaia"; // Nome do usuario
        $config['db_pass'] = "equaliv@123"; // Senha do Usuário
    } else { // Caso não esteja em produção
        $config['db_name'] = "db_althaia";
        $config['db_host'] = "208.97.172.139:3306";
        $config['db_user'] = "db_althaia";
        $config['db_pass'] = "equaliv@123";
    }
    

    $Conn = new PDO('mysql:host=' . $config['db_host'] . ';dbname=' . $config['db_name'], $config['db_user'], $config['db_pass']);
    $Conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $Conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);