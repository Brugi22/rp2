<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<div class="center">
    <div class="container">
        <div class="header">
            <h1>Announcements</h1>
        </div>
        <?php foreach ($announcements as $announcement): ?>
            <div class="announcement">
                <p><?php echo htmlspecialchars($announcement->sadrzaj_objava, ENT_QUOTES, 'UTF-8'); ?></p>
                <div class="comments">
                    <h3>Comments:</h3>
                    <?php 
                    $announcement_id = $announcement->id_objava; 
                    foreach ($comments as $comment): 
                        if ($comment->id_objava === $announcement_id): ?>
                            <div class="comment">
                                <p><?php echo htmlspecialchars($comment->sadrzaj_komentar, ENT_QUOTES, 'UTF-8'); ?></p>
                            </div>
                        <?php endif; 
                    endforeach; ?>
                    <div class="comment-form">
                        <h4>Add a Comment</h4>
                        <form action="<?php echo __SITE_URL . '/blogs.php?rt=blog/add_comment&id_objava=' . $announcement_id . '&id_blog=' . $blog_id; ?>" method="post">
                            <input type="text" name="new_comment" placeholder="Enter your comment" required>
                            <input type="submit" value="Add Comment">
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="center">
    <div class="form-container">
        <h2>Publish a New Announcement</h2>
        <form action="<?php echo __SITE_URL . '/blogs.php?rt=blog/create_new_announcement&id_blog=' . $blog_id; ?>" method="post">
            <input type="text" name="new_announcement" placeholder="Enter announcement content" required>
            <input type="submit" value="Publish Announcement">
        </form>
    </div>
</div>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>