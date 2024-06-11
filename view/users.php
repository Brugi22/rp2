<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<div class="table-container">
	<table>
		<?php 
			foreach( $users as $user )
			{
				echo '<tr>' .
					'<td>' . $user['username'] . '</td>' .
					'<td class="right"><a href="' . __SITE_URL . '/blogs.php?rt=blog/follow_user&user_id=' . $user['id'] . '" style="text-decoration: none; color: black;">FOLLOW</a></td>' .
					'</tr>';
			}
		?>
	</table>
</div>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>