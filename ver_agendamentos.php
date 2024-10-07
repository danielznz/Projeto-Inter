<?php
session_start(); // Inicia a sessão para acessar o ID do usuário logado
include_once('config.php');

// Pega o ID do usuário logado
$usuario_id = $_SESSION['usuario_id'];

// Consulta para pegar os agendamentos do usuário logado
$result = mysqli_query($conexao, "SELECT * FROM agendamento WHERE usuario_id = '$usuario_id' ORDER BY data DESC");

if (mysqli_num_rows($result) > 0) {
    echo "<h2>Meus Agendamentos</h2>";
    echo "<table border='1'>
            <tr>
                <th>Serviço</th>
                <th>Barbeiro</th>
                <th>Data</th>
                <th>Horário</th>
            </tr>";
    
    // Exibir agendamentos
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>" . $row['servico'] . "</td>
                <td>" . $row['barbeiro'] . "</td>
                <td>" . date('d/m/Y', strtotime($row['data'])) . "</td> <!-- Formatando a data -->
                <td>" . $row['horario'] . "</td>
              </tr>";
    }
    
    echo "</table>";
} else {
    echo "<p>Você ainda não possui agendamentos.</p>";
}

mysqli_close($conexao);
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Agendamentos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Meus Agendamentos</h2>
        
        <?php if (mysqli_num_rows($result) > 0): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Serviço</th>
                        <th>Barbeiro</th>
                        <th>Data</th>
                        <th>Horário</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $row['servico']; ?></td>
                            <td><?php echo $row['barbeiro']; ?></td>
                            <td><?php echo date('d/m/Y', strtotime($row['data'])); ?></td>
                            <td><?php echo $row['horario']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Você ainda não possui agendamentos.</p>
        <?php endif; ?>
        
        <a href="sistema.php" class="btn btn-primary mt-3">Voltar</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
