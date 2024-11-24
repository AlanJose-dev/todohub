<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>
<body>
<h1>Login</h1>
<form action="/login" method="post">
    <input type="hidden" name="_token" value="<?=csrf_token()?>">
    <label>
        Email:
        <input type="email" name="email" required/>
    </label>
    <br>
    <label>
        Password:
        <input type="password" name="password" required/>
    </label>
    <br>
    <?php if(session()->getFlashBag()->has('message')):?>
        <p style="color: red;"><?=session()->getFlashBag()->get('message')[0]?></p>
    <?php endif;?>
    <input type="submit" value="Login">
</form>
</body>
</html>