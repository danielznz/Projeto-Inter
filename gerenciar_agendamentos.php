<?php
session_start();
include_once('config.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    echo "Usuário não logado.";
    exit;
}

// Carregar horários existentes para o barbeiro logado
$barbeiro_id = $_SESSION['usuario_id'];

// Verifica se o formulário foi submetido para adicionar ou editar horários
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['data']) && isset($_POST['horarios']) && is_array($_POST['horarios'])) {
    $data = $_POST['data'];
    $horarios = $_POST['horarios']; 

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
}

// Carregar horários para a data mais recente
$query = "SELECT id, data, horario FROM disponibilidade WHERE barbeiro_id = ?";
$stmt = $conexao->prepare($query);
$stmt->bind_param("i", $barbeiro_id);
$stmt->execute();
$result = $stmt->get_result();
$horarios_existentes = $result->fetch_all(MYSQLI_ASSOC);
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

    function abrirModal() {
        document.getElementById('modal-editar').style.display = 'flex';
    }

    function fecharModal() {
        document.getElementById('modal-editar').style.display = 'none';
    }
    </script>
    <style>
        /* Estilo básico para o modal */
        #modal-editar {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        #modal-content {
            background: white;
            padding: 20px;
            border-radius: 5px;
            width: 300px;
        }
    </style>
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

    <!-- Botão para abrir o modal -->
    <button type="button" onclick="abrirModal()">Ver Horários Cadastrados</button>

    <!-- Modal para editar/excluir horários -->
    <div id="modal-editar">
        <div id="modal-content">
            <h3>Horários Cadastrados</h3>
            <?php if (!empty($horarios_existentes)) : ?>
                <ul>
                    <?php foreach ($horarios_existentes as $horario) : ?>
                        <li>
                            Data: <?= $horario['data'] ?> - Hora: <?= $horario['horario'] ?>
                            <a href="editar_horario.php?id=<?= $horario['id'] ?>">Editar</a> |
                            <a href="excluir_horario.php?id=<?= $horario['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <p>Nenhum horário cadastrado para esse barbeiro.</p>
            <?php endif; ?>
            <button type="button" onclick="fecharModal()">Fechar</button>
        </div>
    </div>
</body>
</html>
