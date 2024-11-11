<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>New Age Saloon</title>
    <link rel="icon" href="img/main-conteudo/logo-nw.png" type="image/x-icon">
    <style>
        body {
            background-image: url(img/back2.svg);
            font-family: Arial, sans-serif;
            color: #333;
            display: grid;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            max-width: 800px;
            width: 100%;
            background: #fff;
            padding: 20px;
            border-radius: 26px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }

        .filters, .chart-type {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 15px;
        }

        .button-primary {
            padding: 10px 15px;
            text-decoration: none;
            color: #000;
            background-color: #d4a55d;
            border: none;
            border-radius: 16px;
            font-weight: 700;
            width: 120px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
.button-second {
    padding: 10px;
    color: #000;
    border: 2px solid #1b1b1b;
    border-radius: 16px;
    font-weight: 700;
    width: 200px;
    font-size: 14px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    margin-top: 0;
}

.button-pdf{
    color: #fff;
    background-color: #b30b00;
    border-radius: 16px;
    border: none;
    font-weight: 700;
    width: 200px;
    font-size: 14px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    margin-top: 0;
}


  
    </style>
</head>
<body>

<div class="button-container">
        <a href="admin_agendamentos.php" class="button-primary">Voltar</a>
    </div>
<div class="container">
    
    <h2>Estatísticas de Agendamentos Concluídos</h2>
    
    <!-- Canvas para o gráfico -->
    <canvas id="graficoAgendamentos" width="400" height="200"></canvas>

    <!-- Filtros e seleção de tipo de gráfico -->
    <div class="filters">
        <button onclick="filtrarEstatisticas('dia')" class="button-primary">Diário</button>
        <button onclick="filtrarEstatisticas('semana')" class="button-primary">Semanal</button>
        <button onclick="filtrarEstatisticas('mes')" class="button-primary">Mensal</button>
    </div>

</div>
<div class="chart-type">
        <button onclick="alterarTipoGrafico('bar')" class="button-second">Gráfico de Barras</button>
        <button onclick="alterarTipoGrafico('line')" class="button-second">Gráfico de Linhas</button>
        <button onclick="alterarTipoGrafico('pie')" class="button-second">Gráfico de Pizza</button>
        <button onclick="exportarPDF()" class="button-pdf">Exportar Relatório em PDF</button>
    </div>
    
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let chart;
const ctx = document.getElementById('graficoAgendamentos').getContext('2d');

function atualizarGrafico(data, tipo = 'bar') {
    if (chart) chart.destroy();

    chart = new Chart(ctx, {
        type: tipo,
        data: {
            labels: data.labels,
            datasets: [{
                label: 'Agendamentos Concluídos',
                data: data.totals,
                backgroundColor: tipo === 'pie' ? ['#4CAF50', '#FF6384', '#36A2EB' , '#20563E', '#b30b00' ] : '#20563E',
                borderColor: 'rgba()',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: tipo !== 'pie' ? { y: { beginAtZero: true } } : {},
            plugins: {
                title: { display: true, text: `Estatísticas do Barbeiro - ${data.barbeiro_nome}` }
            }
        }
    });
}

// Funções para filtro e tipo de gráfico
function filtrarEstatisticas(filtro) {
    const barbeiroId = new URLSearchParams(window.location.search).get('barbeiro_id');
    fetch(`obter_estatisticas.php?barbeiro_id=${barbeiroId}&filtro=${filtro}`)
        .then(response => response.json())
        .then(data => atualizarGrafico(data));
}

function alterarTipoGrafico(tipo) {
    const barbeiroId = new URLSearchParams(window.location.search).get('barbeiro_id');
    const filtroAtual = document.querySelector('.button-primary.active')?.dataset.filtro || 'dia';
    fetch(`obter_estatisticas.php?barbeiro_id=${barbeiroId}&filtro=${filtroAtual}`)
        .then(response => response.json())
        .then(data => atualizarGrafico(data, tipo));
}

filtrarEstatisticas('dia');

function exportarPDF() {
    html2canvas(document.querySelector("#graficoAgendamentos")).then(canvas => {
        const imgData = canvas.toDataURL("image/png");
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF();
        pdf.addImage(imgData, "PNG", 15, 20, 180, 100);
        pdf.setFontSize(18);
        pdf.text("Relatório de Agendamentos Concluídos", 15, 15);
        const dataAtual = new Date().toLocaleDateString();
        pdf.setFontSize(10);
        pdf.text(`Data de geração: ${dataAtual}`, 15, 140);
        pdf.save(`Relatorio_Agendamentos_${dataAtual}.pdf`);
    });
}
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

</body>
</html>
