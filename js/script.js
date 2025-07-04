const monthYearElement = document.getElementById('monthYear');
const datesElement = document.getElementById('dates');
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');

let currentDate = new Date();

const updateCalendar = () => {
    const currentYear = currentDate.getFullYear();
    const currentMonth = currentDate.getMonth();

    // Primeiro e último dia do mês atual
    const firstDay = new Date(currentYear, currentMonth, 1);
    const lastDay = new Date(currentYear, currentMonth + 1, 0);

    const totalDays = lastDay.getDate();
    const firstDayIndex = firstDay.getDay(); // Domingo = 0, Segunda = 1, etc.
    const lastDayIndex = lastDay.getDay();

    const monthYearString = currentDate.toLocaleString('default', {
        month: 'long',
        year: 'numeric'
    });
    monthYearElement.textContent = monthYearString;

    let datesHTML = '';

    // Dias do mês anterior
    const prevMonthLastDay = new Date(currentYear, currentMonth, 0).getDate();
    for (let i = firstDayIndex; i > 0; i--) {
        datesHTML += `<div class="date inactive">${prevMonthLastDay - i + 1}</div>`;
    }

    // Dias do mês atual
    for (let i = 1; i <= totalDays; i++) {
        const date = new Date(currentYear, currentMonth, i);
        const isToday = date.toDateString() === new Date().toDateString();
        const activeClass = isToday ? 'active' : '';
        datesHTML += `<div class="date ${activeClass}" data-day="${i}">${i}</div>`;
    }

    // Dias do próximo mês (preenchimento até completar 6 semanas)
    const totalBoxes = firstDayIndex + totalDays;
    const nextDays = 42 - totalBoxes;
    for (let i = 1; i <= nextDays; i++) {
        datesHTML += `<div class="date inactive">${i}</div>`;
    }

    datesElement.innerHTML = datesHTML;
};

// Navegação entre meses
prevBtn.addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    updateCalendar();
});

nextBtn.addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    updateCalendar();
});

// Inicializa o calendário
updateCalendar();
