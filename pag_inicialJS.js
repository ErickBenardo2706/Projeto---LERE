function toggleDropdown() {
    const dropdown = document.getElementById("menuDropdown");
    dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
}
document.addEventListener("click", function(event) {
    const dropdown = document.getElementById("menuDropdown");
    const icon = document.getElementById("login_icon");
    if (dropdown.style.display === "block" && !icon.contains(event.target)) {
        dropdown.style.display = "none";
    }
});

    

// Função para verificar o status de login antes de acessar o agendamento
function checkLoginStatus() {
    if (isUserLoggedIn) {
        // Se o usuário estiver logado, redireciona para a página de agendamento
        window.location.href = 'pag_agendamentoUS.php';
    } else {
        // Caso contrário, exibe o alerta solicitando login
        alert('É necessário fazer login antes de acessar a página de agendamento.');
    }
}
