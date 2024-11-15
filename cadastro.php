<?php
if (isset($_POST['submit'])) {
    include_once('config.php');

    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $result = mysqli_query($conexao, "INSERT INTO usuarios(nome, telefone, email, senha) VALUES('$nome','$telefone','$email','$senha')");

    if ($result) {
        echo "
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Cadastro bem-sucedido!',
                    text: 'Seu cadastro foi realizado com sucesso.',
                    confirmButtonText: 'OK'
                });
            });
        </script>";
    } else {
        echo "
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro no cadastro',
                    text: 'Ocorreu um erro ao tentar realizar o cadastro.',
                    confirmButtonText: 'OK'
                });
            });
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cadastro.css">
    <title>Tela de Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Big+Shoulders+Display:wght@100..900&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="main-login">
        <form action="cadastro.php" method="POST">
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
    
    </div>
</body>
</html>
