<?php
include_once('config.php');
session_start();

// Consulta com ID para poder excluir depois
$sql = "SELECT
    finalidade.codigo,
    cadastro.nome,
    cadastro.email,
    cadastro.telefone,
    finalidade.penteado,
    finalidade.time,
    finalidade.data
FROM
    cadastro
INNER JOIN
    finalidade ON cadastro.codigo_id = finalidade.usuario_id
ORDER BY
    finalidade.data,
    finalidade.time";

$result = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Lista de Serviços</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/stylelista.css">
</head>

<body>

    <div class="espelho-escuro">


    <a href="paineldecontrole.php">voltar</a>
           
    

   <div class="box-sizing">   

    <h2>Clientes Agendados</h2>

   </div>
   </div>

    <div class="container-fundo">
        <div class="container-caixa">

            <?php if ($result && $result->num_rows > 0): ?>
                <table border="1" width="100%" style="text-align:center;">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Telefone</th>
                            <th>Penteado</th>
                            <th>Data</th>
                            <th>Hora</th>
                            <th>Ação</th>
                            <th>Atualizar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()):
                            $data_formatada = $row['data'];
                            $data = DateTime::createFromFormat('Y-m-d', $row['data']);
                            if ($data !== false) {
                                $data_formatada = $data->format('d/m/Y');
                            }
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($row['nome']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td><?= htmlspecialchars($row['telefone']) ?></td>
                                <td><?= htmlspecialchars($row['penteado']) ?></td>
                                <td><?= $data_formatada ?></td>
                                <td><?= htmlspecialchars($row['time']) ?></td>
                                <td>
                                    <a href="delete_agendamento.php?codigo=<?= $row['codigo'] ?>"
                                        onclick="return confirm('Deseja realmente excluir este agendamento?')"
                                        style="color:red;">Excluir</a>
                                </td>
                                <td>
                                    <a href="editar_agendamento.php?codigo=<?= $row['codigo'] ?>" style="color:blue;">Editar</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p style="text-align:center;">Nenhum agendamento encontrado.</p>
            <?php endif; ?>
               
        </div>
    </div>
</div>
 <div class="botao-lista">
            
            </div>
</body>

</html>