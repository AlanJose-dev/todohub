<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <title>TodoHub - Manager your tasks easily</title>
</head>
<body>
<h1>Hey mom!</h1>
<?php if (\App\Facades\Auth::check()): ?>
    <a href="/dashboard">Dashboard</a>
<?php else: ?>
    <a href="register">Register</a>
    <a href="login">Login</a>
<?php endif; ?>
</body>
</html>