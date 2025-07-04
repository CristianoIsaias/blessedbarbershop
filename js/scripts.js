
const monthYearElement = document.getElementById('monthYear');
const datesElement = document.getElementById('dates');
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');

let currentDate = new Date();
// let selectedDates = []; // Para armazenar se quiser

const updateCalendar = () => {
    const currentYear = currentDate.getFullYear();
    const currentMonth = currentDate.getMonth();

    const firstDay = new Date(currentYear, currentMonth, 0);
    const lastDay = new Date(currentYear, currentMonth + 1, 0);
    const totalDays = lastDay.getDate();
    const firstDayIndex = firstDay.getDay();
    const lastDayIndex = lastDay.getDay();

    const monthYearString = currentDate.toLocaleString('default', { month: 'long', year: 'numeric' });
    monthYearElement.textContent = monthYearString;

    let datesHTML = '';

    // Dias do mês anterior
    for (let i = firstDayIndex; i > 0; i--) {
        const prevDate = new Date(currentYear, currentMonth, 0 - i + 1);
        datesHTML += `<div class="date inactive">${prevDate.getDate()}</div>`;
    }

    // Dias do mês atual
    for (let i = 1; i <= totalDays; i++) {
        const date = new Date(currentYear, currentMonth, i);
        const activeClass = date.toDateString() === new Date().toDateString() ? 'active' : '';
        datesHTML += `<div class="date ${activeClass}">${i}</div>`;
    }

    // Dias do próximo mês
    for (let i = 1; i <= 6 - lastDayIndex; i++) {
        const nextDate = new Date(currentYear, currentMonth + 1, i);
        datesHTML += `<div class="date inactive">${nextDate.getDate()}</div>`;
    }

    datesElement.innerHTML = datesHTML;

    // Navegação entre meses
prevBtn.addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    updateCalendar();
});

nextBtn.addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    
});

updateCalendar();

    // Adiciona clique e duplo clique
    // const dateElements = document.querySelectorAll('.date');
    // let clickTimeout;

    // dateElements.forEach(el => {
    //     el.addEventListener('click', (event) => {
    //         if (el.classList.contains('inactive')) return;

    //         // Cancela o clique se for duplo clique
    //         if (clickTimeout) clearTimeout(clickTimeout);

    //         clickTimeout = setTimeout(() => {
    //             // Clique simples: marcar ou desmarcar visualmente
    //             el.classList.toggle('selected');
    //             clickTimeout = null;
    //         }, 250);
    //     });

    //     el.addEventListener('dblclick', () => {
    // if (el.classList.contains('inactive')) return;

    // if (clickTimeout) clearTimeout(clickTimeout);
    // clickTimeout = null;

    const day = parseInt(el.getAttribute('data-day'));
    const selectedDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), day);
    const formattedDate = selectedDate.toISOString().split('T')[0];

    // Salva no banco de dados
    fetch('salvar_data.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `data=${formattedDate}`
    })
    .then(res => res.text())
    .then(() => {
        
        // Marca a data como confirmada (verde)
        el.classList.remove('selected');
        // el.classList.add('confirmed');
        

        // Redireciona para a tela de horários
        window.location.href = `horario.php?data=${formattedDate}`;
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


const submitBtn = document.getElementById('botao-hr');

submitBtn.addEventListener('click', (event) => {
    // Verifica se há pelo menos uma data com a classe "selected"
    const selected = document.querySelector('.date.selected');
    // Inicializa o calendário
    updateCalendar();

    if (!selected) {
        // Impede o envio e mostra alerta
        event.preventDefault();
        alert("Por favor, selecione uma data antes de continuar.");
        return;
    }

    // Se tiver data selecionada, prossiga (aqui você pode redirecionar, enviar form, etc)
    const day = parseInt(selected.getAttribute('data-day'));
    const selectedDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), day);
    const formattedDate = selectedDate.toISOString().split('T')[0];

    // Exemplo de redirecionamento
    window.location.href = `horario.php?data=${formattedDate}`;

    // Inicializa o calendário
    updateCalendar();
});




