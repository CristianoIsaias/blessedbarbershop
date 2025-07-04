<?php

session_start();

// print_r($_SESSION);
if((!isset($_SESSION['email']) == true) AND (!isset($_SESSION['senha']) == true)AND (!isset($_SESSION['nome']) == true)) {
 
  unset($_SESSION['email']);
  unset($_SESSION['senha']);
  
  
  header('Location: login.php');
 
  
}else{
  
  
  echo "Bem vindo, <strong>" . $_SESSION['nome'] . "</strong>!<br>";
}
 

if (isset($_POST['submit'])) {
  include_once "config.php";  



$result = $conexao->query("SELECT data FROM finalidade");
$datas = [];

while ($row = $result->fetch_assoc()) {
    $datas[] = $row['data'];
}

header('Content-Type: application/json');
echo json_encode($datas);


}

        
   ?>
   



<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="css/template.css">

    <title>Agendamento</title>
  </head>
  <body>
    

      
      
  <h1>Selecione uma data para o corte!</h1>
  <input type="button" value="sair" onclick="window.location.href='sair.php'" class="saircalendario">
    <div class="fullCalendar">
      
      <div class="calendar">
        <div class="header">
            <button type="submit" id="prevBtn">
              <i class="fa-solid fa-chevron-left"></i>
            </button>
            <div class="monthYear" id="monthYear"></div>
            <button id="nextBtn">
              <i class="fa-solid fa-chevron-right"></i>
            </button>
        </div>
        <div class="days">
            <div class="day">Seg</div>
            <div class="day">Ter</div>
            <div class="day">Qua</div>
            <div class="day">Qui</div>
            <div class="day">Sex</div>
            <div class="day">Sáb</div>
            <div class="day">Dom</div>
        </div>
        <div class="dates" id="dates"></div>
  </div>  
    </div>
</div>

<script>

  const monthYearElement = document.getElementById('monthYear');
const datesElement = document.getElementById('dates');
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');

let currentDate = new Date();

const updateCalendar = () => {
    const currentYear = currentDate.getFullYear();
    const currentMonth = currentDate.getMonth();

    const firstDay = new Date(currentYear, currentMonth, 1); // primeiro dia do mês atual
    const lastDay = new Date(currentYear, currentMonth + 1, 0); // último dia do mês atual
    const totalDays = lastDay.getDate();

    const firstDayIndex = firstDay.getDay(); // dia da semana do 1º dia
    const lastDayIndex = lastDay.getDay();   // dia da semana do último dia

    const monthYearString = currentDate.toLocaleString('default', {
        month: 'long',
        year: 'numeric'
    });
    monthYearElement.textContent = monthYearString;

    let datesHTML = '';

    // Dias do mês anterior
    for (let i = firstDayIndex; i > 0; i--) {
        const prevDate = new Date(currentYear, currentMonth, -i + 1);
        datesHTML += `<div class="date inactive">${prevDate.getDate()}</div>`;
    }

    // Dias do mês atual
    for (let i = 1; i <= totalDays; i++) {
        const date = new Date(currentYear, currentMonth, i);
        const activeClass = date.toDateString() === new Date().toDateString() ? 'active' : '';
        datesHTML += `<div class="date ${activeClass}" data-day="${i}">${i}</div>`;
    }

    // Dias do próximo mês para completar a grade (até sábado)
    for (let i = 1; i <= 6 - lastDayIndex; i++) {
        const nextDate = new Date(currentYear, currentMonth + 1, i);
        datesHTML += `<div class="date inactive">${nextDate.getDate()}</div>`;
    }

    datesElement.innerHTML = datesHTML;

    // Adiciona eventos de clique
    const dateElements = document.querySelectorAll('.date');
    let clickTimeout;

    dateElements.forEach(el => {
        el.addEventListener('click', () => {
            if (el.classList.contains('inactive')) return;

            if (clickTimeout) clearTimeout(clickTimeout);
            clickTimeout = setTimeout(() => {
                el.classList.toggle('selected');
                clickTimeout = null;
            }, 250);
        });

        el.addEventListener('dblclick', () => {
            if (el.classList.contains('inactive')) return;

            if (clickTimeout) clearTimeout(clickTimeout);
            clickTimeout = null;

            const day = parseInt(el.getAttribute('data-day'));
            const selectedDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), day);
            const formattedDate = selectedDate.toISOString().split('T')[0];

            // Redireciona para a página de horário
            window.location.href = `horario.php?data=${formattedDate}`;
        });
    });
};

// Botões de navegação
prevBtn.addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    updateCalendar();
});

nextBtn.addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    updateCalendar();
});

// Inicializa o calendário ao carregar
updateCalendar();

</script>


<script src="js/scripts.js"></script>
  </body>
  

</html>
