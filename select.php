<?php
include_once('config.php');
session_start(); // Inicia a sessão para usar variáveis de sessão

// Exibe o nome do usuário logado
// if (isset($_SESSION['nome'])) {
//     echo "<header>Bem-vindo, <strong>" . htmlspecialchars($_SESSION['nome']) . "</strong>!</header><br><br>";
// }

// Consulta os dados da tabela finalidade com nome incluso
$sql = "SELECT
    finalidade.id,
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

// Verifica se existem registros
if ($result && $result->num_rows > 0) {
    // echo "<h2>Clientes Agendados</h2>";
    echo "<table border='1'>
            <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Telefone</th>
                <th>Penteado</th>
                <th>Data</th>
                <th>Hora</th>
                <th>Ação</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        $data_formatada = $row['data']; // valor original

        // Tenta criar um objeto DateTime com formato esperado
        $data = DateTime::createFromFormat('Y-m-d', $row['data']);
        if ($data !== false) {
            $data_formatada = $data->format('d/m/Y'); // se der certo, formata
        }

        echo "<tr>
            <td>{$row['nome']}</td>
            <td>{$row['email']}</td>
            <td>{$row['telefone']}</td>
            <td>{$row['penteado']}</td>
            <td>{$data_formatada}</td>
            <td>{$row['time']}</td>
            <td>
    <a href='delete_agendamento.php?id={$row['id']}' onclick=\"return confirm('Deseja realmente excluir este agendamento?')\" style='color:red;'>Excluir</a>
</td>
   <title>Lista de Serviços</title>
</head>

<body>        </tr>";
    }


    echo "</table>";
} else {
    echo "<p>Nenhum agendamento encontrado.</p>";
}
?>