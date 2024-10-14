<?php
include_once('config.php');

if (isset($_POST['id'])) {
    $idagendamento = $_POST['id'];

    // Query para excluir o agendamento com base no ID
    $query = "DELETE FROM agendamento WHERE idagendamento = ?";
    $stmt = $conexao->prepare($query);
    $stmt->bind_param('i', $idagendamento);

    if ($stmt->execute()) {
        echo 'Agendamento excluído com sucesso.';
    } else {
        echo 'Erro ao excluir o agendamento.';
    }

    $stmt->close();
    $conexao->close();
}
?>
