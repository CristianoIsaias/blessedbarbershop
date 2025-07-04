<?php
include_once "config.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM cadastro WHERE id = ?";
    $stmt = $conexao->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo "<script>alert('✅ Cadastro excluído com sucesso!'); window.location.href='listar.php';</script>";
        } else {
            echo "<script>alert('❌ Erro ao excluir: " . $stmt->error . "'); window.history.back();</script>";
        }
        $stmt->close();
    } else {
        echo "Erro ao preparar statement: " . $conexao->error;
    }

    $conexao->close();
} else {
    echo "<script>alert('❌ ID não informado!'); window.history.back();</script>";
}
