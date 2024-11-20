document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    var selectedDate = null; // Variável para armazenar a data selecionada
    var selectedHorario = null; // Variável para armazenar o horário selecionado
    var modal = document.getElementById('modalAgendamento'); // Seleciona o modal
    var btnCancelar = document.getElementById('btn_cancelar'); // Seleciona o botão de cancelar
    var btnConfirmar = document.getElementById('btn_confirmar'); // Seleciona o botão de confirmar
    var confirmarDataHora = modal.querySelector('#confirmarProcedimento'); // Seleciona o conteúdo do modal

    // Recupera o ID do procedimento armazenado no sessionStorage
    var procedimentoId = sessionStorage.getItem('procedimento_id');
    if (!procedimentoId) {
        alert("Procedimento não selecionado.");
        return;
    }

    // Inicialização do calendário
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'pt-br',
        selectable: true,
        dateClick: function (info) {
            var clickedDate = new Date(info.date);
            var dayOfWeek = clickedDate.getDay();

            if (dayOfWeek === 0) {
                alert("Não é possível selecionar domingos.");
                return;
            }

            // Marcar o dia selecionado
            if (selectedDate) {
                selectedDate.classList.remove('dia-selecionado');
            }

            info.dayEl.classList.add('dia-selecionado');
            selectedDate = info.dateStr;
            exibirHorariosDisponiveis(dayOfWeek);
        }
    });

    calendar.render();

    // Função para exibir os horários disponíveis com base no dia da semana
    function exibirHorariosDisponiveis(dayOfWeek) {
        var horariosContainer = document.getElementById('horarios-disponiveis');
        horariosContainer.innerHTML = '';
        var horariosSemana = ['08:00', '09:00', '10:00', '11:00', '13:15', '14:15', '15:15', '16:15', '17:15', '18:15'];
        var horariosSabado = ['08:00', '09:00', '10:00', '11:00'];
        var horarios = (dayOfWeek >= 1 && dayOfWeek <= 5) ? horariosSemana : horariosSabado;

        // Criar os botões de horário
        horarios.forEach(function (horario) {
            var btnHorario = document.createElement('button');
            btnHorario.textContent = horario;
            btnHorario.classList.add('horario-btn');
            btnHorario.addEventListener('click', function () {
                selectedHorario = horario;
                exibirModal();
            });
            horariosContainer.appendChild(btnHorario);
        });
    }

    // Função para exibir o modal com a data e hora selecionadas
    function exibirModal() {
        if (selectedDate && selectedHorario) {
            var dataFormatada = new Date(selectedDate);

            // **Aqui adicionamos 1 dia na data para exibir no modal** (ajuste do modal)
            dataFormatada.setDate(dataFormatada.getDate() + 1); // Adiciona 1 dia à data

            var dataParaExibir = dataFormatada.toLocaleDateString('pt-BR', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });

            // Exibe a data e hora no modal
            confirmarDataHora.innerHTML = `Você escolheu: <b>${dataParaExibir}</b> às <b>${selectedHorario}</b>.`;
            modal.showModal();
        }
    }

    // Ação para o botão de cancelar
    btnCancelar.addEventListener('click', function () {
        modal.close(); // Fecha o modal
        location.reload(); // Atualiza a página
    });

    // Ação para o botão de confirmar
    btnConfirmar.addEventListener('click', function () {
        // Verifica se os dados estão corretos
        if (selectedDate && selectedHorario) {
            // Pega o ID do usuário (já deve estar na sessão)
            const userIdElement = document.querySelector("#user_id");
            const userId = userIdElement ? userIdElement.dataset.id : null;

            if (userId && procedimentoId) {
                // Prepara os dados para envio
                var dataAgendamento = new Date(selectedDate);
                const horaAgendamento = selectedHorario;

                // Envia os dados via AJAX
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'agendar.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        alert("Agendamento confirmado com sucesso!");
                        modal.close();
                        window.location.href = 'pag_inicial_US.php';
                    } else {
                        alert("Erro ao agendar, tente novamente.");
                    }
                };
                xhr.send('user_id=' + userId + '&procedimento_id=' + procedimentoId + '&data_agendamento=' + dataAgendamento.toISOString().split('T')[0] + '&hora_agendamento=' + horaAgendamento);
            } else {
                alert("Informações inválidas para agendamento.");
            }
        } else {
            alert("Selecione uma data e horário para o agendamento.");
        }
    });
});
