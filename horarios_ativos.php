<?php
// include_once "config.php";

// if (isset($_GET['data'])) {
//     $data = $_GET['data'];

//     $sql = "SELECT time FROM finalidade WHERE data = ?";
//     $stmt = $conexao->prepare($sql);
//     $stmt->bind_param("s", $data);
//     $stmt->execute();
//     $result = $stmt->get_result();

//     $horariosOcupados = [];
//     while ($row = $result->fetch_assoc()) {
//         $horariosOcupados[] = $row['time'];
//     }

//     echo json_encode($horariosOcupados);
// }



include_once "config.php";

$data = $_GET['data'] ?? '';

$ocupados = [];
if ($data) {
    $stmt = $conexao->prepare("
        SELECT time FROM finalidade WHERE data = ?
        UNION
        SELECT horario FROM dias_horarios_disponiveis WHERE data = ? AND ativo = 0
    ");
    $stmt->bind_param("ss", $data, $data);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $ocupados[] = substr($row['time'] ?? $row['horario'], 0, 5); // só pega HH:MM
    }
}

header('Content-Type: application/json');
echo json_encode($ocupados);



?>
