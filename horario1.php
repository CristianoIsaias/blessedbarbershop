<?php
// painel_admin.php - Painel visível apenas para administradores

session_start();

// Verifica se o usuário está logado e se é administrador
if (!isset($_SESSION['email']) || $_SESSION['perfil'] !== 'admin') {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Bem-vindo ao Painel Administrativo</h1>
        <p>Olá, <?php echo htmlspecialchars($_SESSION['nome']); ?>!</p>

        <ul>
            <li><a href="usuarios.php">Gerenciar Usuários</a></li>
            <li><a href="lista.php">Ver Agendamentos</a></li>
            <li><a href="sair.php">Sair</a></li>
        </ul>
    </div>
</body>
</html>