<?php
include_once('config.php');

// Adicionar um novo serviço
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_servico'])) {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];

    $query = "INSERT INTO servicos (nome, descricao, preco) VALUES (?, ?, ?)";
    $stmt = $conexao->prepare($query);
    $stmt->bind_param("ssd", $nome, $descricao, $preco);

    if ($stmt->execute()) {
        // Redireciona para a mesma página após o sucesso, usando o método GET para evitar re-envio de dados
        header("Location: gerenciar_servicos.php?success=true");
        exit();
    } else {
        echo "Erro ao adicionar serviço: " . $stmt->error;
    }
}

// Editar um serviço existente
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar_servico'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];

    $query = "UPDATE servicos SET nome = ?, descricao = ?, preco = ? WHERE id = ?";
    $stmt = $conexao->prepare($query);
    $stmt->bind_param("ssdi", $nome, $descricao, $preco, $id);

    if ($stmt->execute()) {
        echo "Serviço atualizado com sucesso!";
    } else {
        echo "Erro ao atualizar serviço: " . $stmt->error;
    }

    $stmt->close();
}

// Excluir um serviço
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];

    $query = "DELETE FROM servicos WHERE id = ?";
    $stmt = $conexao->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Serviço excluído com sucesso!";
    } else {
        echo "Erro ao excluir serviço: " . $stmt->error;
    }

    $stmt->close();
}

// Consultar todos os serviços para exibir na tabela
$query = "SELECT * FROM servicos";
$result = $conexao->query($query);
?>

<h2>Gerenciar Serviços</h2>

<!-- Formulário para adicionar novo serviço -->
<form action="gerenciar_servicos.php" method="post">
    <label for="nome">Nome do Serviço:</label><br>
    <input type="text" id="nome" name="nome" required><br><br>

    <label for="descricao">Descrição:</label><br>
    <textarea id="descricao" name="descricao" rows="4" cols="50" required></textarea><br><br>

    <label for="preco">Preço:</label><br>
    <input type="number" id="preco" name="preco" step="0.01" required><br><br>

    <input type="submit" name="submit_servico" value="Adicionar Serviço">
</form>

<!-- Tabela de Serviços -->
<h3>Serviços Cadastrados</h3>
<table border="1">
    <tr>
        <th>Nome</th>
        <th>Descrição</th>
        <th>Preço</th>
        <th>Ações</th>
    </tr>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['nome']}</td>
                <td>{$row['descricao']}</td>
                <td>R$ " . number_format($row['preco'], 2, ',', '.') . "</td>
                <td>
                    <form action='gerenciar_servicos.php' method='post' style='display:inline-block;'>
                        <input type='hidden' name='id' value='{$row['id']}'>
                        <input type='text' name='nome' value='{$row['nome']}' required>
                        <input type='text' name='descricao' value='{$row['descricao']}' required>
                        <input type='number' name='preco' value='{$row['preco']}' step='0.01' required>
                        <input type='submit' name='editar_servico' value='Editar'>
                    </form>
                    <a href='gerenciar_servicos.php?delete_id={$row['id']}' onclick='return confirm(\"Tem certeza que deseja excluir este serviço?\")'>Excluir</a>
                </td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='4'>Nenhum serviço cadastrado.</td></tr>";
    }
    ?>
</table>

<?php
// Fecha a conexão
$conexao->close();
?>


<style>
/* Estilos Gerais */
body {
    background-image: url(img/back2.svg);
    font-family: "Montserrat", sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.container {
    background-color: #ffffff;
    padding: 50px;
    border-radius: 26px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 80%;
    max-width: 900px;
}

/* Título */
h2 {
    font-weight: bold;
    color: #d4a55d;
    margin-bottom: 30px;
    text-align: center;
    border-bottom: 2px solid #e9ecef;
    padding-bottom: 10px;
}

/* Formulário */
form {
    margin-bottom: 30px;
}

label {
    font-weight: bold;
    color: #2c2c2c;
}

input[type="text"],
input[type="number"],
textarea {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    margin-bottom: 20px;
    border: 1px solid #d4a55d;
    border-radius: 10px;
    font-size: 16px;
}

input[type="submit"] {
    background-color: #d4a55d;
    color: #2c2c2c;
    padding: 10px 15px;
    border: none;
    border-radius: 26px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s;
}

input[type="submit"]:hover {
    color: #fff;
    background-color: #b48c47;
}

/* Tabela de Serviços */
table {
    width: 100%;
    border-collapse: collapse;
    margin: 30px 0;
}

thead {
    background-color: #1f3d33;
    color: #d4a55d;
}

thead th {
    padding: 15px;
    font-weight: bold;
}

tbody tr {
    background-color: #f9f9f9;
    transition: background-color 0.2s;
}

tbody tr:hover {
    background-color: #f1f1f1;
}

tbody td {
    padding: 15px;
    text-align: center;
    color: #2C2C2C;
}

/* Botões de Ações */
button, .button-cancel {
    background-color: #d4a55d;
    color: #2c2c2c;
    padding: 8px 12px;
    border: none;
    border-radius: 20px;
    font-size: 14px;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s;
    margin: 5px;
}

button:hover, .button-cancel:hover {
    color: #fff;
    background-color: #b48c47;
}

.button-cancel {
    background-color: transparent;
    color: red;
    font-size: 14px;
    margin-left: 0;
    padding: 0;
    border: none;
    cursor: pointer;
}

.button-cancel:hover {
    color: darkred;
}

/* Alerta */
.alert {
    text-align: center;
    font-size: 18px;
    color: #2C2C2C;
    margin-top: 20px;
}
</style>