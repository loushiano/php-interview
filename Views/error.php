<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo h($title ?? 'Error'); ?></title>
    <link rel="stylesheet" href="<?php echo h(SITE_LINK . CSS_PATH); ?>app.css?v=<?php echo filemtime(THEME_PATH . 'css' . ds . 'app.css'); ?>">
</head>
<body class="login-body">
    <main class="login-wrap">
        <section class="login-card">
            <p class="eyebrow">SMG Clients</p>
            <h1><?php echo h($title ?? 'Error'); ?></h1>
            <p class="lede"><?php echo h($message ?? 'Something went wrong.'); ?></p>
            <p><a class="text-link" href="<?php echo h(SITE_LINK); ?>">Back to sign in</a></p>
        </section>
    </main>
</body>
</html>
