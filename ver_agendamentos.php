<?php
session_start();
include_once('config.php');

$usuario_id = $_SESSION['usuario_id'];

$result = mysqli_query($conexao, "SELECT * FROM agendamento WHERE usuario_id = '$usuario_id' ORDER BY data DESC");

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Agendamentos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
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

body {
    background-image: url(img/back2.svg);
    font-family: "Montserrat", sans-serif;
}

.container {
    background-color: #ffffff;
    padding: 30px;
    border-radius: 26px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
}

h2 {
    font-weight: bold;
    color: #d4a55d; 
    margin-bottom: 30px;
    text-align: center;
    border-bottom: 2px solid #e9ecef;
    padding-bottom: 10px;
}

.table {
    margin-top: 30px;
}

.table thead {
    background-color: #1f3d33; 
    color: #d4a55d; 
}

.table tbody tr:hover {
    background-color: #f1f1f1;
}

.title-logo {
    display: flex;
    align-items: center; 
    justify-content: center; 
    gap: 5px; 
}

.title-logo h2 {
    font-weight: bold;
    color: #d4a55d; 
    margin: 0;
}

.title-logo img {
    width: 50px; 
    height: auto;
}

.btn-primary {
    background-color: #d4a55d; 
    border-color: #d4a55d;
    color: #2c2c2c; 
}

.btn-primary:hover {
    background-color: #b48c47;
    border-color: #b48c47;
}

p {
    text-align: center;
    font-size: 20px;
    color: #2C2C2C;
}

.fas.fa-ban {
    color: red;      
    font-size: 20px; 
    margin-left: 30px; 
}

a {
    text-decoration: none;
    margin-left: 30px;
    font-size: 16px;
}
</style>
<body>
    <div class="container mt-5">
        <div class="title-logo">
            <h2>Meus Agendamentos</h2>
            <img src="img/main-conteudo/logo-nw.png" alt="">
        </div>
        
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
                            <td><?php echo $row['horario']; ?>
                                <a href="#" class="cancelar-servico" data-id="<?php echo $row['idagendamento']; ?>">
                                    <i class="fas fa-ban"></i> Cancelar Serviço
                                </a>
                            </td>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            // Adicionar evento de clique no link de cancelar
            $('.cancelar-servico').on('click', function(e) {
                e.preventDefault(); // Impedir o comportamento padrão do link

                // Pegar o ID do agendamento
                const agendamentoId = $(this).data('id');

                // Exibir o alerta de confirmação
                Swal.fire({
                    title: "Deseja cancelar o serviço?",
                    text: "Você não poderá reverter essa ação!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Sim, cancelar!",
                    cancelButtonText: "Não cancelar!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Enviar requisição para excluir o agendamento específico
                        $.ajax({
                            url: 'excluir_agendamento.php', // Arquivo PHP para processar a exclusão
                            type: 'POST',
                            data: { id: agendamentoId },
                            success: function(response) {
                                Swal.fire({
                                    title: "Excluído!",
                                    text: "O serviço foi excluído com sucesso.",
                                    icon: "success"
                                }).then(() => {
                                    location.reload(); // Recarregar a página
                                });
                            },
                            error: function() {
                                Swal.fire({
                                    title: "Erro!",
                                    text: "Ocorreu um erro ao excluir o serviço.",
                                    icon: "error"
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>

<?php
// Fechando a conexão
mysqli_close($conexao);
?>
