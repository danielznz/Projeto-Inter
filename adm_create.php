<?php
session_start();
include_once('config.php'); // Inclua seu arquivo de configuração do banco de dados

if (isset($_POST['submit'])) {
    // Coletar dados do formulário
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Verificar se o email já existe
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Email já está em uso
        echo "Email já está em uso!";
    } else {
 
        // Inserir o novo administrador no banco de dados
        $sqlInsert = "INSERT INTO usuarios (nome, telefone, email, senha, role) VALUES (?, ?, ?, ?, 'super_admin')";
        $stmtInsert = $conexao->prepare($sqlInsert);
        $stmtInsert->bind_param("ssss", $nome, $telefone, $email, $senha);
        
        if ($stmtInsert->execute()) {
            // Cadastro bem-sucedido
            echo "Administrador criado com sucesso!";
        } else {
            // Erro ao inserir
            echo "Erro ao criar administrador: " . $stmtInsert->error;
        }
    }

    // Fechar as conexões
    $stmt->close();
    $stmtInsert->close();
    $conexao->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Age Saloon</title>
    <link rel="icon" href="img/main-conteudo/logo-nw.png" type="image/x-icon">
</head>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

:root {
    /* cores */
    --apoio1: #ee7919;
    --apoio2: #ff9a48;
    --apoio3: #FEAD6C;
    --apoio4: #2C2C2C;
    --apoio5: #ccc;
    --apoio6: #f2f2f2;
    --primaria: #1b1b1b;
    --secundaria: #ffa155; 
    /* fontes */
    --fonteServices: "Big Shoulders Display", sans-serif;
    --fonteTitulo: "Montserrat", sans-serif;
}

body{
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    height: 100vh;
    background: var(--primaria);
    font-family: var(--fonteTitulo);
}

.card-login {
    width: 500px;
    padding: 70px 60px;
    background: var(--apoio6);
    border-radius: 46px;
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
}

.main-img-logo{
    display: flex;
    margin: 0 auto;
}
.logo-title {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
    margin-top: 1rem;
}


.logo-title h1 {
    font-size: 2rem;
    color: #262626;
}

.textfield {
    display: flex;
    flex-direction: column;
    margin-bottom: 20px;
}

.textfield label {
    margin-bottom: 5px;
    font-size: 1rem;
    color: #333;
}

.textfield input {
    padding: 15px;
    border: 1px solid #ccc;
    border-radius: 26px;
    font-size: 1rem;
}

.textfield input:focus {
    border: 1px solid var(--primaria);
    outline: none;
}

.btn-login {
    width: 100%;
    padding: 15px;
    background-color: var(--primaria);
    margin-top: 1.2rem;
    color: #fff;
    border: none;
    border-radius: 26px;
    font-size: 1.2rem;
    cursor: pointer;
    transition: 0.3s;
}

.btn-login:hover {
    background-color: #444;
}

.no-register {
    text-align: center;
    margin-top: 2rem;
}


</style>
<body>
    <form action="adm_create.php" method="POST">
        <div class="card-login">
            <img src="img/main-conteudo/logo-nw.png" height="80px" alt="Logo da Barbearia NW Salon" class="main-img-logo" />
            <div class="logo-title">
                <h1>Cadastro de ADM</h1>
            </div>
            <div class="textfield">
                <label for="nome">Nome Completo</label>
                <input type="text" name="nome" placeholder="Nome" required>
            </div>
            <div class="textfield">
                <label for="telefone">Telefone</label>
                <input type="number" name="telefone" placeholder="Número de telefone" required>
            </div>
            <div class="textfield">
                <label for="email">Email</label>
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="textfield">
                <label for="senha">Senha</label>
                <input type="password" name="senha" placeholder="Senha" required>
            </div>
            <input type="submit" class="btn-login" name="submit" value="Cadastrar">
            <div class="no-register">
                <a href="adm.php">Voltar a tela de Adm</a>
            </div>
        </div>
    </form>
</body>
</html>
