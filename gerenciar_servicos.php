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

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Serviços</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<?php if (isset($_GET['success']) && $_GET['success'] === 'true'): ?>
<script>
    Swal.fire({
        position: "center",
        icon: "success",
        title: "Serviço adicionado com sucesso!",
        showConfirmButton: false,
        timer: 2000
    });
</script>
<?php endif; ?>

<div class="back">
    <a href="adm.php" class="fa-solid fa-circle-left"> Voltar Para Tela de ADM</a>
</div>

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
                    <a href='javascript:void(0);' onclick='confirmDelete({$row['id']})'>Excluir</a>
                </td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='4'>Nenhum serviço cadastrado.</td></tr>";
    }
    ?>
</table>
<script>
    function confirmDelete(id) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger"
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: "Tem certeza?",
            text: "Essa ação não poderá ser revertida!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sim, excluir!",
            cancelButtonText: "Não, cancelar!",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `gerenciar_servicos.php?delete_id=${id}`;
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire({
                    title: "Cancelado",
                    text: "O serviço está seguro :)",
                    icon: "error"
                });
            }
        });
    }
</script>
<?php
// Fecha a conexão
$conexao->close();
?>


<style>
    :root {
    --primary-color: #4CAF50;
    --secondary-color: #f8f8f8;
    --text-color: #333;
    --border-color: #ddd;
    --button-color: #4CAF50;
    --button-hover: #45a049;
    --font-family: Arial, sans-serif;
}

/* Estilo geral */
body {
    font-family: var(--font-family);
    color: var(--text-color);
    background-image: url(img/back2.svg);
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.back {
    position: fixed;
    top: 20px;
    left: 20px;
    display: flex;
    align-items: center;
    justify-content: flex-start;
}

.back a {
    text-decoration: none;
    color: #333;
    font-size: 16px;
    font-weight: bold;
    display: flex;
    align-items: center;
    padding: 10px 25px;
    border-radius: 26px;
    background-color: #fff;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.back a:hover {
    background-color: #2980b9;
    color: white;
}

.back a::before {
    content: "\f0a8";
    font-weight: 900;
    margin-right: 10px;
}
/* Título */
h2, h3 {
    color: #d4a55d; 
    margin-top: 1rem;
}

/* Formulário */
form {
    background-color: #fff;
    padding: 1.5rem;
    border: 1px solid var(--border-color);
    border-radius: 26px;
    margin-bottom: 2rem;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 500px;
}

label {
    font-weight: bold;
    display: block;
    margin: 0.5rem 0 0.25rem;
}

input[type="text"],
input[type="number"],
textarea {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid var(--border-color);
    border-radius: 26px;
    margin-bottom: 1rem;
    font-size: 1rem;
    box-sizing: border-box;
}

input[type="submit"] {
    background-color: #29ae60;
    border-color: #d4a55d;
    color: #fff;
    padding: 0.7rem 1.5rem;
    border: none;
    border-radius: 26px;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s;
}

input[type="submit"]:hover {
    background-color: #29ae60;
}

/* Tabela */
table {
    width: 100%;
    max-width: 800px;
    border-collapse: collapse;
    background-color: #fff;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 2rem;
}

th, td {
    padding: 1.5rem;
    text-align: left;
    border-bottom: 1px solid var(--border-color);
}

th {
    background-color: #1f3d33; 
    color: #d4a55d; 
    font-weight: bold;
}

td {
    color: var(--text-color);
}


table td form {
    display: flex;
    flex-direction: column;
    align-items: center;
    background-color: #fff;
    padding: 1rem;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    margin: 0 auto;
    width: 100%;
    max-width: 180px;
}

table td form input[type="text"],
table td form input[type="number"] {
    width: 100%;
    padding: 0.5rem;
    margin: 0.3rem 0;
    font-size: 0.9rem;
    border-radius: 6px;
    border: 1px solid var(--border-color);
}

table td form input[type="submit"] {
    background-color: #29ae60;
    color: #fff;
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 6px;
    font-size: 0.9rem;
    cursor: pointer;
    transition: background-color 0.3s;
}

table td form input[type="submit"]:hover {
    background-color: #29ae60;
}


table td a {
    color: #d9534f;
    text-decoration: none;
    font-weight: bold;
}

table td a:hover {
    color: #c9302c;
}


a {
    color: #d9534f;
    text-decoration: none;
    font-weight: bold;
}

a:hover {
    color: #c9302c;
}

</style>

