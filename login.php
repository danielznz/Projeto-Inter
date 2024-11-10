<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cadastro.css">
    <title>New Age Saloon</title>
    <link rel="icon" href="img/main-conteudo/logo-nw.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="main-login">
        <form action="testeLogin.php" method="POST">
        <div class="card-login">
            <img src="img/main-conteudo/logo-nw.png" height="80px" alt="Logo da Barbearia NW Salon" class="main-img-logo" />
            <div class="logo-title">
                <h1>Login</h1>
            </div>
            <div class="textfield">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Email">
            </div>
            <div class="textfield">
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" placeholder="Senha">
            </div>
            <div class="textfield" id="admin-auth" style="display:none;">
                <label for="codigo">Código de Acesso</label>
                <input type="text" id="codigo" name="codigo" placeholder="Digite o código de administrador">
            </div>
            <input class="btn-login" type="submit" name="submit" value="Enviar">
            <div class="no-register">
                <a href="cadastro.php">Não possui conta? Clique aqui</a>
            </div>
        </div>
        </form>
    </div>
</body>
</html>
