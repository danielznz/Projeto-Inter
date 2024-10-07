<?php
session_start();

if (isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['senha'])) {
    // Acessa o sistema
    include_once('config.php');
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Consulta para verificar email e senha e obter o ID do usuário
    $sql = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'";
    $result = $conexao->query($sql);

    if (mysqli_num_rows($result) < 1) {
        // Login falhou, redireciona para a página de login
        unset($_SESSION['email']);
        unset($_SESSION['senha']);
        header('Location: login.php');
    } else {
        // Login bem-sucedido, armazena o id do usuário na sessão
        $usuario = mysqli_fetch_assoc($result);
        $_SESSION['usuario_id'] = $usuario['id']; // Armazena o ID do usuário logado
        $_SESSION['email'] = $email; // Pode manter o email na sessão se desejar

        // Redireciona para o sistema
        header('Location: sistema.php');
    }
} else {
    // Se email ou senha estiverem vazios, redireciona para a página de login
    header('Location: login.php');
}
?>
