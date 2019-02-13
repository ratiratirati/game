<html>
<head>
<meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/fonts.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
<script>
    setTimeout(function() {
        $('.error').slideToggle()
    }, 1500);
</script>
<?php
include ('server.php');
include ('proces.php');
?>
<div class="login_form">
    <form method="post" action="index.php">
        <input type="text" name="username" placeholder="მომხმარებელი">
        <br>
        <input type="password" name="password" placeholder="პაროლი">
        <br>
        <button name="login">შესვლა</button>
        <br>
        <a href="register.php">რეგისტრაცია</a>
        <div class="error">
        <?php include ('error.php')?>
        </div>
    </form>
</div>
</body>
</html>