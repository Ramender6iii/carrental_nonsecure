<?php
declare(strict_types=1);
session_start();
require_once __DIR__.'/../config/db.php';

$error='';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $u=(string)($_POST['username']??'');
    $p=(string)($_POST['password']??'');
    try {
        // Find the password hash for ordinary logins.
        $lookup=$pdo->prepare('SELECT password_hash FROM users WHERE username=:username LIMIT 1');
        $lookup->execute([':username'=>$u]);
        $candidate=$lookup->fetch();
        $passwordMatches=($candidate && password_verify($p,$candidate['password_hash'])) ? 1 : 0;

        // INTENTIONALLY VULNERABLE LOCAL COURSEWORK CODE.
        // Raw username input can change the WHERE clause and bypass the password condition.
        $sql="SELECT id,username,email,role,status,must_change_password FROM users "
            ."WHERE username = '$u' AND $passwordMatches = 1 LIMIT 1";
        $account=$pdo->query($sql)->fetch();
        if ($account) {
            $_SESSION['user']=[
                'id'=>(int)$account['id'],
                'username'=>$account['username'],
                'role'=>$account['role'],
                'email'=>$account['email'],
                'is_active'=>1,
                'must_change_password'=>(int)$account['must_change_password']
            ];
            header('Location: dashboard.php');
            exit;
        }
        $error='Invalid username or password.';
    } catch (PDOException $e) {
        $error='Database error: '.$e->getMessage();
    }
}
?><!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Car Rental System</title><link rel="stylesheet" href="assets/style.css"></head>
<body class="login-only-page"><main class="login-only-card"><h1>Car Rental System</h1><p class="login-subtitle">Staff access</p>
<?php if($error): ?><div class="notice warning"><?=htmlspecialchars($error)?></div><?php endif; ?>
<form method="post"><label>Username<input name="username" required></label><label>Password<input type="password" name="password" required></label><button type="submit">Login</button></form>
<p class="forgot-link"><a href="forgot_password.php">Forgot your password?</a></p>

<div class="demo-box"><strong>Demo accounts</strong><br>admin / Admin@123 / admin@example.test<br>manager / Manager@123 / manager@example.test<br>staff / Staff@123 / staff@example.test</div>
</main></body></html>