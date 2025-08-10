<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/stylehour.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Savate:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
    <title>Horário</title>
    <style>
        .date.selected {
            background-color: #3e8ed0; 
            color: white;
            border-radius: 50%;
        }
        .timeslot button.selected {
            background-color: #3e8ed0;
            color: white;
        }
        .hidden {
            display: none !important;
        }
    </style>
</head>

<body>
<?php
session_start();
if (isset($_POST['submit'])) {
    include_once "config.php";
    $time = $_POST['time'];
    $penteado = $_POST['penteado'];
    $data = $_POST['data'];
    $usuario = $_SESSION['nome'] ?? 'Usuário';
    $usuario_id = $_SESSION['codigo_id'] ?? 0;
    $data_formatada_banco = date('Y-m-d', strtotime($data));
    $data_formatada_brasil = date('d/m/Y', strtotime($data));
    $verifica = "SELECT * FROM finalidade WHERE time = ? AND data = ?";
    $stmt = $conexao->prepare($verifica);
    $stmt->bind_param("ss", $time, $data_formatada_banco);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo "<script>alert('\u26a0\ufe0f Neste horário já tem cliente agendado. Por favor, escolha outro horário.');window.history.back();</script>";
        exit;
    }
    $query = "INSERT INTO finalidade (time, penteado, `data`, usuario_id) VALUES (?, ?, ?, ?)";
    $stmt_insert = $conexao->prepare($query);
    $stmt_insert->bind_param("sssi", $time, $penteado, $data_formatada_banco, $usuario_id);
    $stmt_insert->execute();
    echo "<h2 style='color:white;margin-top:0;border-radius:96px;font-family: Cinzel Decorative, serif;width:900px;display:grid;align-items:center;margin:auto;height:200px;background-color:#000000a3;'>$usuario o agendamento foi realizado com sucesso!<br><br>Segue a data e o horário $data_formatada_brasil às $time";
    echo "<script>setTimeout(function() { window.location.href = 'index.php'; }, 6000);</script>";
    exit;
}
?>

<div id="calendarSection">
    <div class="calendar">
        <div class="header">
            <button type="button" id="prevBtn"><i class="fa-solid fa-chevron-left"></i></button>
            <div class="monthYear" id="monthYear"></div>
            <button type="button" id="nextBtn"><i class="fa-solid fa-chevron-right"></i></button>
        </div>
        <div class="days">
            <div class="day">Seg</div><div class="day">Ter</div><div class="day">Qua</div>
            <div class="day">Qui</div><div class="day">Sex</div>
            <div class="day" style="color:red">Sáb</div><div class="day" style="color:red">Dom</div>
        </div>
        <div class="dates" id="dates"></div>

        

    </div>
</div>

<div id="timeSection" class="hidden">
    <div class="container">
        <h4>Selecione um horário</h4>
        <div class="timeslot" id="timeslot"></div>
    </div>
</div>

<div id="penteadoSection" class="hidden">
    <div class="container-caixaestilo">
        <div id="servicos">
            <form action="" method="POST" style="margin: 30px 0;">
                <input type="hidden" name="time" id="selectedTimeInput">
                <input type="hidden" name="data" id="selectedDateInput">
                <select name="penteado" required id="selectPages">
                    <option value=""></option>
                    <option value="Corte de Cabelo" selected>Corte de Cabelo</option>
                    <option value="Barba Completa">Barba Completa</option>
                    <option value="Combo Corte + Barba">Combo Corte + Barba</option>
                    <option value="Design de Sobrancelha">Quimica em Geral</options                                      
                </select>
                <br><br>
                <input type="submit" value="Salvar" name="submit" class="botao-hr">
                <input type="button" value="Sair" onclick="window.location.href='sair.php'" class="sair">
            </form>
        </div>
    </div>
</div>

<script>
const monthYearElement = document.getElementById('monthYear');
const datesElement = document.getElementById('dates');
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');
const timeslotDiv = document.getElementById('timeslot');
const selectPages = document.getElementById('selectPages');
let currentDate = new Date();

const updateCalendar = () => {
    const currentYear = currentDate.getFullYear();
    const currentMonth = currentDate.getMonth();
    const firstDay = new Date(currentYear, currentMonth, 1);
    const lastDay = new Date(currentYear, currentMonth + 1, 0);
    const totalDays = lastDay.getDate();
    const firstDayIndex = firstDay.getDay();
    const lastDayIndex = lastDay.getDay();
    const monthYearString = currentDate.toLocaleString('default', { month: 'long', year: 'numeric' });
    monthYearElement.textContent = monthYearString;

    let datesHTML = '';
    const prevMonthDays = firstDayIndex;
    const prevMonth = new Date(currentYear, currentMonth, 0);
    const prevMonthTotalDays = prevMonth.getDate();
    for (let i = prevMonthTotalDays - prevMonthDays + 1; i <= prevMonthTotalDays; i++) {
        datesHTML += `<div class="date inactive">${i}</div>`;
    }
    for (let i = 1; i <= totalDays; i++) {
        const dia = String(i).padStart(2, '0');
        const mes = String(currentMonth + 1).padStart(2, '0');
        const ano = currentYear;
        const dataFormatada = `${ano}-${mes}-${dia}`;
        const dataAtual = new Date();
        const dataDoCalendario = new Date(`${ano}-${mes}-${dia}`);
        const isValid = dataDoCalendario >= new Date(dataAtual.getFullYear(), dataAtual.getMonth(), dataAtual.getDate());
        datesHTML += `<div class="date ${isValid ? '' : 'inactive'}" data-date="${dataFormatada}">${i}</div>`;
    }
    const nextDays = 6 - lastDayIndex;
    for (let i = 1; i <= nextDays; i++) {
        datesHTML += `<div class="date inactive">${i}</div>`;
    }
    datesElement.innerHTML = datesHTML;
};

prevBtn.addEventListener('click', () => { currentDate.setMonth(currentDate.getMonth() - 1); updateCalendar(); });
nextBtn.addEventListener('click', () => { currentDate.setMonth(currentDate.getMonth() + 1); updateCalendar(); });
updateCalendar();

function mostrarEtapa(etapa) {
    document.getElementById('calendarSection').classList.toggle('hidden', etapa !== 0);
    document.getElementById('timeSection').classList.toggle('hidden', etapa !== 1);
    document.getElementById('penteadoSection').classList.toggle('hidden', etapa !== 2);
}
    // horário definido pelo js
const horariosDesativados = []; // Armazena horários desativados manualmente

function renderizarHorarios(horariosOcupados = []) {
    

    timeslotDiv.innerHTML = "";

    const horarios = [ "13:00", "14:00", "15:00", "16:00", "17:00", "18:00", "19:00", "20:00", "21:00", "22:00", "23:00", "00:00" ];

    horarios.forEach(horario => {
        const button = document.createElement('button');
        button.textContent = horario;
        button.type = "button";

        // Ocupado pelo banco de dados
        if (horariosOcupados.includes(horario)) {
            button.disabled = true;
            button.classList.add("ocupado");
        }

        // Desativado manualmente
        if (horariosDesativados.includes(horario)) {
            button.disabled = true;
            button.classList.add("desativado");
        }

        // Clique esquerdo → selecionar horário
        button.addEventListener('click', () => {
            if (!button.disabled) {
                document.querySelectorAll('.timeslot button').forEach(btn => btn.classList.remove('selected'));
                button.classList.add('selected');
                document.getElementById('selectedTimeInput').value = horario;
                mostrarEtapa(2);
            }
        });

        // Clique direito → ativar/desativar
        button.addEventListener('contextmenu', (event) => {
            event.preventDefault();

            if (!horariosOcupados.includes(horario)) {
                const index = horariosDesativados.indexOf(horario);

                if (index === -1) {
                    horariosDesativados.push(horario);
                } else {
                    horariosDesativados.splice(index, 1);
                }

                // Re-renderiza para aplicar mudança visual
                renderizarHorarios(horariosOcupados);
            }
        });

        timeslotDiv.appendChild(button);
    });
    
}

// ---------------------------------------------------------------------------------
datesElement.addEventListener('click', (event) => {
    const target = event.target;
    if (target.classList.contains('date') && !target.classList.contains('inactive')) {
        document.querySelectorAll('.date').forEach(d => d.classList.remove('selected'));
        target.classList.add('selected');
        const selectedDate = target.dataset.date;
        document.getElementById('selectedDateInput').value = selectedDate;
        fetch(`horarios_ocupados.php?data=${selectedDate}`)
            .then(response => response.json())
            .then(horariosOcupados => {
                renderizarHorarios(horariosOcupados);
                mostrarEtapa(1);
            })
            .catch(error => {
                console.error("Erro ao buscar horários ocupados:", error);
                renderizarHorarios();
                mostrarEtapa(1);
            });
    }
});
</script>
</body>
</html>
