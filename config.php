<?php
    $dbHost = 'Localhost';
    $dbUsarname = 'root';
    $dbPassword = '';
    $daName = 'newage';

    $conexao = new mysqli($dbHost,$dbUsarname,$dbPassword,$dbName = 'newage');

    // if($conexao->connect_errno)
    // {
    //     echo "Erro";
    // } else{
    //     echo "Conexão";
    // }
?>