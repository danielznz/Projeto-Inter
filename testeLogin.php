<?php
session_start();
$_SESSION['usuario_id'] = $usuario_id; // ID do barbeiro logado


if (isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['senha'])) {
    // Acessa o sistema
    include_once('config.php');
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Consulta usando prepared statements para evitar SQL Injection
    $sql = "SELECT * FROM usuarios WHERE email = ? LIMIT 1";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $email); // Liga o parâmetro $email
    $stmt->execute();
    $result = $stmt->get_result();
    $usuario = $result->fetch_assoc();

    // Verifica se encontrou o usuário e se a senha está correta
    if ($usuario && $senha === $usuario['senha']) {
        // Login bem-sucedido, armazena o id e role (papel) do usuário na sessão
        $_SESSION['usuario_id'] = $usuario['id']; // ID do usuário logado
        $_SESSION['email'] = $email; // Email do usuário

        // Verifica o papel do usuário (super_admin) para acesso ao painel de administração
        if ($usuario['role'] === 'super_admin') {
            // Armazena informações do administrador na sessão
            $_SESSION['role'] = $usuario['role']; // Armazena o papel na sessão
            $_SESSION['nome'] = $usuario['nome']; // Nome do barbeiro
            $_SESSION['telefone'] = $usuario['telefone']; // Telefone do barbeiro

            // Redireciona para a página de administração
            header('Location: adm.php');
        } else {
            // Se for usuário comum, redireciona para o sistema
            header('Location: sistema.php');
        }
    } else {
        // Login falhou, redireciona para a página de login
        unset($_SESSION['email']);
        unset($_SESSION['senha']);
        header('Location: login.php');
    }
} else {
    // Se email ou senha estiverem vazios, redireciona para a página de login
    header('Location: login.php');
}
?>
