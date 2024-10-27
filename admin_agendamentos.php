<?php
session_start();
include_once('config.php');


// Pega o ID do barbeiro logado
$barbeiro_id = $_SESSION['usuario_id'];

// Busca os agendamentos que ainda não foram notificados e que pertencem ao barbeiro logado
$result = mysqli_query($conexao, "SELECT * FROM agendamento WHERE notificado_adm = 0 AND barbeiro = $barbeiro_id");

// Exibe a lista de agendamentos
if (mysqli_num_rows($result) > 0) {
    echo "<h2>Novos Agendamentos:</h2>";
    echo "<ul>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<li>";
        echo "Serviço: " . $row['servico'] . "<br>";
        echo "Data: " . $row['data'] . "<br>";
        echo "Horário: " . $row['horario'] . "<br>";
        echo "<a href='marcar_visto.php?id=" . $row['idagendamento'] . "'>Marcar como Visto</a>";
        echo "</li><br>";
    }
    echo "</ul>";
} else {
    echo "Nenhum novo agendamento.";
}
?>

<style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
    margin: 0;
    padding: 20px;
}

h2 {
    color: #333;
    text-align: center;
}

ul {
    list-style-type: none;
    padding: 0;
}

li {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 15px;
    margin: 10px 0;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

li a {
    text-decoration: none;
    color: #007bff;
    font-weight: bold;
}

li a:hover {
    text-decoration: underline;
}

@media (max-width: 600px) {
    body {
        padding: 10px;
    }

    li {
        padding: 10px;
    }
}
    </style>
