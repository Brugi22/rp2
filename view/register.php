<!DOCTYPE html>
<html>
<head>
    <meta charset="utf8">
    <title>Register</title>
    <link rel="stylesheet" href="<?php echo __SITE_URL;?>/css/style.css">
</head>
<body>
    <h1 class="login-header">Blogs</h1>
    <div class="login-container">
        <h2>Register</h2>
        <form action="<?php echo __SITE_URL . '/blogs.php?rt=login/register_validate'?>" method="POST">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" required><br>
            
            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" required><br>
            
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>
            
            <input type="submit" value="Register">
        </form>
    </div>
</body>
</html>
