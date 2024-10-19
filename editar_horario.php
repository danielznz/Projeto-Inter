<?php
session_start();
include_once('config.php');

// Verificar se o ID do horário foi passado na URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Carregar o horário atual do banco de dados
    $select_query = "SELECT horario FROM disponibilidade WHERE id = ?";
    $stmt = $conexao->prepare($select_query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar se o horário existe
    if ($result->num_rows > 0) {
        $horario_atual = $result->fetch_assoc()['horario'];
    } else {
        echo "Horário não encontrado.";
        exit();
    }
} else {
    echo "ID inválido.";
    exit();
}

// Atualizar o horário no banco de dados após a submissão do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['horario'])) {
    $novo_horario = $_POST['horario'];

    // Atualizar o horário no banco de dados
    $update_query = "UPDATE disponibilidade SET horario = ? WHERE id = ?";
    $stmt = $conexao->prepare($update_query);
    $stmt->bind_param("si", $novo_horario, $id);
    $stmt->execute();

    // Verificar se a atualização foi bem-sucedida
    if ($stmt->affected_rows > 0) {
        echo "Horário atualizado com sucesso!";
    } else {
        echo "Erro ao atualizar o horário.";
    }

    // Redirecionar de volta para a página principal (ajuste conforme necessário)
    header("Location: gerenciar_agendamentos.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Horário</title>
</head>
<body>
    <h2>Editar Horário</h2>
    <form action="editar_horario.php?id=<?= $id ?>" method="POST">
        <label for="horario">Novo Horário:</label><br>
        <input type="time" name="horario" value="<?= $horario_atual ?>" required><br><br>
        <input type="submit" value="Atualizar Horário">
    </form>
</body>
</html>
