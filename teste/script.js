let horariosDesativados = [];
let dataSelecionada = '';

document.getElementById("dataInput").addEventListener("change", function () {
    const data = this.value;
    if (data) {
        carregarHorarios(data);
    }
});

function carregarHorarios(data) {
    dataSelecionada = data;

    fetch(`carregar_horarios.php?data=${data}`)
        .then(res => res.json())
        .then(resposta => {
            const { ocupados, desativados } = resposta;
            horariosDesativados = desativados;
            renderizarHorarios(ocupados);
        });
}

function renderizarHorarios(horariosOcupados = []) {
    const timeslotDiv = document.querySelector('.timeslot');
    timeslotDiv.innerHTML = "";

    const horarios = ["13:00", "14:00", "15:00", "16:00", "17:00", "18:00", "19:00", "20:00", "21:00", "22:00", "23:00", "00:00"];

    horarios.forEach(horario => {
        const button = document.createElement('button');
        button.textContent = horario;
        button.type = "button";

        if (horariosOcupados.includes(horario)) {
            button.disabled = true;
            button.classList.add("ocupado");
        }

        if (horariosDesativados.includes(horario)) {
            button.disabled = true;
            button.classList.add("desativado");
        }

        button.addEventListener('click', () => {
            if (!button.disabled) {
                document.querySelectorAll('.timeslot button').forEach(btn => btn.classList.remove('selected'));
                button.classList.add('selected');
                document.getElementById('selectedTimeInput').value = horario;
                console.log("Selecionado:", horario);
            }
        });

        button.addEventListener('contextmenu', (event) => {
            event.preventDefault();

            if (!horariosOcupados.includes(horario)) {
                const index = horariosDesativados.indexOf(horario);
                const acao = index === -1 ? 'desativar' : 'ativar';

                if (index === -1) {
                    horariosDesativados.push(horario);
                } else {
                    horariosDesativados.splice(index, 1);
                }

                fetch('atualizar_horario.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `data=${dataSelecionada}&horario=${horario}&acao=${acao}`
                });

                renderizarHorarios(horariosOcupados);
            }
        });

        timeslotDiv.appendChild(button);
    });
}
