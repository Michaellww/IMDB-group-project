document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const email = document.getElementById('loginEmail').value;
    const password = document.getElementById('loginPassword').value;

    fetch('login_handler.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload(); // reload page to update navbar with user email
            } else {
                const errorBox = document.getElementById('login-error');
                errorBox.textContent = data.message;
                errorBox.classList.remove('d-none');
            }
        });
});
