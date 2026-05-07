<?php
// ============================================================
// Home Page
// URL: /socialnet/index.php
// ============================================================
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/layout.php';

require_login();

$db    = get_db();
$me_id = (int)$_SESSION['user_id'];

// Fetch all OTHER users to display
$stmt = $db->prepare('SELECT id, username, fullname FROM account WHERE id != ? ORDER BY fullname ASC');
$stmt->bind_param('i', $me_id);
$stmt->execute();
$others = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$db->close();

page_header('Home', 'home');
?>

<h1 class="page-title">Welcome back, <?= htmlspecialchars($_SESSION['fullname']) ?>! 👋</h1>

<!-- Logged-in user summary card -->
<div class="card">
  <h2>My Account</h2>
  <div class="profile-hero">
    <div class="avatar-lg">
      <?= strtoupper(mb_substr($_SESSION['username'], 0, 1)) ?>
    </div>
    <div class="info">
      <h1><?= htmlspecialchars($_SESSION['fullname']) ?></h1>
      <p class="username-tag">@<?= htmlspecialchars($_SESSION['username']) ?></p>
      <a href="/socialnet/profile.php" class="btn btn-primary" style="display:inline-block;margin-top:.75rem;font-size:.85rem;padding:.45rem 1.1rem;border-radius:20px;text-decoration:none;">
        View My Profile →
      </a>
    </div>
  </div>
</div>

<!-- Other users grid -->
<div class="card">
  <h2>People on SocialNet</h2>
  <?php if (empty($others)): ?>
    <p class="text-muted" style="padding:.5rem 0;">
      No other users yet. Ask the admin to add more accounts.
    </p>
  <?php else: ?>
    <div class="user-grid" id="users-grid">
      <?php foreach ($others as $u): ?>
        <div class="user-card">
          <div class="avatar">
            <?= strtoupper(mb_substr($u['username'], 0, 1)) ?>
          </div>
          <div class="uname"><?= htmlspecialchars($u['username']) ?></div>
          <div class="fname"><?= htmlspecialchars($u['fullname']) ?></div>
          <a class="view-btn"
             href="/socialnet/profile.php?owner=<?= urlencode($u['username']) ?>"
             id="view-user-<?= (int)$u['id'] ?>">
            View Profile
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>

<?php page_footer(); ?>
