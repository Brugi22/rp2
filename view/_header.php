<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Blogs</title>
	<link rel="stylesheet" href="<?php echo __SITE_URL;?>/css/style.css">
</head>
<body>
	<div class="header">
		<h1 class="title">Blogs</h1>
		<div style="color: white; padding: 10px;">
			<div>Hello, <span style="font-weight: bold;"><?php echo $_SESSION['username'] ?></span></div>
			<div><a href="<?php echo __SITE_URL; ?>/blogs.php?rt=login">logout</a></div>
		</div>
	</div>

	<div class="navbar">
		<a href="<?php echo __SITE_URL; ?>/blogs.php?rt=blog">My Blogs</a>
		<a href="<?php echo __SITE_URL; ?>/blogs.php?rt=blog">Following</a>
		<a href="<?php echo __SITE_URL; ?>/blogs.php?rt=blog/users">Find users</a>
	</div>
