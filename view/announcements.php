<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<div class="container">
    <div class="header">
        <h1>Announcements</h1>
    </div>
    <?php foreach ($announcements as $announcement): ?>
        <div class="announcement">
            <p><?php echo htmlspecialchars($announcement->$sadrzaj_objava, ENT_QUOTES, 'UTF-8'); ?></p>
        </div>
    <?php endforeach; ?>
</div>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>