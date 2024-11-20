document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("modal_cancelar");
    const btnNao = document.getElementById("btn_nao");
    const btnSim = document.getElementById("btn_sim");
    let currentAgendamentoId = null;

    // Função para abrir o modal
    function abrirModal(id) {
        currentAgendamentoId = id; // Salva o ID do agendamento atual
        modal.showModal();
    }

    // Fechar o modal ao clicar em "Não"
    btnNao.addEventListener("click", () => {
        modal.close();
        currentAgendamentoId = null; // Reseta o ID
    });

    // Adicionar evento aos botões "Cancelar"
    const cancelarButtons = document.querySelectorAll(".btn_cancelar");
    cancelarButtons.forEach(button => {
        button.addEventListener("click", function () {
            const agendamentoId = this.dataset.id; // Obtém o ID do agendamento
            abrirModal(agendamentoId);
        });
    });

    btnSim.addEventListener("click", () => {
        if (currentAgendamentoId) {
            // Envia uma requisição ao servidor para excluir o agendamento
            fetch('cancelar_agendamento.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: currentAgendamentoId })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.success);
                        // Recarrega a página após o sucesso
                        location.reload();
                    } else {
                        alert(data.error || 'Erro ao cancelar o agendamento.');
                    }
                })
                .catch(error => {
                    console.error('Erro na requisição:', error);
                    alert('Erro ao tentar cancelar o agendamento.');
                })
                .finally(() => {
                    modal.close();
                    currentAgendamentoId = null;
                });
        }
    });

});
