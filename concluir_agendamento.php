<?php
session_start();
include_once('config.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Atualiza o status do agendamento para 'concluído' e registra a data/hora de conclusão
    $sql = "UPDATE agendamento SET status = 'concluido', data_conclusao = NOW() WHERE idagendamento = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: estatisticas.php");
        exit();
    } else {
        echo "Erro ao concluir o agendamento.";
    }
} else {
    echo "ID de agendamento não fornecido.";
}
?>
