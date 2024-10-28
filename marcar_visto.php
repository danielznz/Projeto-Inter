<?php
session_start();
include_once('config.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $barbeiro_id = $_SESSION['usuario_id'];

    // Atualiza o status do agendamento para "concluído" e "visto"
    $sql = "UPDATE agendamento SET notificado_adm = 1, status = 'concluido' WHERE idagendamento = ? AND barbeiro = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ii", $id, $barbeiro_id);

    if ($stmt->execute()) {
        header("Location: admin_agendamentos.php"); // Retorna para a página de agendamentos
        exit();
    } else {
        echo "Erro ao marcar como concluído.";
    }
} else {
    echo "ID de agendamento não fornecido.";
}
?>
