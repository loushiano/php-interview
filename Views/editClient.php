<?php
$facts = array(
    'Contact' => trim((string) ($client['contact_name'] ?? '')),
    'Email' => trim((string) ($client['email'] ?? '')),
    'Country' => trim((string) ($client['country'] ?? '')),
);
$facts = array_filter($facts, function ($value) {
    return $value !== '';
});
$describedBy = $errorText !== '' ? ' aria-invalid="true" aria-describedby="name-error"' : '';
?>
<p class="back-link"><a class="text-link" href="<?php echo h(SITE_LINK); ?>Dashboard">Back to clients</a></p>
<h1>Edit client name</h1>
<p class="lede">This name is the one shown on the client list.</p>

<section class="panel editor">
    <?php if ($errorText !== '') { ?>
        <p id="name-error" class="alert" role="alert"><?php echo h($errorText); ?></p>
    <?php } ?>
    <form action="<?php echo h(SITE_LINK); ?>Dashboard/updateName" method="post">
        <input type="hidden" name="csrf_token" value="<?php echo h(Session::csrfToken()); ?>">
        <input type="hidden" name="client_id" value="<?php echo (int) $client['client_id']; ?>">
        <label for="client_name">Client name</label>
        <input id="client_name" name="client_name" type="text" value="<?php echo h($client['client_name']); ?>" required maxlength="<?php echo (int) $maxNameLength; ?>" autocomplete="off" autofocus<?php echo $describedBy; ?>>
        <?php if (!empty($facts)) { ?>
            <dl class="facts">
                <?php foreach ($facts as $label => $value) { ?>
                    <div>
                        <dt><?php echo h($label); ?></dt>
                        <dd><?php echo h($value); ?></dd>
                    </div>
                <?php } ?>
            </dl>
        <?php } ?>
        <button type="submit">Save name</button>
    </form>
</section>
