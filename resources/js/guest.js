
        // Password toggle logic
function setupPasswordToggle(inputId, buttonId, iconId) {
    const input = document.getElementById(inputId);
    const button = document.getElementById(buttonId);
    const icon = document.getElementById(iconId);

    if (!input || !button || !icon) return;

    button.addEventListener('click', function() {
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    setupPasswordToggle('password', 'togglePassword', 'eyeIcon');
    setupPasswordToggle('password_confirmation', 'toggleConfirmPassword', 'confirmEyeIcon');

    const navbar = document.getElementById('navbar');
    if (navbar) {
        window.addEventListener('scroll', () => { 
            navbar.classList.toggle('scrolled', window.scrollY > 10); 
        });
    }
});

