<?php

if (PHP_SAPI !== 'cli') {
    exit(1);
}

$root = __DIR__;
$separator = DIRECTORY_SEPARATOR;
$dbPath = $root . $separator . 'data' . $separator . 'interview.sqlite';
$directory = dirname($dbPath);

if (!is_dir($directory) && !mkdir($directory, 0755, true) && !is_dir($directory)) {
    fwrite(STDERR, "Could not create {$directory}\n");
    exit(1);
}

$pdo = new PDO('sqlite:' . $dbPath);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$schema = file_get_contents($root . $separator . 'sql' . $separator . 'schema.sql');
$pdo->exec($schema);

$pdo->exec('DELETE FROM tbl_client');
$pdo->exec('DELETE FROM tbl_user');
$pdo->exec("DELETE FROM sqlite_sequence WHERE name IN ('tbl_client', 'tbl_user')");

$insertUser = $pdo->prepare(
    'INSERT INTO tbl_user (user_name, user_password, user_first_name, user_last_name, status_id)
     VALUES (?, ?, ?, ?, 1)'
);
$insertUser->execute(array(
    'admin',
    password_hash('admin123', PASSWORD_DEFAULT),
    'Alex',
    'Morgan',
));

$insertClient = $pdo->prepare(
    'INSERT INTO tbl_client (client_name, contact_name, email, country, status_id)
     VALUES (?, ?, ?, ?, 1)'
);
$clients = array(
    array('Test Client 1', 'Test Contact 1', 'test.contact1@test.example', 'Canada'),
    array('Test Client 2', 'Test Contact 2', 'test.contact2@test.example', 'United Kingdom'),
    array('Test Client 3', 'Test Contact 3', 'test.contact3@test.example', 'United States'),
    array('Test Client 4', 'Test Contact 4', 'test.contact4@test.example', 'United Kingdom'),
    array('Test Client 5', 'Test Contact 5', 'test.contact5@test.example', 'Canada'),
    array('Test Client 6', 'Test Contact 6', 'test.contact6@test.example', 'United States'),
    array('Test Client 7', 'Test Contact 7', 'test.contact7@test.example', 'United Kingdom'),
    array('Test Client 8', 'Test Contact 8', 'test.contact8@test.example', 'Canada'),
    array('Test Client 9', 'Test Contact 9', 'test.contact9@test.example', 'United States'),
    array('Test Client 10', 'Test Contact 10', 'test.contact10@test.example', 'United Kingdom'),
);
foreach ($clients as $client) {
    $insertClient->execute($client);
}

$users = (int) $pdo->query('SELECT COUNT(*) FROM tbl_user')->fetchColumn();
$clientCount = (int) $pdo->query('SELECT COUNT(*) FROM tbl_client')->fetchColumn();
echo "Reset {$dbPath}\nUsers: {$users}\nClients: {$clientCount}\n";
