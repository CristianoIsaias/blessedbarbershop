<?php

// print_r($_REQUEST)
  if(isset($_POST['submit']) && !empty($_POST['telefone']) &&
   !empty($_POST['nome']))

  {
//acessar

 include_once('config.php');

 $telefone = $_POST['telefone'];
 $nome = $_POST['nome'];

//  print_r('Telefone: ' . $telefone);

 $sql = "SELECT * FROM cadastro WHERE telefone = '$telefone' AND
  nome = '$nome'";

 $result = $conexao->query($sql);

//  print_r($result); 
//   print_r($sql);   
 if(mysqli_num_rows($result) < 1)
{
    header('Location: index.php');
}else
  {

    header('Location: agendamento.php');
  }
}
else{ 
    
    
    //Não acessa
     header('Location: index.php');

   }
?>

