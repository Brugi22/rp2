<?php require_once __SITE_PATH . '/view/_header.php'; ?>
<div class="table-container">
	<table>
		<?php 
			foreach( $blogs as $blog )
			{
				echo 
                    '<tr>' .
                        '<td><a href="' . __SITE_URL . '/blogs.php?rt=blog/blog_announcuments&id_blog=' . $blog->id_blog . '" style="text-decoration: none; color: black;">' . $blog->ime_blog . '</a></td>' .
                        '<td class="right">' . $blog->blog_timestamp . '</td>' .
                    '</tr>';
			}
        ?>
    </table>
</div>

<div class="center">
    <div class="form-container">
        <h2>Create a New Blog</h2>
        <form action="<?php echo __SITE_URL; ?>/blogs.php?rt=blog/create_new_blog" method="post">
            <label for="blogName">Blog Name</label>
            <input type="text" id="blogName" name="blogName" required>
            <input type="submit" value="Add New Blog!">
        </form>
    </div>
</div>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
