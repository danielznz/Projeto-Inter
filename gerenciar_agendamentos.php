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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Big+Shoulders+Display:wght@100..900&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
       /* Estilos Gerais */
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

h2 {
    text-align: center;
    color: #2c3e50;
    font-size: 2rem;
    margin-top: .5rem;
    margin-bottom: 1rem;

}

.container-form{
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    height: 75vh;
}
form {
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

input[type="date"],
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

input[type="date"]:focus,
input[type="time"]:focus {
    border-color: #3498db;
    box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
    outline: none;
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
.button-container{
    display: flex;
    justify-content: center;
    margin-bottom: 2rem;
}


button {
    margin-top: 2rem;
    color: #000;
    cursor: pointer;
    transition: background-color 0.3s ease;
    padding: 15px 20px;
    background-color: #ccc;
    width: 230px;
    margin: 10px;

}




#horarios-container input[type="time"] {
    margin-bottom: 10px;
    width: calc(104% - 22px);
}

#horarios-container br {
    margin-bottom: 10px;
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

/* Modal */
#modal-editar {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    justify-content: center;
    align-items: center;
}

#modal-content {
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    max-width: 500px;
    width: 100%;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
}

#modal-content h3 {
    margin-top: 0;
    color: #2c3e50;
}

#modal-content ul {
    list-style-type: none;
    padding: 0;
}

#modal-content li {
    padding: 10px;
    background-color: #ecf0f1;
    border-radius: 5px;
    margin-bottom: 10px;
}

#modal-content a {
    text-decoration: none;
    color: #e74c3c;
    margin-left: 10px;
}

#modal-content button {
    background-color: #3498db;
    color: #fff;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 20px;
}

#modal-content button:hover {
    background-color: #2980b9;
}



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
            padding: 50px;
            border-radius: 26px;
            width: 325px;
        }
    </style>

</head>
<body>
<div class="back">
    <a href="adm.php" class="fa-solid fa-circle-left"> Voltar Para Tela de ADM</a>
</div>
    <h2>Gerenciar Disponibilidade</h2>
    <form action="gerenciar_agendamentos.php" method="post">
        <label for="data">Selecione os dias disponíveis:</label><br>
        <input type="date" name="data" required><br><br>

        <label for="horarios">Selecione os horários disponíveis:</label><br>
        <div id="horarios-container">
            <input type="time" name="horarios[]" required><br>
        </div>
        <div class="button-container">
        <button type="button" onclick="adicionarHorario()">Adicionar Horário <i class="fa-solid fa-plus" style="font-size: 15px;"></i></button>
        <button type="button" onclick="abrirModal()">Ver Horários <i class="fa-solid fa-eye"style="font-size: 15px;" ></i></button>
        <br><br>
        </div>
        <input type="submit" name="submit" value="Salvar Disponibilidade">
        <br><br>
    </form>



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
    <script>
        document.getElementById('gerenciarAgendamentosForm').addEventListener('submit', function(event) {
            event.preventDefault(); 
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Seu horário foi salvo!',
                showConfirmButton: false,
                timer: 2500
            }).then(() => {
                document.getElementById('gerenciarAgendamentosForm').submit();
            });
        });
    </script>

</body>
</html>
