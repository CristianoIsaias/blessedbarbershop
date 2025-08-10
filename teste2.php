<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Desativar Horários</title>
</head>
<body>
  <h2>Selecione uma data:</h2>
  <input type="date" id="dateInput">
  <div id="timeslot" style="margin-top: 20px;"></div>

  <script>
    const horariosFixos = [
      "13:00", "14:00", "15:00", "16:00", "17:00",
      "18:00", "19:00", "20:00", "21:00", "22:00", "23:00", "00:00"
    ];

    let horariosDesativadosPorData = carregarHorariosDesativados();

    function salvarHorariosDesativados() {
      localStorage.setItem('horariosDesativadosPorData', JSON.stringify(horariosDesativadosPorData));
    }

    function carregarHorariosDesativados() {
      const dados = localStorage.getItem('horariosDesativadosPorData');
      return dados ? JSON.parse(dados) : {};
    }

    function renderizarHorarios(dataSelecionada) {
      const container = document.getElementById("timeslot");
      container.innerHTML = "";

      const desativados = horariosDesativadosPorData[dataSelecionada] || [];

      horariosFixos.forEach(horario => {
        const btn = document.createElement("button");
        btn.textContent = horario;

        if (desativados.includes(horario)) {
          btn.disabled = true;
        }

        btn.addEventListener("dblclick", () => {
          if (!horariosDesativadosPorData[dataSelecionada]) {
            horariosDesativadosPorData[dataSelecionada] = [];
          }

          const index = horariosDesativadosPorData[dataSelecionada].indexOf(horario);

          if (index === -1) {
            horariosDesativadosPorData[dataSelecionada].push(horario);
          } else {
            horariosDesativadosPorData[dataSelecionada].splice(index, 1);
          }

          salvarHorariosDesativados();
          renderizarHorarios(dataSelecionada);
        });

        container.appendChild(btn);
        container.appendChild(document.createTextNode(" "));
      });
    }

    document.getElementById("dateInput").addEventListener("change", () => {
      const data = document.getElementById("dateInput").value;
      renderizarHorarios(data);
    });
  </script>
</body>
</html>
