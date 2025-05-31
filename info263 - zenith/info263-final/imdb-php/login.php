<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>IMDb Login - Star Wars Style</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>

<!-- Top Yellow Bar with Scrolling IMDB -->
<div class="top-bar">
    <marquee behavior="scroll" direction="left" scrollamount="10">IMDB</marquee>
</div>

<!-- Bottom Yellow Bar with Scrolling MOVIE -->
<div class="bottom-bar">
    <marquee behavior="scroll" direction="right" scrollamount="10">MOVIE</marquee>
</div>

<!-- Login Container -->
<div class="login-box">
    <h1 class="login-header">LOGIN</h1>
    <form action="login_handler.php" method="POST">


    <input
                type="text"
                name="username"
                class="input-bubble"
                placeholder="Enter your username"
                required
                autocomplete="username"
        />

        <input
                type="password"
                name="password"
                class="input-bubble"
                placeholder="Enter your password"
                required
                autocomplete="current-password"
                id="password"
        />

        <div class="captcha-box">
            <input type="checkbox" id="captcha" />
            <label for="captcha">I am not a robot</label>
        </div>

        <button type="submit" class="login-button">LOGIN</button>

        <div class="extra-links">
            <a href="forgot-password.html">Forgot Password?</a>
            <a href="create-account.html">Create Password</a>
        </div>
    </form>
</div>

<script src="script.js"></script>
</body>
</html>



