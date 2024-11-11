<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>New Age Saloon</title>
    <link rel="icon" href="img/main-conteudo/logo-nw.png" type="image/x-icon">
</head>
<body>
<div class="button-container">
        <a href="adm.php" class="button-primary">Voltar</a>
    </div>
    <div class="body">
<div class='container'>
    
    <h2>Novos Agendamentos</h2>
    

    <?php
    session_start();
    include_once('config.php');
    
    $barbeiro_id = $_SESSION['usuario_id'];
    
    // Consulta para agendamentos não vistos
    $resultNovos = mysqli_query($conexao, "SELECT * FROM agendamento WHERE notificado_adm = 0 AND barbeiro = $barbeiro_id");
    
    // Consulta para agendamentos já vistos
    $resultAnteriores = mysqli_query($conexao, "SELECT * FROM agendamento WHERE notificado_adm = 1 AND barbeiro = $barbeiro_id");

    if (mysqli_num_rows($resultNovos) > 0) {
        echo "<table class='table'>";
        echo "<thead><tr><th>Serviço</th><th>Data</th><th>Horário</th><th>Detalhes</th></tr></thead>";
        echo "<tbody>";
        while ($row = mysqli_fetch_assoc($resultNovos)) {
            echo "<tr>";
            echo "<td>" . $row['servico'] . "</td>";
            echo "<td>" . $row['data'] . "</td>";
            echo "<td>" . $row['horario'] . "</td>";
            echo "<td><a href='marcar_visto.php?id=" . $row['idagendamento'] . "' class='button-primary'>Marcar como Visto</a>";
            echo "<a href='cancelar.php?id=" . $row['idagendamento'] . "' class='button-cancel'><i class='fas fa-ban'></i>Cancelar</a></td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<div class='alert'>Nenhum novo agendamento.</div>";
    }
    ?>

    <!-- Botão para exibir os agendamentos anteriores -->
    <button onclick="toggleAnteriores()" class="button-primary">Ver Agendamentos Anteriores</button>

    <!-- Tabela de agendamentos anteriores escondida inicialmente -->
    <div id="agendamentosAnteriores" style="display: none;">
        <h2>Agendamentos Anteriores</h2>
        <?php
        if (mysqli_num_rows($resultAnteriores) > 0) {
            echo "<table class='table'>";
            echo "<thead><tr><th>Serviço</th><th>Data</th><th>Horário</th></tr></thead>";
            echo "<tbody>";
            while ($row = mysqli_fetch_assoc($resultAnteriores)) {
                echo "<tr>";
                echo "<td>" . $row['servico'] . "</td>";
                echo "<td>" . $row['data'] . "</td>";
                echo "<td>" . $row['horario'] . "</td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<div class='alert'>Nenhum agendamento anterior.</div>";
        }
        ?>
    </div>
</div>
    </div>




</body>
</html>

<script>
function toggleAnteriores() {
    var section = document.getElementById("agendamentosAnteriores");
    if (section.style.display === "none") {
        section.style.display = "block";
    } else {
        section.style.display = "none";
    }
}
</script>


<style>
    /* Estilos Gerais */

body {
    background-image: url(img/back2.svg);
    font-family: "Montserrat", sans-serif;
    align-items: center;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}
.body {
    background-image: url(img/back2.svg);
    font-family: "Montserrat", sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 70vh;
    margin: 0;
}

.button-container{
    display: flex;
    margin: 2rem;
    justify-content: left;
}
.container {
    background-color: #ffffff;
    padding: 50px;
    border-radius: 26px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 80%;
    max-width: 900px;
}

/* Título */
h2 {
    font-weight: bold;
    color: #d4a55d;
    margin-bottom: 30px;
    text-align: center;
    border-bottom: 2px solid #e9ecef;
    padding-bottom: 10px;
}

/* Tabela de Agendamentos */
.table {
    width: 100%;
    border-collapse: collapse;
    margin: 30px 0;
}

.table thead {
    background-color: #1f3d33;
    color: #d4a55d;
}

.table thead th {
    padding: 15px;
    font-weight: bold;
}

.table tbody tr {
    background-color: #f9f9f9;
}

.table tbody tr:hover {
    background-color: #f1f1f1;
}

.table tbody td {
    padding: 15px;
    text-align: center;
    color: #2C2C2C;
}

/* Botões */
.button-container {
    text-align: center;
    margin-top: 20px;
}

.button-primary {
    background-color: #d4a55d; 
    border-color: #d4a55d;
    color: #2c2c2c;
    padding: 10px 15px;
    border: none;
    border-radius: 26px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    transition: background-color 0.3s;
}

.button-primary:hover {
    color: #fff;
    background-color: #b48c47;
    border-color: #b48c47;
}

.button-cancel {
    color: red;      
    font-size: 15px; 
    margin-left: 30px; 
    text-decoration: none;
    display: inline-flex;
    align-items: center;
}

.button-cancel:hover {
    color: darkred;
}

.button-cancel i {
    margin-right: 5px;
}


.fa-solid {
    color: red;      
    font-size: 20px; 
    margin-left: 30px; 
}

/* Alerta */
.alert {
    text-align: center;
    font-size: 18px;
    color: #2C2C2C;
    margin-top: 20px;
}

.visto td {
    text-decoration: line-through;
    color: gray;
}

.button-cancel {
    color: red;
    text-decoration: none;
    margin-left: 10px;
}


</style>