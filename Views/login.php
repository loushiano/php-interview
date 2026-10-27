<?php
$messages = array(
    1 => 'Wrong username or password.',
    7 => 'Your session timed out. Sign in again.',
    8 => 'You have logged out.',
);
$alert = isset($messages[$login_error]) ? $messages[$login_error] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign in</title>
    <link rel="stylesheet" href="<?php echo h(SITE_LINK . CSS_PATH); ?>app.css?v=<?php echo filemtime(THEME_PATH . 'css' . ds . 'app.css'); ?>">
</head>
<body class="login-body">
    <main class="login-wrap">
        <section class="login-card">
            <p class="eyebrow">SMG Clients</p>
            <h1>Sign in</h1>
            <p class="lede">Client dashboard for the interview exercise.</p>
            <?php if ($alert !== '') { ?>
                <p class="alert<?php echo $login_error === 8 ? ' alert-info' : ''; ?>" role="alert"><?php echo h($alert); ?></p>
            <?php } ?>
            <form action="<?php echo h(SITE_LINK); ?>smc/doLogin" method="post">
                <label for="username">Username</label>
                <input id="username" name="Username" type="text" autocomplete="username" required autofocus>
                <label for="password">Password</label>
                <input id="password" name="Password" type="password" autocomplete="current-password" required>
                <button type="submit">Sign in</button>
            </form>
            <p class="hint">Demo account <strong>admin</strong> / <strong>admin123</strong></p>
        </section>
    </main>
</body>
</html>
