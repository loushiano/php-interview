<?php
$noticeMessages = array(
    'saved' => 'Client name updated.',
    'missing' => 'That client could not be found.',
    'invalid' => 'That form is no longer valid. Try again.',
);
$noticeCode = (isset($_GET['notice']) && is_string($_GET['notice'])) ? $_GET['notice'] : '';
$noticeText = isset($noticeMessages[$noticeCode]) ? $noticeMessages[$noticeCode] : '';
?>
<h1>Dashboard</h1>
<p class="lede">Signed in as <?php echo h(Session::getFullName()); ?>.</p>
<?php if ($noticeText !== '') { ?>
    <p class="alert<?php echo $noticeCode === 'saved' ? ' alert-info' : ''; ?>" role="<?php echo $noticeCode === 'saved' ? 'status' : 'alert'; ?>"><?php echo h($noticeText); ?></p>
<?php } ?>

<section class="stat" aria-label="Client count">
    <p class="stat-label">Clients</p>
    <p class="stat-value"><?php echo number_format($clientCount); ?></p>
    <p class="stat-note">Active client records</p>
</section>

<section class="panel">
    <h2>Client list</h2>
    <?php if (empty($clients)) { ?>
        <p class="empty">No clients yet.</p>
    <?php } else { ?>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th scope="col">Client</th>
                        <th scope="col">Contact</th>
                        <th scope="col">Email</th>
                        <th scope="col">Country</th>
                        <th class="action" scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clients as $client) { ?>
                        <tr>
                            <td><?php echo h($client['client_name']); ?></td>
                            <td><?php echo h($client['contact_name']); ?></td>
                            <td><?php echo h($client['email']); ?></td>
                            <td><?php echo h($client['country']); ?></td>
                            <td class="action"><a class="text-link" href="<?php echo h(SITE_LINK . 'Dashboard/edit/' . (int) $client['client_id']); ?>" aria-label="Edit <?php echo h($client['client_name']); ?>">Edit</a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } ?>
</section>
