<?php
// ============================================================
// Setting Page
// URL: /socialnet/setting.php
// ============================================================
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/layout.php';

require_login();

$db     = get_db();
$me_id  = (int)$_SESSION['user_id'];

$success = '';
$error   = '';

// Fetch current data
$stmt = $db->prepare('SELECT username, fullname, description FROM account WHERE id = ?');
$stmt->bind_param('i', $me_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname    = trim($_POST['fullname']    ?? '');
    $description = trim($_POST['description'] ?? '');
    $new_pass    = trim($_POST['new_password'] ?? '');
    $cur_pass    = trim($_POST['current_password'] ?? '');

    if ($fullname === '') {
        $error = 'Full Name cannot be empty.';
    } else {
        // Validate current password before any change
        $stmt2 = $db->prepare('SELECT password FROM account WHERE id = ?');
        $stmt2->bind_param('i', $me_id);
        $stmt2->execute();
        $row = $stmt2->get_result()->fetch_assoc();
        $stmt2->close();

        if (!password_verify($cur_pass, $row['password'])) {
            $error = 'Current password is incorrect. No changes were saved.';
        } else {
            // Build update query dynamically
            if ($new_pass !== '') {
                if (strlen($new_pass) < 6) {
                    $error = 'New password must be at least 6 characters.';
                    goto done;
                }
                $hash = password_hash($new_pass, PASSWORD_BCRYPT);
                $upd  = $db->prepare('UPDATE account SET fullname=?, description=?, password=? WHERE id=?');
                $upd->bind_param('sssi', $fullname, $description, $hash, $me_id);
            } else {
                $upd = $db->prepare('UPDATE account SET fullname=?, description=? WHERE id=?');
                $upd->bind_param('ssi', $fullname, $description, $me_id);
            }

            if ($upd->execute()) {
                $_SESSION['fullname'] = $fullname;
                $user['fullname']     = $fullname;
                $user['description']  = $description;
                $success = 'Profile updated successfully!';
            } else {
                $error = 'Database error: ' . htmlspecialchars($db->error);
            }
            $upd->close();
        }
    }
}
done:
$db->close();

page_header('Settings', 'setting');
?>

<h1 class="page-title">⚙ Settings</h1>

<div class="card">
  <h2>Edit Profile</h2>

  <?php if ($error): ?>
    <div class="alert alert-error" id="setting-error"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>
  <?php if ($success): ?>
    <div class="alert alert-success" id="setting-success"><?= htmlspecialchars($success) ?></div>
  <?php endif; ?>

  <form method="POST" action="/socialnet/setting.php" id="setting-form">
    <div class="form-group">
      <label>Username (cannot be changed)</label>
      <input type="text" value="<?= htmlspecialchars($user['username']) ?>" disabled
             style="opacity:.6;cursor:not-allowed;" />
    </div>

    <div class="form-group">
      <label for="fullname">Full Name</label>
      <input type="text" id="fullname" name="fullname"
             value="<?= htmlspecialchars($user['fullname']) ?>"
             placeholder="Your full name" required />
    </div>

    <div class="form-group">
      <label for="description">Profile Description</label>
      <textarea id="description" name="description"
                placeholder="Tell people a bit about yourself…"><?= htmlspecialchars($user['description'] ?? '') ?></textarea>
    </div>

    <hr style="border-color:var(--border);margin:1.5rem 0;" />
    <p style="font-size:.85rem;color:var(--muted);margin-bottom:1rem;">
      Change password – leave "New Password" blank to keep current password.
    </p>

    <div class="form-group">
      <label for="new-password">New Password</label>
      <input type="password" id="new-password" name="new_password"
             placeholder="Minimum 6 characters (leave blank to keep)" />
    </div>

    <div class="form-group">
      <label for="current-password">Current Password <span style="color:var(--danger);">*</span></label>
      <input type="password" id="current-password" name="current_password"
             placeholder="Required to save any changes" required />
    </div>

    <button type="submit" class="btn btn-success" id="save-settings-btn">💾 Save Changes</button>
  </form>
</div>

<?php page_footer(); ?>
