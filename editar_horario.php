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
    <title>New Age Saloon</title>
    <link rel="icon" href="img/main-conteudo/logo-nw.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
</head>
<style>
body {
    font-family: "Montserrat", sans-serif;
    background-image: url(img/back2.svg);
    justify-content: center;
    align-items: center;
    height: 100vh;
    color: #333;
    margin: 0;
    padding: 20px;
    overflow: hidden;
}

.back {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    margin: 20px;
}

.back a {
    text-decoration: none;
    color: #333;
    font-size: 16px;
    font-weight: bold;
    display: flex;
    align-items: center;
    padding: 10px 25px;;
    border-radius: 26px;
    background-color: #fff;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.back a:hover {
    background-color:#2980b9;
    color: white;
}

.back a::before {
    content: "\f0a8"; 
    font-weight: 900;
    margin-right: 10px; 
}


h2 {
    text-align: center;
    color: #2c3e50;
    font-size: 2rem;
    margin-top: .5rem;
    margin-bottom: 1rem;

}

   form {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    height: 75vh;
    background-color: #fff;
    padding: 40px;
    border-radius: 26px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    width: 500px;
    height: 550px;
    margin: 0 auto;
}

label {
    font-weight: bold;
    color: #2c3e50;
    display: block;
    margin-bottom: 5px;
    font-size: 1.2rem;
}


input[type="submit"] {
    background-color: #29ae60;
    padding: 20px 20px;
    font-size: 1.2rem;
    color: #fff;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease;
    margin: 0px;
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
<div class="back">
        <a href="gerenciar_agendamentos.php" class="fa-solid fa-circle-arrow-left">Voltar</a>
    </div>


    <form id="editarHorarioForm" action="editar_horario.php?id=<?= $id ?>" method="POST">
        <h2>Editar Horário</h2>
        <label for="horario">Novo Horário:</label><br>
        <input type="time" name="horario" value="<?= $horario_atual ?>" required><br><br>
        <input type="submit" value="Atualizar Horário">
    </form>
    <script>
        document.getElementById('editarHorarioForm').addEventListener('submit', function(event) {
            event.preventDefault(); 
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Seu horário foi atualizado!',
                showConfirmButton: false,
                timer: 2000
            }).then(() => {
                document.getElementById('editarHorarioForm').submit();
            });
        });
    </script>
</body>
</html>
