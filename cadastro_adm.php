<?php
if (isset($_POST['submit'])) {
    include_once "config.php";

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $telefone = $_POST['telefone'];

    // Verifica se o email já existe
    $sql = "SELECT * FROM cadastro WHERE email = ?";
    $stmt = $conexao->prepare($sql);

    if (!$stmt) {
        die("Erro no prepare(): " . $conexao->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>
            alert('⚠️ O e-mail $email já está cadastrado!');
            window.history.back(); // Volta ao formulário
        </script>";
        exit;
    } else {
        // Hash seguro da senha
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        // Cadastro com prepared statement
        $sql = "INSERT INTO cadastro (nome, email, senha, telefone) VALUES (?, ?, ?, ?)";
        $stmt = $conexao->prepare($sql);

        if (!$stmt) {
            die("Erro no prepare do INSERT: " . $conexao->error);
        }

        $stmt->bind_param("ssss", $nome, $email, $senha_hash, $telefone);

        if ($stmt->execute()) {
            echo "<script>
                alert('✅ Cadastro realizado com sucesso!');
                window.location.href = 'login.php'; // Altere para o caminho do seu formulário
            </script>";
        } else {
            echo "<script>
                alert('❌ Erro ao cadastrar: " . $stmt->error . "');
                window.history.back();
            </script>";
        }
    }

    $stmt->close();
    $conexao->close();
}
?>


<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cadastro_adm.css">
     <!-- <link rel="stylesheet" href="css/template.css"> -->
    <title>Cadastro</title>
  </head>
  <body>


  
    <div id="container-cadastro">
      
      <form action="cadastro_adm.php" method="POST" id="cad">
        <h1>Faça o seu cadastro</h1>        
        <input type="text" name="nome" id="cadnome"placeholder ="Nome Completo" />
        <input type="email" name="email" id="cadEmail" placeholder ="E-mail" />
        <input type="password" name="senha" id="cadsenha"  placeholder ="Password" />
        <input type="tel" id="cadtelefone" name="telefone" id="" placeholder="Telefone" />
        
        <input type="submit" value="salvar" name="submit" class="botao-hr">
        <input type="button" value="sair" class="botao-sair" onclick="window.location.href='sair_adm.php'">

       

    </form>
    </div>

    <script src="js/scripts.js"></script>
  </body>
</html>
