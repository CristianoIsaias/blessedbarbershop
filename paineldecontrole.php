<?php
session_start();

// Verificação de permissão
if (!isset($_SESSION['codigo_id']) || $_SESSION['tipo_usuario'] !== 'admin') {
    
    echo "❌ Acesso negado. Esta página é apenas para administradores.<br>";

    // Mostrar dados da sessão para depuração
    echo '<pre>';
    print_r($_SESSION);
    echo '</pre>';

    exit;
}
?>




<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/stylepainel.css">
    <title>Painel de Controle</title>
</head>
<body>
    <div class="entrar">
    <a href="saircontrole.php">sair</a></div>
    <div class="titulo">
        
    <h1>Painel de Controle - Blessed Barber Shop</h1>
    

     <div class="alinharmenu">
        <nav>
            <ul class="menu">
                <li><a href="cadastro_adm.php">Criar conta de usuário</a></li>
                <li><a href="recuperarsenha_adm.php">Alterar informações de usuários</a></li>                
                <li><a href="lista.php">Lista de Clientes</a></li>
                <li><a href="horario_control.php">Controle de Horários</a></li>
            </ul>
        </nav>
    </div> 
    </div>
    </div>
</body>
</html>