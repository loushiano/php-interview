<h1>Dashboard</h1>
<p class="lede">Signed in as <?php echo h(Session::getFullName()); ?>.</p>

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
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clients as $client) { ?>
                        <tr>
                            <td><?php echo h($client['client_name']); ?></td>
                            <td><?php echo h($client['contact_name']); ?></td>
                            <td><?php echo h($client['email']); ?></td>
                            <td><?php echo h($client['country']); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } ?>
</section>
