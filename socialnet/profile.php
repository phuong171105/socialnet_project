<?php
// ============================================================
// Profile Page
// URL: /socialnet/profile.php
// Query: ?owner=<username>   (optional; defaults to logged-in user)
// ============================================================
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/layout.php';

require_login();

$db = get_db();

// Determine the profile owner
if (!empty($_GET['owner'])) {
    $owner_uname = trim($_GET['owner']);
    $stmt = $db->prepare('SELECT id, username, fullname, description FROM account WHERE username = ?');
    $stmt->bind_param('s', $owner_uname);
    $stmt->execute();
    $owner = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$owner) {
        $db->close();
        http_response_code(404);
        page_header('User Not Found', 'profile');
        echo '<div class="card"><p class="text-muted">User "' . htmlspecialchars($owner_uname) . '" not found.</p></div>';
        page_footer();
        exit;
    }
} else {
    // Default to logged-in user
    $me_id = (int)$_SESSION['user_id'];
    $stmt  = $db->prepare('SELECT id, username, fullname, description FROM account WHERE id = ?');
    $stmt->bind_param('i', $me_id);
    $stmt->execute();
    $owner = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}
$db->close();

$is_own_profile = ($owner['username'] === $_SESSION['username']);

page_header('Profile – ' . $owner['username'], 'profile');
?>

<h1 class="page-title">Profile</h1>

<div class="card">
  <div class="profile-hero">
    <div class="avatar-lg">
      <?= strtoupper(mb_substr($owner['username'], 0, 1)) ?>
    </div>
    <div class="info">
      <h1><?= htmlspecialchars($owner['fullname']) ?></h1>
      <p class="username-tag">@<?= htmlspecialchars($owner['username']) ?></p>
      <?php if ($is_own_profile): ?>
        <a href="/socialnet/setting.php"
           class="btn btn-primary"
           style="display:inline-block;margin-top:.75rem;font-size:.85rem;padding:.45rem 1.1rem;border-radius:20px;text-decoration:none;"
           id="edit-profile-btn">
          ✏ Edit Profile
        </a>
      <?php else: ?>
        <span style="display:inline-block;margin-top:.75rem;font-size:.8rem;color:var(--muted);background:var(--surface);padding:.3rem .9rem;border-radius:20px;">
          Viewing another user's profile
        </span>
      <?php endif; ?>
    </div>
  </div>
</div>

<div class="card">
  <h2>About</h2>
  <?php if (!empty($owner['description'])): ?>
    <div class="description-box" id="profile-description">
      <?= htmlspecialchars($owner['description']) ?>
    </div>
  <?php else: ?>
    <p class="text-muted" id="profile-description-empty">
      <?= $is_own_profile
          ? 'You haven\'t written anything about yourself yet. <a href="/socialnet/setting.php" style="color:var(--accent);">Add a description →</a>'
          : htmlspecialchars($owner['fullname']) . ' hasn\'t written anything yet.' ?>
    </p>
  <?php endif; ?>
</div>

<?php page_footer(); ?>
