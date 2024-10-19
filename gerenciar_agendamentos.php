<?php
session_start();
include_once('config.php');

// Verifica se a requisição é do tipo POST e se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Verifica se o usuário logado é um barbeiro e se tem o ID armazenado na sessão
    if (isset($_SESSION['usuario_id']) && isset($_POST['data']) && isset($_POST['horarios']) && is_array($_POST['horarios'])) {
        $barbeiro_id = $_SESSION['usuario_id']; // Usa o ID do barbeiro logado
        $data = $_POST['data'];
        $horarios = $_POST['horarios']; // Deve ser um array de horários

        // Limpar horários antigos para essa data e barbeiro
        $delete_query = "DELETE FROM disponibilidade WHERE barbeiro_id = ? AND data = ?";
        $stmt_delete = $conexao->prepare($delete_query);
        $stmt_delete->bind_param("is", $barbeiro_id, $data);
        $stmt_delete->execute();

        // Inserir novos horários disponíveis
        $insert_query = "INSERT INTO disponibilidade (barbeiro_id, data, horario) VALUES (?, ?, ?)";
        $stmt_insert = $conexao->prepare($insert_query);

        foreach ($horarios as $horario) {
            $stmt_insert->bind_param("iss", $barbeiro_id, $data, $horario);
            $stmt_insert->execute();
        }

        // Verificação de sucesso
        if ($stmt_insert->affected_rows > 0) {
            echo "Horários atualizados com sucesso!";
        } else {
            echo "Erro ao atualizar os horários.";
        }
    } else {
        echo "Dados inválidos fornecidos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Agendamentos</title>
    <script>
    function adicionarHorario() {
        var container = document.getElementById('horarios-container');
        var input = document.createElement('input');
        input.type = 'time';
        input.name = 'horarios[]';
        input.required = true;
        container.appendChild(input);
        container.appendChild(document.createElement('br'));
    }
    </script>
</head>
<body>
    <h2>Gerenciar Disponibilidade</h2>
    <form action="gerenciar_agendamentos.php" method="post">
        <label for="data">Selecione os dias disponíveis:</label><br>
        <input type="date" name="data" required><br><br>

        <label for="horarios">Selecione os horários disponíveis:</label><br>
        <div id="horarios-container">
            <input type="time" name="horarios[]" required><br>
        </div>
        <button type="button" onclick="adicionarHorario()">Adicionar Horário</button><br><br>

        <input type="submit" name="submit" value="Salvar Disponibilidade">
    </form>
</body>
</html>
