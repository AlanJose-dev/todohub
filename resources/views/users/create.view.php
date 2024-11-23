<?php
$errors = app()->resolve('_session')->getFlashBag()->get('errors');
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
    <input type="hidden" name="_token" value="<?=csrf_token()?>">
    <label>
        Name:
        <input type="text" name="name" required/>
        <?php foreach($errors['name'] ?? [] as $errorMessage):?>
            <p style="color: red;"><?=$errorMessage?></p>
        <?php endforeach;?>
    </label>
    <br>
    <label>
        Email:
        <input type="email" name="email" required/>
        <?php foreach($errors['email'] ?? [] as $errorMessage):?>
            <p style="color: red;"><?=$errorMessage?></p>
        <?php endforeach;?>
    </label>
    <br>
    <label>
        Password:
        <input type="password" name="password" required/>
        <?php foreach($errors['password'] ?? [] as $errorMessage):?>
            <p style="color: red;"><?=$errorMessage?></p>
        <?php endforeach;?>
    </label>
    <br>
    <input type="submit" value="Register">
</form>
</body>
</html>