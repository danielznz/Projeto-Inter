<?php
include_once('config.php');

$barbeiro_id = $_GET['barbeiro_id'] ?? null;
$filtro = $_GET['filtro'] ?? 'dia'; // 'dia' será o padrão

$dataLabels = [];
$dataTotals = [];
$barbeiro_nome = '';

if ($barbeiro_id) {
    // Obtenha o nome do barbeiro
    $sqlNome = "SELECT nome FROM usuarios WHERE id = ?";
    $stmtNome = $conexao->prepare($sqlNome);
    $stmtNome->bind_param("i", $barbeiro_id);
    $stmtNome->execute();
    $resultNome = $stmtNome->get_result();
    $barbeiro_nome = $resultNome->fetch_assoc()['nome'] ?? 'Desconhecido';

    // Escolha de filtro
    switch ($filtro) {
        case 'semana':
            $sql = "SELECT DATE_FORMAT(data, '%Y-%u') as periodo, COUNT(*) as total 
                    FROM agendamento 
                    WHERE status = 'concluido' AND barbeiro = ? 
                    GROUP BY periodo ORDER BY data";
            break;
        case 'mes':
            $sql = "SELECT DATE_FORMAT(data, '%Y-%m') as periodo, COUNT(*) as total 
                    FROM agendamento 
                    WHERE status = 'concluido' AND barbeiro = ? 
                    GROUP BY periodo ORDER BY data";
            break;
        default:
            $sql = "SELECT DATE(data) as periodo, COUNT(*) as total 
                    FROM agendamento 
                    WHERE status = 'concluido' AND barbeiro = ? 
                    GROUP BY DATE(data) ORDER BY data";
            break;
    }

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $barbeiro_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $dataLabels[] = $row['periodo'];
        $dataTotals[] = $row['total'];
    }
}

echo json_encode([
    'labels' => $dataLabels,
    'totals' => $dataTotals,
    'barbeiro_nome' => $barbeiro_nome
]);
?>
