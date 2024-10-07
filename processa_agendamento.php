<?php
if (isset($_POST['submit'])) {

    include_once('config.php');

    $servico = $_POST['service'];
    $barbeiro = $_POST['barber'];
    $data = $_POST['date'];
    $horario = $_POST['time'];

    $sql = "INSERT INTO agendamento (servico, barbeiro, data, horario) 
            VALUES ('$servico', '$barbeiro', '$data', '$horario')";

    if (mysqli_query($conexao, $sql)) {
        echo "
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Agendamento realizado!',
                    text: 'Seu agendamento foi registrado com sucesso.',
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
                    title: 'Erro no agendamento',
                    text: 'Ocorreu um erro ao tentar registrar o agendamento.',
                    confirmButtonText: 'OK'
                });
            });
        </script>";
    }
    
    mysqli_close($conexao);
}

?>

