document.getElementById("login-form").addEventListener("submit", function (e) {
    e.preventDefault();

    const username = document.querySelector('input[name="username"]').value.trim();
    const password = document.querySelector('input[name="password"]').value.trim();
    const captchaChecked = document.getElementById("captcha").checked;

    if (!captchaChecked) {
        alert("Please confirm you're not a robot.");
        return;
    }

    if (username === "1" && password === "1") {
        window.location.href = "success.html";
    } else {
        window.location.href = "error.html";
    }
});

