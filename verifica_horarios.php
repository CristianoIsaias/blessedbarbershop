<?php
include_once "config.php";

if (isset($_GET['data'])) {
    $data = $_GET['data'];

    $sql = "SELECT time FROM finalidade WHERE data = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $data);
    $stmt->execute();
    $result = $stmt->get_result();

    $ocupados = [];
    while ($row = $result->fetch_assoc()) {
        $ocupados[] = substr($row['time'], 0, 5); // HH:MM
    }

    echo json_encode(['ocupados' => $ocupados]);
}
?>
