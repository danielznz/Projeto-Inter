<?php
session_start();
include_once('config.php');


// Verifica se o ID foi passado via URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Atualiza o campo 'notificado_adm' para 1 (visto)
    $sql = "UPDATE agendamento SET notificado_adm = 1 WHERE idagendamento = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: admin_agendamentos.php"); // Redireciona de volta para a página dos agendamentos
        exit();
    } else {
        echo "Erro ao marcar como visto.";
    }
} else {
    echo "ID de agendamento não fornecido.";
}
?>
