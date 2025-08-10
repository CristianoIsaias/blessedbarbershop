<?php

session_start();

// Simulação de dados de login
$usuarios = [
    'admin@teste.com' => ['senha' => '123', 'tipo' => 'admin'],
    'cliente@teste.com' => ['senha' => '456', 'tipo' => 'cliente']
];

$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

if (isset($usuarios[$email]) && $usuarios[$email]['senha'] === $senha) {
    $_SESSION['usuario_logado'] = $email;
    $_SESSION['tipo_usuario'] = $usuarios[$email]['tipo_usuario'];

    header("Location: agendamento.php");
    exit;
} else {
    $_SESSION['erro_login'] = "Email ou senha inválidos.";
    header("Location: login.php");
    exit;
}
?>