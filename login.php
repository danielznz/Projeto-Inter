<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cadastro.css">
    <title>Tela de Login</title>
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

    <!-- <script>
        let isAdmin = false;

        function handleLogin() {
            const email = document.getElementById("email").value;
            const senha = document.getElementById("senha").value;

            if (email === "admin@nwsaloon" && senha === "admin123") {
                isAdmin = true;
                document.getElementById("admin-auth").style.display = "block";
                Swal.fire({
                    title: 'Admin Identificado!',
                    text: 'Insira o código de administrador para continuar.',
                    icon: 'info',
                    confirmButtonText: 'OK'
                });
            } 
            else if (email === "usuario@comum" && senha === "senhausuario") {
                Swal.fire({
                    title: 'Sucesso!',
                    text: 'Login realizado com sucesso!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = "adm.html";
                });
            } 
            else {
                Swal.fire({
                    title: 'Erro!',
                    text: 'Email ou senha incorretos!',
                    icon: 'error',
                    confirmButtonText: 'Tentar novamente'
                });
            }
        }

        function confirmarAdmin() {
            const codigo = document.getElementById("codigo").value;

            if (isAdmin && codigo === "codigoAdmin123") {
                Swal.fire({
                    title: 'Sucesso!',
                    text: 'Bem-vindo, administrador!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = "adm.html"; 
                });
            } else if (isAdmin && codigo !== "codigoAdmin123") {
                Swal.fire({
                    title: 'Erro!',
                    text: 'Código de administrador incorreto!',
                    icon: 'error',
                    confirmButtonText: 'Tentar novamente'
                });
            }
        }
        document.querySelector('.btn-login').addEventListener('click', function() {
            if (isAdmin) {
                confirmarAdmin();
            } else {
                handleLogin();
            }
        });
    </script> -->
</body>
</html>