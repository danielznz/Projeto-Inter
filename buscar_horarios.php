<?php
include_once('config.php');

if (isset($_GET['barbeiro_id']) && isset($_GET['data'])) {
    $barbeiro_id = $_GET['barbeiro_id'];
    $data = $_GET['data'];

    // Consulta os horários disponíveis para o barbeiro e a data selecionados
    $query = "SELECT horario FROM disponibilidade WHERE barbeiro_id = ? AND data = ?";
    $stmt = $conexao->prepare($query);
    $stmt->bind_param("is", $barbeiro_id, $data);
    $stmt->execute();
    $result = $stmt->get_result();

    $horarios = [];
    while ($row = $result->fetch_assoc()) {
        $horarios[] = $row['horario'];
    }

    echo json_encode($horarios);
} else {
    echo json_encode([]);
}
?>
