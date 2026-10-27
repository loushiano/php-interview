<?php
if (!Session::isAlive()) {
    Session::requireLogin();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo h($title ?? 'SMG Clients'); ?></title>
    <link rel="stylesheet" href="<?php echo h(SITE_LINK . CSS_PATH); ?>app.css?v=<?php echo filemtime(THEME_PATH . 'css' . ds . 'app.css'); ?>">
</head>
<body>
