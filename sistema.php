<?php
session_start();
    if((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true))
    {
        unset($_SESSION['email']);
        unset($_SESSION['senha']);
        header('Location: login.php');
    }
    $logado = $_SESSION['email'];
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

button.btn-agendar {
    width: 100%;
    padding: 20px;
    border: none;
    border-radius: 26px;
    background-color: var(--apoio1);
    color: white;
    font-size: 16px;
    cursor: pointer;
}

button.btn-agendar:hover {
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

</style>
<body>
    <header>
        <div class="logo">
            <h1 class="title-session"><img src="img/main-conteudo/logo-nw.png" alt="Logo da Barbearia"> Agendamento New Age</h1>
        </div>
    </header>

    <div>
        <h1 class="agendamento-title">Faça seu Agendamento </h1>
    </div>

    <div class="main-content">
        <div id="serviceCarousel" class="carousel slide col-md-7" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="img/servicos-card/img-4.png" class="d-block w-100" alt="Serviço 1">
                </div>
                <div class="carousel-item">
                    <img src="img/servicos-card/img-5.png" class="d-block w-100" alt="Serviço 1">
                </div>
                <div class="carousel-item">
                    <img src="img/servicos-card/img-1.png" class="d-block w-100" alt="Serviço 1">
                </div>
                <div class="carousel-item">
                    <img src="img/servicos-card/img-3.png" class="d-block w-100" alt="Serviço 1">
                </div>
                <div class="carousel-item">
                    <img src="img/servicos-card/img-2.png" class="d-block w-100" alt="Serviço 1">
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
            <form id="formAgendamento">
                <div class="form-section">
                    <label for="service">Escolha o Serviço:</label>
                    <select id="service" name="service" required>
                        <option value="Corte - R$ 30,00">Corte - R$ 30,00</option>
                        <option value="Barba - R$ 20,00">Barba - R$ 20,00</option>
                        <option value="Sobrancelha - R$ 15,00">Sobrancelha - R$ 15,00</option>
                        <option value="Corte + Barba - R$ 45,00">Corte + Barba - R$ 45,00</option>
                        <option value="Corte + Barba + Sobrancelha - R$ 55,00">Corte + Barba + Sobrancelha - R$ 55,00</option>
                    </select>
                </div>
        
                <div class="form-section">
                    <label for="barber">Escolha o Barbeiro:</label>
                    <select id="barber" name="barber">
                        <option value="Sem preferência">Sem preferência</option>
                        <option value="Vinicius Fraile">Vinicius Fraile</option>
                        <option value="Danylo Vieira">Danylo Vieira</option>
                        <option value="Igor Góes">Igor Góes</option>
                        <option value="Matheus Barbosa">Matheus Barbosa</option>
                        <option value="Diogenes Henrique">Diogenes Henrique</option>
                    </select>
                </div>
        
                <div class="form-section">
                    <label for="date">Escolha a Data:</label>
                    <input type="date" id="date" name="date" required>
                </div>
        
                <div class="form-section">
                    <label for="time">Escolha o Horário:</label>
                    <input type="time" id="time" name="time" required>
                </div>
        
                <button type="submit" class="btn-agendar">Agendar</button>
            </form>
        </div>
       
    <script>
        document.getElementById('formAgendamento').addEventListener('submit', function(event) {
            event.preventDefault(); 
            const servico = document.getElementById('service').value;
            const barbeiro = document.getElementById('barber').value;
            const data = document.getElementById('date').value;
            const horario = document.getElementById('time').value;

            if (servico && barbeiro && data && horario) {
                window.location.href = `email.html?servico=${encodeURIComponent(servico)}&barbeiro=${encodeURIComponent(barbeiro)}&data=${encodeURIComponent(data)}&horario=${encodeURIComponent(horario)}`;
            } else {
                alert("Por favor, preencha todos os campos.");
            }
        });
    </script>
        </div>

        <div>
            <h1 class="agendamento-title">Avaliações</h1>
        </div>

        <div class="testimonials">
            <div class="testimonial-card">
                <img src="img/avaliacoes/user2.png"" alt="" class="profile-pic">
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