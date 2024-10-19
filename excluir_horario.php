<?php
session_start();
include_once('config.php');

// Verificar se o ID do horário foi passado na URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Preparar e executar a query para excluir o horário
    $delete_query = "DELETE FROM disponibilidade WHERE id = ?";
    $stmt = $conexao->prepare($delete_query);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Verificar se a exclusão foi bem-sucedida
    if ($stmt->affected_rows > 0) {
        echo "Horário excluído com sucesso!";
    } else {
        echo "Erro ao excluir o horário.";
    }

    // Redirecionar de volta para a página principal (ajuste conforme necessário)
    header("Location: gerenciar_agendamentos.php");
    exit();
} else {
    echo "ID inválido.";
}
?>
