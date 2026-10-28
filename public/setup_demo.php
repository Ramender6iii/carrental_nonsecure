<?php
// Local coursework setup: add missing sample accounts without resetting existing ones.
declare(strict_types=1);
if (!in_array($_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1','::1'], true)) {
    http_response_code(403);
    exit('Local setup only.');
}
require_once __DIR__.'/../config/db.php';
$accounts=[
    ['admin','admin@example.test','Admin@123','ADMIN'],
    ['manager','manager@example.test','Manager@123','MANAGER'],
    ['staff','staff@example.test','Staff@123','RENTAL_STAFF']
];
$check=$pdo->prepare('SELECT id FROM users WHERE username=:username OR email=:email LIMIT 1');
$insert=$pdo->prepare("INSERT INTO users(username,email,password_hash,role,status) VALUES(:username,:email,:hash,:role,'ACTIVE')");
$added=0;
foreach ($accounts as [$name,$email,$password,$role]) {
    $check->execute([':username'=>$name,':email'=>$email]);
    if (!$check->fetch()) {
        $insert->execute([':username'=>$name,':email'=>$email,':hash'=>password_hash($password,PASSWORD_DEFAULT),':role'=>$role]);
        $added++;
    }
}
header('Content-Type: text/plain; charset=utf-8');
echo "Setup complete. Added $added missing accounts. Existing accounts were not changed.\n";
echo "Open login.php to test. Remove this setup file when finished.\n";
