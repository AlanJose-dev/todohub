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
    <label>
        Email:
        <input type="email" name="email" required/>
    </label>
    <label>
        Password:
        <input type="password" name="password" required/>
    </label>
    <input type="submit" value="Send">
</form>
</body>
</html>