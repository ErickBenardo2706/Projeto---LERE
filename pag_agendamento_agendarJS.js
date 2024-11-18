document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    var selectedDate = null; // Variável para armazenar a data selecionada
    var modal = document.getElementById('modal'); // Seleciona o modal
    var btnCancelar = document.getElementById('btn_cancelar'); // Seleciona o botão de cancelar
    var btnConfirmar = document.getElementById('btn_confirmar'); // Seleciona o botão de confirmar
    var modalContent = modal.querySelector('p'); // Seleciona o conteúdo do modal
    var selectedHorario = null; // Variável para armazenar o horário selecionado

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'pt-br',
        selectable: true,
        dateClick: function (info) {
            var clickedDate = new Date(info.date);
            var dayOfWeek = clickedDate.getDay();

            // Verifica se é domingo (0 = Domingo)
            if (dayOfWeek === 0) {
                alert("Não é possível selecionar domingos.");
                return;
            }

            // Remove o destaque do dia previamente selecionado
            if (selectedDate) {
                selectedDate.classList.remove('dia-selecionado');
            }

            // Adiciona o destaque no dia atual
            info.dayEl.classList.add('dia-selecionado');
            selectedDate = info.dayEl;

            // Armazena a data selecionada
            selectedDate = info.dateStr;

            // Exibe a tabela de horários com base no dia da semana
            exibirHorariosDisponiveis(dayOfWeek);
        }
    });

    calendar.render();

    // Função para exibir a tabela de horários com base no dia da semana
    function exibirHorariosDisponiveis(dayOfWeek) {
        var horariosContainer = document.getElementById('horarios-disponiveis');
        horariosContainer.innerHTML = ''; // Limpa os horários anteriores

        // Defina horários para dias da semana (segunda a sexta) e sábados
        var horariosSemana = ['08:00', '09:00', '10:00', '11:00', '13:15', '14:15', '15:15', '16:15', '17:15', '18:15'];
        var horariosSabado = ['08:00', '09:00', '10:00', '11:00'];

        var horarios = (dayOfWeek >= 1 && dayOfWeek <= 5) ? horariosSemana : horariosSabado;

        // Cria os botões de horários
        horarios.forEach(function (horario) {
            var btnHorario = document.createElement('button');
            btnHorario.textContent = horario;
            btnHorario.classList.add('horario-btn');
            btnHorario.addEventListener('click', function () {
                selectedHorario = horario; // Armazena o horário selecionado
                atualizarModal(); // Atualiza o conteúdo do modal
                modal.showModal(); // Mostra o modal ao clicar no botão de horário
            });
            horariosContainer.appendChild(btnHorario);
        });
    }

    // Função para atualizar o conteúdo do modal
    function atualizarModal() {
        if (selectedDate && selectedHorario) {
            // Converte a data UTC para o horário local
            var dataLocal = new Date(selectedDate);
            dataLocal.setDate(dataLocal.getDate() + 1); // Ajuste para o problema do dia anterior

            var dataFormatada = dataLocal.toLocaleDateString('pt-BR', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });

            modalContent.innerHTML = `Será marcado para <b>${dataFormatada}</b>, <br> às <b>${selectedHorario}</b>.`;
        }
    }


    // Função para fechar o modal ao clicar no botão de cancelar
    btnCancelar.addEventListener('click', function () {
        modal.close(); // Fecha o modal
        location.reload();
    });

    // Aqui você pode adicionar o comportamento para o botão confirmar
    btnConfirmar.addEventListener('click', function () {
        alert("Agendamento confirmado!");
        modal.close(); // Fecha o modal
    });
});
