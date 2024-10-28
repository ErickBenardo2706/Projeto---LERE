
    document.addEventListener('DOMContentLoaded', function () {
        const textareaDiv = document.getElementById('textarea_alergia');
        const radioSim = document.getElementById('input_sim');
        const radioNao = document.getElementById('input_nao');
        
        radioSim.addEventListener('change', function () {
            if (radioSim.checked) {
                textareaDiv.style.display = 'block';
            }
        });
        
        radioNao.addEventListener('change', function () {
            if (radioNao.checked) {
                textareaDiv.style.display = 'none';
            }
        });

        // Validação de formulário
        const form = document.getElementById('form');
        const campos = document.querySelectorAll('.inputUser');
        const spans = document.querySelectorAll('.span_required');
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        form.addEventListener('submit', (event) => {
            let isValid = true;

            // Valida nome
            if (campos[0].value.length < 3) {
                setError(0);
                isValid = false;
            } else {
                removeError(0);
            }

            // Valida email
            if (!emailRegex.test(campos[1].value)) {
                setError(1);
                isValid = false;
            } else {
                removeError(1);
            }

            // Valida senha
            if (campos[2].value.length < 8) {
                setError(2);
                isValid = false;
            } else {
                removeError(2);
            }

            // Valida confirmação de senha
            if (campos[2].value !== campos[3].value || campos[3].value.length < 8) {
                setError(3);
                isValid = false;
            } else {
                removeError(3);
            }

            if (!isValid) {
                event.preventDefault(); 
            }
        });

        function setError(index) {
            campos[index].classList.add('error');
            spans[index].classList.add('active');
        }

        function removeError(index) {
            campos[index].classList.remove('error');
            spans[index].classList.remove('active');
        }
    });

