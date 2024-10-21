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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<style>
    body{
    font-family: "Montserrat", sans-serif;
    background-image: url(img/back2.svg);
    justify-content: center;
    align-items: center;
    height: 100vh;
    color: #333;
    margin-top:50px;
    margin-bottom: 50px;
    padding: 20px;
    }

    h2 {
    text-align: center;
    color: #2c3e50;
    font-size: 24px;
}

   form {
    background-color: #fff;
    padding: 20px;
    border-radius: 26px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    max-width: 600px;
    margin: 0 auto;
}

label {
    font-weight: bold;
    color: #2c3e50;
    display: block;
    margin-bottom: 5px;
}

input[type="time"],
input[type="submit"],
button {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 26px;
    font-size: 16px;
    box-sizing: border-box;
}

input[type="time"]:focus {
    border-color: #3498db;
    box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
    outline: none;
}

</style>
<body>
<div class="back_gerenciar">
    <a href="#" class="fa-solid fa-circle-left">Voltar</a>
</div>
    <form action="editar_horario.php?id=<?= $id ?>" method="POST">
    <h2>Editar Horário</h2>
        <label for="horario">Novo Horário:</label><br>
        <input type="time" name="horario" value="<?= $horario_atual ?>" required><br><br>
        <input type="submit" value="Atualizar Horário">
    </form>
</body>
</html>
