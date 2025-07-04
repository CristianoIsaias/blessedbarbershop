<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamento</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .date.disabled, .timeslot button.disabled {
            background-color: #d3d3d3;
            pointer-events: none;
            color: #888;
        }
    </style>
</head>
<body>
    <?php
    include_once "config.php";

    $query = "SELECT `data`, `time` FROM finalidade";
    $result = mysqli_query($conexao, $query);

    $agendamentos = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $agendamentos[] = [
            'data' => $row['data'],
            'time' => $row['time']
        ];
    }
    ?>

    <script>
        const agendamentos = <?php echo json_encode($agendamentos); ?>;
    </script>

    <form action="horario.php" method="POST">
        <input type="hidden" name="data" id="inputData">
        <input type="hidden" name="time" id="selectedTimeInput">

        <div class="calendar">
            <div class="header">
                <button type="button" id="prev">&lt;</button>
                <div id="monthYear"></div>
                <button type="button" id="next">&gt;</button>
            </div>
            <div class="weekdays">
                <div>Dom</div><div>Seg</div><div>Ter</div><div>Qua</div><div>Qui</div><div>Sex</div><div>Sab</div>
            </div>
            <div class="dates" id="dates"></div>
        </div>

        <div class="timeslot" id="timeslot"></div>

        <select name="penteado" required>
            <option value="">Selecione o tipo de penteado</option>
            <option value="Trança">Trança</option>
            <option value="Escova">Escova</option>
            <option value="Corte">Corte</option>
        </select>

        <button type="submit" name="submit">Salvar</button>
    </form>

    <script>
        const monthYearElement = document.getElementById("monthYear");
        const datesElement = document.getElementById("dates");
        const timeslotDiv = document.getElementById('timeslot');

        const horarios = ["09:00", "10:00", "11:00", "13:00", "14:00", "15:00"];

        let currentDate = new Date();
        let dataSelecionada = null;
        let horarioSelecionado = null;

        document.getElementById("prev").addEventListener("click", () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            updateCalendar();
        });

        document.getElementById("next").addEventListener("click", () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            updateCalendar();
        });

        const updateCalendar = () => {
            const currentYear = currentDate.getFullYear();
            const currentMonth = currentDate.getMonth();

            const firstDay = new Date(currentYear, currentMonth, 1);
            const lastDay = new Date(currentYear, currentMonth + 1, 0);
            const totalDays = lastDay.getDate();
            const firstDayIndex = firstDay.getDay();
            const lastDayIndex = lastDay.getDay();

            const monthYearString = currentDate.toLocaleString('default', {
                month: 'long',
                year: 'numeric'
            });
            monthYearElement.textContent = monthYearString;

            let datesHTML = '';

            const prevMonthDays = firstDayIndex;
            const prevMonth = new Date(currentYear, currentMonth, 0);
            const prevMonthTotalDays = prevMonth.getDate();

            for (let i = prevMonthTotalDays - prevMonthDays + 1; i <= prevMonthTotalDays; i++) {
                datesHTML += `<div class="date inactive">${i}</div>`;
            }

            for (let i = 1; i <= totalDays; i++) {
                const date = new Date(currentYear, currentMonth, i);
                const dia = String(i).padStart(2, '0');
                const mes = String(currentMonth + 1).padStart(2, '0');
                const ano = currentYear;
                const dataFormatada = `${ano}-${mes}-${dia}`;

                const isOcupada = agendamentos.some(ag => ag.data === dataFormatada);

                const activeClass = date.toDateString() === new Date().toDateString() ? 'active' : '';
                const disabledClass = isOcupada ? 'disabled' : '';

                datesHTML += `<div class="date ${activeClass} ${disabledClass}" data-date="${dataFormatada}">${i}</div>`;
            }

            const nextDays = 6 - lastDayIndex;
            for (let i = 1; i <= nextDays; i++) {
                datesHTML += `<div class="date inactive">${i}</div>`;
            }

            datesElement.innerHTML = datesHTML;
        };

        datesElement.addEventListener('click', (event) => {
            const target = event.target;
            if (target.classList.contains('date') && !target.classList.contains('inactive') && !target.classList.contains('disabled')) {
                document.querySelectorAll('.date').forEach(el => el.classList.remove('selected'));
                target.classList.add('selected');
                dataSelecionada = target.getAttribute('data-date');
                document.getElementById('inputData').value = dataSelecionada;
                renderHorarios();
            }
        });

        function renderHorarios() {
            timeslotDiv.innerHTML = '';
            horarios.forEach(horario => {
                const button = document.createElement('button');
                button.textContent = horario;
                button.type = "button";

                const isOcupado = agendamentos.some(ag => ag.data === dataSelecionada && ag.time === horario);

                if (isOcupado) {
                    button.classList.add('disabled');
                    button.disabled = true;
                } else {
                    button.addEventListener('click', () => {
                        document.querySelectorAll('.timeslot button').forEach(btn => btn.classList.remove('selected'));
                        button.classList.add('selected');
                        horarioSelecionado = horario;
                        document.getElementById('selectedTimeInput').value = horarioSelecionado;
                    });
                }
                timeslotDiv.appendChild(button);
            });
        }

        updateCalendar();
    </script>
</body>
</html>
