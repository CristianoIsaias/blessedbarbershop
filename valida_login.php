<?php
session_start();

if (
    isset($_POST['submit']) &&
    !empty($_POST['email']) &&
    !empty($_POST['senha'])
) {
    include_once('config.php');

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $stmt = $conexao->prepare("SELECT * FROM cadastro WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();

        if (password_verify($senha, $usuario['senha'])) {
            $_SESSION['email'] = $usuario['email'];
            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['telefone'] = $usuario['telefone'];
            $_SESSION['codigo_id'] = $usuario['codigo_id'];

            header('Location: horario.php');
            exit();
        } else {
            $_SESSION['erro_login'] = "❌ Senha incorreta!";
            header('Location: login.php');
            exit();
        }
    } else {
        $_SESSION['erro_login'] = "❌ E-mail não encontrado!";
        header('Location: login.php');
        exit();
    }
} else {
    $_SESSION['erro_login'] = "⚠️ Preencha todos os campos.";
    header('Location: login.php');
    exit();
}
?>
