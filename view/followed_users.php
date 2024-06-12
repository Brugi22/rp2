<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<div class="table-container">
	<table>
		<?php 
			foreach( $users as $user )
			{
				echo '<tr>' .
					'<td><a href="' . __SITE_URL . '/blogs.php?rt=blog/user&user_id=' . $user['id'] . '" style="text-decoration: none; color: black;">' . $user['username'] . '</a></td>' .
					'<td class="right">FOLLOWING</td>' .
					'</tr>';
			}
		?>
	</table>
</div>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>