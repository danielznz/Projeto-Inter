<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo - Barbearia</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Big+Shoulders+Display:wght@100..900&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
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
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .header{
            background-color: #20563E;
            padding: 15px;
        }
        body {
            font-family: var(--fonteTitulo);
            background-color: #f4f4f4;
            overflow: hidden;
     
        }
        .flex{
            display: flex;
            height: 100vh;
         
        }
        .header {
            color: #fff;

            text-align: center;
            width: 100%;
        }
        .container {
            display: flex;
            flex-grow: 1;
        }
        .sidebar {
            width: 250px;
            background-color: var(--primaria);
            color: #fff;
            display: flex;
            flex-direction: column;
        }
        .sidebar a {
            color: var(--apoio5);
            text-decoration: none;
            margin-top: 25px;
            font-size: 1rem;
            transition: color 0.3s;
            padding: 10px;
            transition: .1s;
        }
        .sidebar a:hover {
            background-color: var(--apoio4);

        }
        .menu-img{
            margin-right: .3rem;
        }
        .main-content {
            flex: 1;
            padding: 20px;
        }

        .main-content h1 {
            font-size: 2.5rem;
            font-weight: 500;
            margin-bottom: 20px;
            text-align: left;
            margin-left: .5rem;
        }
        .grid-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 26px;
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
            border: 1px solid #e0e0e0;
        }

        .card {
            background-color: #fff;
            border-radius: 26px;
            border: 1px solid #e0e0e0;
            text-align: center;
            transition: transform 0.2s, box-shadow 0.2s;
            margin: 0;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
        }

        .card h3 {
            font-size: 20px;
            margin-bottom: 10px;
            background-color: #ececec;
            padding: 10px 5px;
            border-radius: 26px 26px 0px 0px ;
        }

        .card p {
            font-size: 16px;
            margin-bottom: 20px;
        }
        .p-header{
            font-size: 1rem;
            padding: 5px;
            text-align: left;
        }
        .vetor-card{
            margin: 10px;
        }

.card-link{
    text-decoration: none;
    color: var(--primaria);
}
    </style>
</head>
<body>
    <div class="header">
      <p class="p-header">Painel Administrativo - NW SALOON</p>
    </div>
    <div class="flex">
    <div class="container">
        <div class="sidebar">
            <a href="#">Dashboard</a>
            <a href="adm_create.php"><img src="img/menu/menu-adm.png" class="menu-img" height="16px">Criar Administrador</a>
            <a href="#"><img src="img/menu/menu-grafico.png" class="menu-img" height="16px">Ver Estatísticas</a>
            <a href="#"><img src="img/menu/menu-gerenciar.png" class="menu-img" >Gerenciar Barbeiros</a>
            <a href="gerenciar_agendamentos.php"><img src="img/menu/menu-agendar.png" class="menu-img" height="16px">Agendamentos</a>
            <a href="index.html"><img src="img/menu/menu-sair.png"  class="menu-img" height="16px">Sair</a>
        </div>
        <div class="main-content">
            <h1>Painel Administrativo</h1>
            <div class="grid-container">
                <a href="adm_create.php" class="card-link">
                <div class="card">
                    <h3>Criar Administrador</h3>
                    <p>Adicione novos administradores ao sistema</p>
                    <img src="/img/adm.png" class="vetor-card" height="100px">
                </div>
                </a>
                <a href="adm_create.php" class="card-link">
                <div class="card">
                    <h3>Gerenciar Barbeiros</h3>
                    <p>Controle os horários e informações dos barbeiros</p>
                    <img src="/img/gerencia.png" class="vetor-card"  height="100px">
                </div>
                </a>
                <a href="adm_create.php" class="card-link">
                <div class="card">
                    <h3>Gerenciar Agendamentos</h3>
                    <p>Acompanhe e gerencie os agendamentos</p>
                    <img src="/img/calendario.png"class="vetor-card"  height="100px">
                </div>
                </a>
                <a href="adm_create.php" class="card-link">
                <div class="card">
                    <h3>Ver Estatísticas</h3>
                    <p>Veja as estatísticas da barbearia</p>
                    <img src="/img/grafico.png"class="vetor-card"  height="100px">
                </div>
                </a>
            </div>
        </div>
    </div>
    

</body>
</html>
