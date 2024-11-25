document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    var selectedDate = null;
    var selectedHorario = null;
    var modal = document.getElementById('modalAgendamento');
    var btnCancelar = document.getElementById('btn_cancelar');
    var btnConfirmar = document.getElementById('btn_confirmar');
    var confirmarDataHora = modal.querySelector('#confirmarProcedimento');

    // Recupera o ID do procedimento armazenado no sessionStorage
    var procedimentoId = sessionStorage.getItem('procedimento_id');
    if (!procedimentoId) {
        alert("Procedimento não selecionado.");
        return;
    }

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'pt-br',
        selectable: true,
        dateClick: function (info) {
            var clickedDate = new Date(info.date);
            var dayOfWeek = clickedDate.getDay();

            if (dayOfWeek === 0) {
                return; // Não permite selecionar domingo
            }

            // Se já existir uma data selecionada, desmarcar a seleção anterior
            if (selectedDate) {
                var previousSelectedDay = calendar.getDate().getDate();
                document.querySelector(`[data-date="${selectedDate}"]`).classList.remove('dia-selecionado');
            }

            // Marcar o novo dia selecionado
            info.dayEl.classList.add('dia-selecionado');
            selectedDate = info.dateStr;
            exibirHorariosDisponiveis(clickedDate);
        },
        datesSet: function () {
            applyPastDaysStyle();
            applyHeaderDaysStyle(); // Certifica-se que o cabeçalho também será ajustado
        },
        dayCellDidMount: function (info) {
            var cellDate = new Date(info.date);
            var today = new Date();
            today.setHours(0, 0, 0, 0);

            // Desabilita dias passados
            if (cellDate < today) {
                info.el.style.pointerEvents = "none";
                info.el.style.opacity = "0.5";
            } else {
                info.el.style.pointerEvents = "auto";
                info.el.style.opacity = "1";
            }
        }
    });

    // Garante que `dayCellDidMount` é executado para o mês atual após renderizar
    calendar.render();
    applyPastDaysStyle();

    function applyPastDaysStyle() {
        var today = new Date();
        today.setHours(0, 0, 0, 0); // Garante que o "hoje" ignore as horas

        document.querySelectorAll('.fc-day').forEach(function (dayCell) {
            var cellDate = new Date(dayCell.getAttribute('data-date'));

            // Desabilita os dias antes de hoje
            if (cellDate < today) {
                dayCell.style.pointerEvents = "none"; // Impede clique
                dayCell.style.opacity = "0.5"; // Estiliza como desabilitado
            }
        });
    }

    // Remove qualquer estilo de transparência nos cabeçalhos dos dias da semana
    function applyHeaderDaysStyle() {
        document.querySelectorAll('.fc-col-header-cell').forEach(function (headerCell) {
            // Remove a opacidade, para que os cabeçalhos fiquem visíveis normalmente
            headerCell.style.opacity = "1"; // Garantir que não haja transparência
            headerCell.style.pointerEvents = "auto"; // Garantir que não esteja desabilitado
        });
    }

    // Função para exibir os horários disponíveis com base no dia da semana
    function exibirHorariosDisponiveis(clickedDate) {
        var horariosContainer = document.getElementById('horarios-disponiveis');
        horariosContainer.innerHTML = ''; // Limpa os horários existentes

        var horariosSemana = ['08:00', '09:00', '10:00', '11:00', '13:15', '14:15', '15:15', '16:15', '17:15', '18:15'];
        var horariosSabado = ['08:00', '09:00', '10:00', '11:00'];

        var horarios = (clickedDate.getDay() >= 1 && clickedDate.getDay() <= 5) ? horariosSemana : horariosSabado;

        var today = new Date();
        today.setHours(0, 0, 0, 0); // Ignora horas para comparação

        if (clickedDate >= today) {
            fetch('verificar_horarios.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `data=${clickedDate.toISOString().split('T')[0]}&procedimento_id=${procedimentoId}`
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Erro HTTP: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log("Horários ocupados recebidos:", data.horarios_ocupados);
                    const horariosOcupados = data.horarios_ocupados || [];

                    horarios.forEach(function (horario) {
                        var btnHorario = document.createElement('button');
                        btnHorario.textContent = horario;
                        btnHorario.classList.add('horario-btn');

                        // Desabilita horários passados se for o dia atual
                        if (clickedDate.toDateString() === today.toDateString()) {
                            var horarioAtual = new Date();
                            var [hora, minutos] = horario.split(':');
                            horarioAtual.setHours(hora, minutos);

                            if (horarioAtual <= new Date()) {
                                btnHorario.disabled = true;
                                btnHorario.style.opacity = "0.5";
                            }
                        }

                        // Desabilita horários ocupados
                        if (horariosOcupados.includes(horario)) {
                            console.log(`Horário ${horario} está ocupado.`);
                            btnHorario.disabled = true;
                            btnHorario.style.opacity = "0.5";
                        }

                        // Adiciona evento de clique para horários disponíveis
                        btnHorario.addEventListener('click', function () {
                            selectedHorario = horario;
                            exibirModal();
                        });

                        horariosContainer.appendChild(btnHorario);
                    });
                })
                .catch(error => {
                    console.error("Erro ao carregar horários:", error);
                    alert("Não foi possível carregar os horários disponíveis. Tente novamente.");
                });
        }
    }


    // Função para exibir o modal com a data e hora selecionadas
    function exibirModal() {
        if (selectedDate && selectedHorario) {
            var dataFormatada = new Date(selectedDate);

            // Adiciona 1 dia na data para exibir no modal
            dataFormatada.setDate(dataFormatada.getDate() + 1);

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
        if (selectedDate && selectedHorario) {
            const userIdElement = document.querySelector("#user_id");
            const userId = userIdElement ? userIdElement.dataset.id : null;

            if (userId && procedimentoId) {
                var dataAgendamento = new Date(selectedDate);
                const horaAgendamento = selectedHorario;

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
