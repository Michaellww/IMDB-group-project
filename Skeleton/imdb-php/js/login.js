document.getElementById('loginForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const email = document.getElementById('loginEmail').value;
    const password = document.getElementById('loginPassword').value;

    fetch('login_handler.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload(); // or you can close modal and update UI
            } else {
                const errBox = document.getElementById('login-error');
                errBox.textContent = data.message;
                errBox.classList.remove('d-none');
            }
        })
        .catch(err => console.error('Login failed:', err));
});