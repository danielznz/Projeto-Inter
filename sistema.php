<?php
session_start(); // Inicia a sessão para acessar as variáveis de sessão
if (isset($_POST['submit-agendamento'])) {
    include_once('config.php');
    
    // Pega o ID do usuário logado da sessão
    $usuario_id = $_SESSION['usuario_id'];
    $servico = $_POST['servico'];
    $barbeiro = $_POST['barbeiro'];
    $data = $_POST['data'];
    $horario = $_POST['horario'];
    
    // Inclui o ID do usuário na inserção do agendamento
    $result = mysqli_query($conexao, "INSERT INTO agendamento(servico, barbeiro, data, horario, usuario_id) 
    VALUES('$servico','$barbeiro','$data','$horario', '$usuario_id')");
    
    if ($result) {
        // Redireciona para a mesma página ou para uma página de sucesso
        header("Location: sistema.php?success=true");
        exit();
    } else {
        // Caso de erro
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

// Exibe mensagem de sucesso se o agendamento foi realizado com sucesso
if (isset($_GET['success']) && $_GET['success'] == 'true') {
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
}

// Consulta para carregar os serviços disponíveis
include_once('config.php'); // Certifique-se de que a conexão esteja aberta
$query = "SELECT nome, preco FROM servicos WHERE ativo = 1";
$result = $conexao->query($query);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/footer.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Big+Shoulders+Display:wght@100..900&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
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
    --apoio7: #20563E;
    --primaria: #1b1b1b;
    --secundaria: #ffa155; 
    /* fontes */
    --fonteServices: "Big Shoulders Display", sans-serif;
    --fonteTitulo: "Montserrat", sans-serif;
}


body {
    font-family: var(--fonteTitulo);
    background-image: url(img/back2.svg);
}

.title-session{
    font-family: var(--fonteTitulo);
    color: var(--apoio5);
    font-size: 1rem;
}

header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 5px;
    background-color: var(--primaria);
    color: var(--apoio6);
}

.logo img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
}

.header-text h1 {
    font-size: 24px;
}

.main-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    max-width: 1200px;
    margin: 0 auto;
    min-height: 60vh;
    align-items: center;
}

.carousel {
    width: 500px;
    display: flex;
}

.form-container {
    width: 35%;
    background-color: #fff;
    padding: 20px;
    border-radius: 26px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    border: 1px solid var(--apoio5);
}

.form-section {
    margin-bottom: 15px;
}

label {
    margin-bottom: 5px;
    display: block;
    font-weight: bold;
    color: #333;
}

select, input[type="date"], input[type="time"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 26px;
    font-size: 16px;
}

input.btn-agendar {
    width: 100%;
    padding: 15px;
    border: none;
    border-radius: 26px;
    background-color: var(--apoio1);
    color: white;
    font-size: 16px;
    cursor: pointer;
}

input.btn-agendar:hover {
    background-color: var(--apoio2);
}

.carousel-item img {
    border-radius: 8px;
    width: 600px;
    height: 500px;
    object-fit: cover;
}
.agendamento-title{
    font-size: 3rem;
    text-align: center;
    margin: 2rem;
    font-family: var(--fonteServices);
}

.testimonials {
    display: flex;
    justify-content: space-between;
    gap: 20px;
    max-width: 1170px;
    margin: auto;
    margin-top: 4rem;
    margin-bottom: 10rem;
}

.testimonial-card {
    background-color: white;
    border-radius: 26px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    text-align: center;
    width: 30%;
    height: 340px;
    border: 1px solid var(--apoio5);
}


.profile-pic {
    border-radius: 50%;
    width: 80px;
    height: 80px;
    object-fit: cover;
    margin-bottom: 15px;
    margin-top: 15px;
    border: 1px solid var(--apoio5);
}

h3 {
    margin-bottom: 10px;
    font-size: 1.2em;
}

.stars {
    color: var(--apoio1);
    font-size: 1.4em;
    margin-bottom: 15px;
}

.link-header{
    text-decoration: none;
}
 
.btn_agendar{
    text-decoration: none;
    padding: 13px;
    background-color: #d4a55d; 
    border-color: #d4a55d;
    color: #2c2c2c;
    border-radius: 26px;
}

.btn_agendar:hover{
    color: #fff;
    background-color: #b48c47;
    border-color: #b48c47; 
}

</style>
<body>
    <header>
        <a href="index.html" class="link-header"><div class="logo">
            <h1 class="title-session"><img src="img/main-conteudo/logo-nw.png" alt="Logo da Barbearia"> Agendamento New Age</h1>
        </div>
        <div class="ver-agendamentos">
        <a href="ver_agendamentos.php" class="btn_agendar">Ver meus agendamentos</a>
        </div>
        </a>
    </header>

    <div>
        <h1 class="agendamento-title">Faça seu Agendamento </h1>
    </div>

    <div class="main-content">
        <div id="serviceCarousel" class="carousel slide col-md-7" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="img/cortes/corte1.jpeg"  class="d-block w-100" alt="Serviço 1">
                </div>
                <div class="carousel-item">
                    <img src="img/cortes/corte2.jpeg"  class="d-block w-100" alt="Serviço 1">
                </div>
                <div class="carousel-item">
                    <img src="img/cortes/corte3.jpeg"  class="d-block w-100" alt="Serviço 1">
                </div>
                <div class="carousel-item">
                    <img src="img/cortes/corte4.jpeg" class="d-block w-100" alt="Serviço 1">
                </div>
                <div class="carousel-item">
                    <img src="img/cortes/corte5.jpeg"  class="d-block w-100" alt="Serviço 1">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#serviceCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#serviceCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <div class="form-container">
    <form action="sistema.php" method="POST">
        <div class="form-section">
            <label for="servico">Escolha o Serviço:</label>
            <select id="servico" name="servico" required>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row['nome'] . ' - R$ ' . number_format($row['preco'], 2, ',', '.') . '">'
                     . $row['nome'] . ' - R$ ' . number_format($row['preco'], 2, ',', '.') .
                     '</option>';
            }
        } else {
            echo '<option value="">Nenhum serviço disponível</option>';
        }
        ?>
    </select>
        </div>

        <div class="form-section">
            <label for="barbeiro">Escolha o Barbeiro:</label>
            <select id="barbeiro" name="barbeiro" required>
                <option value="">Selecione um barbeiro</option>
                <option value="23">Matheus Barbosa</option>
                <option value="20">Vinicius Fraile</option>
                <option value="21">Danylo Vieira</option>
                <option value="22">Igor Góes</option>
                <option value="24">Diogenes Henrique</option>
            </select>
        </div>

        <div class="form-section">
            <label for="data">Escolha a Data:</label>
            <input type="date" id="data" name="data" required>
        </div>

        <div class="form-section">
            <label for="horario">Escolha o Horário:</label>
            <select id="horario" name="horario" required>
                <option value="">Selecione um horário</option>
            </select>
        </div>

        <input type="submit" class="btn-agendar" name="submit-agendamento" id="submit-agendamento" value="Enviar">
    </form>
</div>
        </div>

        <div>
            <h1 class="agendamento-title">Avaliações</h1>
        </div>

        <div class="testimonials">
            <div class="testimonial-card">
                <img src="img/avaliacoes/user2.png" alt="" class="profile-pic">
                <h3>John Nero</h3>
                <div class="stars">★★★★★</div>
                <p>Corto com eles desde a inauguração e 
                    não tenho do que reclamar, lugar com ótimos 
                    funcionários todos simpáticos e prestam um ótimo serviço 10/10</p>
            </div>
        
            <div class="testimonial-card">
                <img src="img/avaliacoes/user1.png" alt="" class="profile-pic">
                <h3>Robson Lima</h3>
                <div class="stars">★★★★★</div>
                <p>A melhor barbearia do Itaim Paulista! Atendimento top! Agenda organizada e ainda tem cafézinho com biscoito! 👌🏾</p>
            </div>
        
            <div class="testimonial-card">
                <img src="img/avaliacoes/user3.png" alt="" class="profile-pic">
                <h3>Giovanni Paulino</h3>
                <div class="stars">★★★★★</div>
                <p>Melhor barbearia de todas, 
                    sem explicação ❤️</p>
            </div>
        </div>
<footer id="">
    <div class="footer-content">
    <div class="footer">
        <div class="footer-info">
            <div class="location-info">
                <h4>Nossa localização</h4><br>
                <p>Rua Serra dos Aimorés, 38c<br>Itam Paulista - SP</p>
            </div>
            <div class="help-section">
            </div>
            <div class="social-media">
                <h4>Nos siga</h4><br>
                <ul>
                    <li><a href="https://www.instagram.com/nw.salon/" target="_blank"><i class="fa-brands fa-instagram"></i> Instagram</a></li>
                    <li><a href="#"><i class="fa-brands fa-facebook"></i> Facebook</a></li>
                </ul>
            </div>
            
        </div>
        <div class="footer-map">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3658.886306760673!2d-46.39806463554017!3d-23.50060426499567!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ce637ee780e3f1%3A0x7c208b40c0d15aea!2sR.%20Serra%20dos%20Aimor%C3%A9s%2C%2038c%20-%20Itaim%20Paulista%2C%20S%C3%A3o%20Paulo%20-%20SP%2C%2008120-080!5e0!3m2!1spt-BR!2sbr!4v1725918628781!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
    </div>
   </div>
    
    <div class="footer-bottom">
        <p>New Age Salon - Barbearia - CNPJ: 00.000.000/0000-00</p>
        <p>Copyright © 2024, TODOS OS DIREITOS RESERVADOS.</p>
    </div>
  </footer>
</body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</html>

<script>
document.getElementById('barbeiro').addEventListener('change', buscarHorarios);
document.getElementById('data').addEventListener('change', buscarHorarios);

function buscarHorarios() {
    var barbeiro = document.getElementById('barbeiro').value;
    var data = document.getElementById('data').value;

    // Garantir que barbeiro e data estão preenchidos antes de enviar a requisição
    if (barbeiro && data) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'buscar_horarios.php?barbeiro_id=' + barbeiro + '&data=' + data, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var horarios = JSON.parse(xhr.responseText);

                var selectHorario = document.getElementById('horario');
                selectHorario.innerHTML = '<option value="">Selecione um horário</option>';

                if (horarios.length > 0) {
                    horarios.forEach(function(horario) {
                        var option = document.createElement('option');
                        option.value = horario;
                        option.text = horario;
                        selectHorario.appendChild(option);
                    });
                } else {
                    selectHorario.innerHTML = '<option value="">Sem horários disponíveis</option>';
                }
            }
        };
        xhr.send();
    }
}
</script>

