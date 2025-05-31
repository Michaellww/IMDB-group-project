// Add to existing script.js
document.getElementById('password').addEventListener('input', function(e) {
    const password = e.target.value;
    const strengthBar = document.querySelector('.strength-bar');
    const strengthText = document.querySelector('.strength-text');

    let strength = 0;
    if (password.match(/[a-z]+/)) strength++;
    if (password.match(/[A-Z]+/)) strength++;
    if (password.match(/[0-9]+/)) strength++;
    if (password.match(/[!@#$%^&*()]+/)) strength++;

    const width = (strength/4) * 100;
    strengthBar.style.width = width + '%';

    strengthBar.style.backgroundColor =
        strength < 2 ? 'red' :
            strength < 4 ? 'orange' : 'green';

    strengthText.textContent =
        strength < 2 ? 'Weak' :
            strength < 4 ? 'Medium' : 'Strong';
});