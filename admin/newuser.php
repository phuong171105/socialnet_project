<?php
// ============================================================
// Admin – New User Page
// URL: /admin/newuser.php
// ============================================================
require_once __DIR__ . '/../config/db.php';

$success = '';
$error   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username    = trim($_POST['username']    ?? '');
    $fullname    = trim($_POST['fullname']    ?? '');
    $password    = trim($_POST['password']    ?? '');
    $description = trim($_POST['description'] ?? '');

    // Basic validation
    if ($username === '' || $fullname === '' || $password === '') {
        $error = 'Username, Full Name, and Password are required.';
    } elseif (strlen($username) < 3 || strlen($username) > 50) {
        $error = 'Username must be between 3 and 50 characters.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        $error = 'Username may only contain letters, numbers, and underscores.';
    } else {
        $db = get_db();

        // Check for duplicate username
        $stmt = $db->prepare('SELECT id FROM account WHERE username = ?');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Username \"$username\" is already taken.";
        } else {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $ins  = $db->prepare('INSERT INTO account (username, fullname, password, description) VALUES (?, ?, ?, ?)');
            $ins->bind_param('ssss', $username, $fullname, $hash, $description);
            if ($ins->execute()) {
                $success = "User \"$username\" created successfully!";
                // Clear fields after success
                $username = $fullname = $description = '';
            } else {
                $error = 'Database error: ' . htmlspecialchars($db->error);
            }
            $ins->close();
        }
        $stmt->close();
        $db->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin – Create New User | SocialNet</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --bg:      #0f1117;
      --surface: #1a1d27;
      --card:    #22263a;
      --accent:  #f5a623;
      --text:    #e8eaf0;
      --muted:   #8891a8;
      --border:  #2e3348;
      --danger:  #ff4d6d;
      --success: #48cfad;
    }
    body {
      font-family: 'Inter', sans-serif;
      background: var(--bg); color: var(--text);
      min-height: 100vh;
      display: flex; flex-direction: column; align-items: center;
      justify-content: center; padding: 2rem 1rem;
    }
    .admin-badge {
      background: linear-gradient(135deg, #f5a623, #f7901e);
      color: #0f1117; font-size: .75rem; font-weight: 700;
      padding: .25rem .7rem; border-radius: 20px;
      text-transform: uppercase; letter-spacing: .08em;
      margin-bottom: .5rem; display: inline-block;
    }
    h1 {
      font-size: 1.8rem; font-weight: 700; margin-bottom: .25rem;
      background: linear-gradient(135deg, #f5a623, #e8eaf0);
      -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    }
    .sub { color: var(--muted); font-size: .9rem; margin-bottom: 2rem; }
    .box {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 2rem 2.25rem;
      width: 100%; max-width: 480px;
    }
    .form-group { margin-bottom: 1.1rem; }
    .form-group label { display: block; font-size: .82rem; font-weight: 500; color: var(--muted); margin-bottom: .4rem; }
    .form-group input[type="text"],
    .form-group input[type="password"],
    .form-group textarea {
      width: 100%; background: var(--surface);
      border: 1px solid var(--border); border-radius: 9px;
      padding: .65rem 1rem; color: var(--text);
      font-size: .95rem; font-family: inherit;
      outline: none; transition: border-color .2s, box-shadow .2s;
    }
    .form-group input:focus,
    .form-group textarea:focus {
      border-color: #f5a623;
      box-shadow: 0 0 0 3px rgba(245,166,35,.2);
    }
    .form-group textarea { resize: vertical; min-height: 90px; }
    .btn {
      width: 100%; padding: .75rem; border: none; border-radius: 9px;
      font-size: 1rem; font-weight: 600; font-family: inherit;
      cursor: pointer; transition: opacity .2s, transform .15s;
      background: linear-gradient(135deg, #f5a623, #f7901e);
      color: #0f1117;
    }
    .btn:hover { opacity: .88; transform: translateY(-1px); }
    .alert {
      border-radius: 9px; padding: .75rem 1rem;
      font-size: .88rem; margin-bottom: 1rem;
    }
    .alert-error   { background: rgba(255,77,109,.15); border: 1px solid rgba(255,77,109,.4); color: #ff9eb3; }
    .alert-success { background: rgba(72,207,173,.15); border: 1px solid rgba(72,207,173,.4); color: #7de8cc; }
    .back-link { margin-top: 1.5rem; font-size: .85rem; color: var(--muted); }
    .back-link a { color: #f5a623; text-decoration: none; }
  </style>
</head>
<body>
  <div style="text-align:center;">
    <span class="admin-badge">⚙ Admin Panel</span>
    <h1>Create New User</h1>
    <p class="sub">Add a new account to SocialNet</p>
  </div>

  <div class="box">
    <?php if ($error): ?>
      <div class="alert alert-error" id="msg-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
      <div class="alert alert-success" id="msg-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="POST" action="/admin/newuser.php" id="create-user-form">
      <div class="form-group">
        <label for="username">Username *</label>
        <input type="text" id="username" name="username"
               value="<?= htmlspecialchars($username ?? '') ?>"
               placeholder="e.g. john_doe" autocomplete="off" required />
      </div>
      <div class="form-group">
        <label for="fullname">Full Name *</label>
        <input type="text" id="fullname" name="fullname"
               value="<?= htmlspecialchars($fullname ?? '') ?>"
               placeholder="e.g. John Doe" required />
      </div>
      <div class="form-group">
        <label for="password">Password *</label>
        <input type="password" id="password" name="password"
               placeholder="Minimum 6 characters" required />
      </div>
      <div class="form-group">
        <label for="description">Profile Description (optional)</label>
        <textarea id="description" name="description"
                  placeholder="A short bio…"><?= htmlspecialchars($description ?? '') ?></textarea>
      </div>
      <button type="submit" class="btn" id="submit-btn">Create User</button>
    </form>
  </div>

  <p class="back-link">← Go to <a href="/socialnet/signin.php">Sign In</a></p>
</body>
</html>
