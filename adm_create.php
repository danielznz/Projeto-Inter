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
        // Hash da senha
        $senhaHasheada = password_hash($senha, PASSWORD_DEFAULT);

        // Inserir o novo administrador no banco de dados
        $sqlInsert = "INSERT INTO usuarios (nome, telefone, email, senha, role) VALUES (?, ?, ?, ?, 'super_admin')";
        $stmtInsert = $conexao->prepare($sqlInsert);
        $stmtInsert->bind_param("sssss", $nome, $telefone, $email, $senhaHasheada);
        
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
    <title>Document</title>
</head>
<body>
<form action="adm_create.php" method="POST">
            <div class="card-login">
                <img src="img/main-conteudo/logo-nw.png" height="80px" alt="Logo da Barbearia NW Salon" class="main-img-logo" />
                <div class="logo-title">
                <h1>Cadastro</h1>
            </div>
            <div class="textfield">
                <label for="nome">Nome Completo</label>
                <input type="text" name="nome" placeholder="Nome">
            </div>
            <div class="textfield">
                <label for="telefone">Telefone</label>
                <input type="number" name="telefone" placeholder="Numero de telefone">
            </div>
                <div class="textfield">
                    <label for="email">Email</label>
                    <input type="email" name="email" placeholder="Email">
                </div>
                <div class="textfield">
                    <label for="senha">Senha</label>
                    <input type="password" name="senha" placeholder="Senha">
                </div>
                <input type="submit" class="btn-login" name="submit" id="submit">
                <div class="no-register">
                <a href="login.php">Voltar ao Login</a>
            </div>
            </div>
            <form>
</body>
</html>