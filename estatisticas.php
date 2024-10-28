<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Estatísticas de Agendamentos</title>
    <style>
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .button-primary { margin-top: 10px; padding: 8px 12px; color: #fff; background-color: #007bff; text-decoration: none; border-radius: 5px; cursor: pointer; }
        .filters { margin-top: 20px; display: flex; gap: 10px; }
        .chart-type { margin-top: 10px; display: flex; gap: 10px; }
        h2 { text-align: center; }
    </style>
</head>
<body>

<div class="container">
    <h2>Estatísticas de Agendamentos Concluídos</h2>
    
    <!-- Canvas para o gráfico -->
    <canvas id="graficoAgendamentos" width="400" height="200"></canvas>

    <!-- Filtros e seleção de tipo de gráfico -->
    <div class="filters">
        <button onclick="filtrarEstatisticas('dia')" class="button-primary">Por Dia</button>
        <button onclick="filtrarEstatisticas('semana')" class="button-primary">Por Semana</button>
        <button onclick="filtrarEstatisticas('mes')" class="button-primary">Por Mês</button>
    </div>

    <div class="chart-type">
        <button onclick="alterarTipoGrafico('bar')" class="button-primary">Gráfico de Barras</button>
        <button onclick="alterarTipoGrafico('line')" class="button-primary">Gráfico de Linhas</button>
        <button onclick="alterarTipoGrafico('pie')" class="button-primary">Gráfico de Pizza</button>
    </div>

    <div class="button-container">
        <a href="admin_agendamentos.php" class="button-primary">Voltar</a>
    </div>

    <button onclick="exportarPDF()" class="button-primary">Exportar Relatório em PDF</button>
</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let chart; // Variável para armazenar o gráfico
const ctx = document.getElementById('graficoAgendamentos').getContext('2d');

// Função para atualizar o gráfico com novos dados
function atualizarGrafico(data, tipo = 'bar') {
    if (chart) chart.destroy(); // Destroi o gráfico anterior

    chart = new Chart(ctx, {
        type: tipo,
        data: {
            labels: data.labels,
            datasets: [{
                label: 'Agendamentos Concluídos',
                data: data.totals,
                backgroundColor: tipo === 'pie' ? ['#4CAF50', '#FF6384', '#36A2EB'] : 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
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

function exportarPDF() {
    // Seleciona a área do gráfico para capturar como imagem
    html2canvas(document.querySelector("#graficoAgendamentos")).then(canvas => {
        const imgData = canvas.toDataURL("image/png");
        
        // Cria um documento PDF
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF();

        // Adiciona o gráfico como imagem no PDF
        pdf.addImage(imgData, "PNG", 15, 20, 180, 100);
        
        // Adiciona um título e informações adicionais
        pdf.setFontSize(18);
        pdf.text("Relatório de Agendamentos Concluídos", 15, 15);
        
        // Adiciona data atual no rodapé
        const dataAtual = new Date().toLocaleDateString();
        pdf.setFontSize(10);
        pdf.text(`Data de geração: ${dataAtual}`, 15, 140);
        
        // Salva o PDF com um nome padrão
        pdf.save(`Relatorio_Agendamentos_${dataAtual}.pdf`);
    });
}


// Função para buscar e filtrar estatísticas
function filtrarEstatisticas(filtro) {
    const barbeiroId = new URLSearchParams(window.location.search).get('barbeiro_id');
    fetch(`obter_estatisticas.php?barbeiro_id=${barbeiroId}&filtro=${filtro}`)
        .then(response => response.json())
        .then(data => atualizarGrafico(data));
}

// Função para mudar o tipo de gráfico
function alterarTipoGrafico(tipo) {
    const barbeiroId = new URLSearchParams(window.location.search).get('barbeiro_id');
    const filtroAtual = document.querySelector('.button-primary.active')?.dataset.filtro || 'dia';
    fetch(`obter_estatisticas.php?barbeiro_id=${barbeiroId}&filtro=${filtroAtual}`)
        .then(response => response.json())
        .then(data => atualizarGrafico(data, tipo));
}

// Carrega os dados iniciais por dia
filtrarEstatisticas('dia');

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

</body>
</html>
