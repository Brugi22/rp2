<!DOCTYPE html>
<html>
<head>
	<meta charset="utf8">
	<title>Balance</title>
	<link rel="stylesheet" href="<?php echo __SITE_URL;?>/css/style.css">
</head>
<body>
    <h1 class="login-header">Blogs</h1>
    <div class="login-container">
        <h2>Login</h2>
        <form action="<?php echo __SITE_URL . '/blogs.php?rt=login/validate'?>" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>
            <input type="submit" value="Login">
        </form>
        <div>Don't have account, <a href="<?php echo __SITE_URL; ?>/blogs.php?rt=login/register"> register</a></div>
</body>
</html>