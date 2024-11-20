document.addEventListener('DOMContentLoaded', function () {
    // Função para armazenar o ID do procedimento
    function setProcedimentoId(id) {
        console.log("ID do Procedimento Selecionado:", id);

        // Enviar o ID para o servidor via AJAX
        const formData = new FormData();
        formData.append('id', id);  // Usando 'id', como está na tabela de procedimentos

        // Enviar a requisição para o servidor
        fetch('salvar_id_procedimento.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.text())
            .then(data => {
                console.log(data); // Exibe a resposta do servidor, se necessário
            })
            .catch(error => {
                console.error('Erro:', error);
            });
    }

    // Adiciona eventos aos inputs de rádio para cada procedimento
    document.getElementById('input_ledterapia').addEventListener('click', function () { setProcedimentoId(1); });
    document.getElementById('input_limpezadepele').addEventListener('click', function () { setProcedimentoId(2); });
    document.getElementById('input_microagulhamento').addEventListener('click', function () { setProcedimentoId(3); });
    document.getElementById('input_preenchimentofacial').addEventListener('click', function () { setProcedimentoId(4); });
    document.getElementById('input_preenchimentolabial').addEventListener('click', function () { setProcedimentoId(5); });
});
