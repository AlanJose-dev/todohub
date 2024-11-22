<?php
$errors = [
    'name' => \App\Facades\Session::get('errors')['name'] ?? [],
    'email' => \App\Facades\Session::get('errors')['email'] ?? [],
    'password' => \App\Facades\Session::get('errors')['password'] ?? [],
];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
</head>
<body>
<h1>Register</h1>
<form action="/user/store" method="post">
    <label>
        Name:
        <input type="text" name="name" required/>
        <?php foreach($errors['name'] as $error):?>
            <p style="color: red"><?=$error?></p><br>
        <?php endforeach;?>
    </label>
    <label>
        Email:
        <input type="email" name="email" required/>
        <?php foreach($errors['email'] as $error):?>
            <p style="color: red"><?=$error?></p><br>
        <?php endforeach;?>
    </label>
    <label>
        Password:
        <input type="password" name="password" required/>
        <?php foreach($errors['password'] as $error):?>
            <p style="color: red"><?=$error?></p><br>
        <?php endforeach;?>
    </label>
    <input type="submit" value="Send">
</form>
</body>
</html>