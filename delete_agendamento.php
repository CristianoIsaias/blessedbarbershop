<?php
include_once('config.php');

if (isset($_GET['codigo'])) {
    $id = $_GET['codigo'];

    $sql = "DELETE FROM finalidade WHERE codigo = ?";
    $stmt = $conexao->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo "<script>alert('✅ Agendamento excluído com sucesso!'); window.location.href='lista.php';</script>";
        } else {
            echo "<script>alert('❌ Erro ao excluir: " . $stmt->error . "'); window.history.back();</script>";
        }
        $stmt->close();
    } else {
        echo "Erro ao preparar o DELETE: " . $conexao->error;
    }
    $conexao->close();
} else {
    echo "<script>alert('❌ ID não informado.'); window.history.back();</script>";
}
