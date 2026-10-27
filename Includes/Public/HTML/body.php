<div class="shell">
    <header class="topbar">
        <a class="brand" href="<?php echo h(SITE_LINK); ?>Dashboard">SMG Clients</a>
        <div class="topbar-user">
            <span><?php echo h(Session::getFullName()); ?></span>
            <a href="<?php echo h(SITE_LINK); ?>smc/dologout">Log out</a>
        </div>
    </header>
    <main class="content">
