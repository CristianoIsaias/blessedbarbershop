<?php
include_once "config.php";

if (isset($_GET['data'])) {
    $data = $_GET['data'];

    $sql = "SELECT time FROM finalidade WHERE data = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $data);
    $stmt->execute();
    $result = $stmt->get_result();

    $horariosOcupados = [];
    while ($row = $result->fetch_assoc()) {
        $horariosOcupados[] = $row['time'];
    }

    echo json_encode($horariosOcupados);
}
?>
