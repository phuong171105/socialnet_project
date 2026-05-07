<?php
// ============================================================
// Sign In Page
// URL: /socialnet/signin.php
// ============================================================
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/session.php';

// If already logged in, skip to home
if (is_logged_in()) {
    header('Location: /socialnet/index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $error = 'Please enter both username and password.';
    } else {
        $db   = get_db();
        $stmt = $db->prepare('SELECT id, username, fullname, password FROM account WHERE username = ?');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user   = $result->fetch_assoc();
        $stmt->close();
        $db->close();

        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['username']  = $user['username'];
            $_SESSION['fullname']  = $user['fullname'];
            header('Location: /socialnet/index.php');
            exit;
        } else {
            $error = 'Invalid username or password.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign In | SocialNet</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --bg:      #0f1117;
      --surface: #1a1d27;
      --card:    #22263a;
      --accent:  #6c63ff;
      --accent2: #48cfad;
      --text:    #e8eaf0;
      --muted:   #8891a8;
      --border:  #2e3348;
      --danger:  #ff4d6d;
    }
    body {
      font-family: 'Inter', sans-serif;
      background: var(--bg); color: var(--text);
      min-height: 100vh;
      display: flex; align-items: center; justify-content: center;
      padding: 1.5rem;
    }
    /* Animated gradient orbs background */
    body::before, body::after {
      content: '';
      position: fixed; border-radius: 50%;
      filter: blur(80px); opacity: .25; pointer-events: none;
    }
    body::before {
      width: 500px; height: 500px;
      background: var(--accent);
      top: -100px; left: -100px;
      animation: float1 8s ease-in-out infinite;
    }
    body::after {
      width: 400px; height: 400px;
      background: var(--accent2);
      bottom: -80px; right: -80px;
      animation: float2 10s ease-in-out infinite;
    }
    @keyframes float1 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(40px,40px)} }
    @keyframes float2 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-30px,-30px)} }

    .login-wrap {
      width: 100%; max-width: 420px;
      position: relative; z-index: 1;
    }
    .brand {
      text-align: center; margin-bottom: 2rem;
    }
    .brand .logo {
      font-size: 2.5rem; display: block; margin-bottom: .5rem;
      animation: pulse 2.5s ease-in-out infinite;
    }
    @keyframes pulse { 0%,100%{transform:scale(1)} 50%{transform:scale(1.08)} }
    .brand h1 {
      font-size: 2rem; font-weight: 700;
      background: linear-gradient(135deg, var(--accent), var(--accent2));
      -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    }
    .brand .tagline { color: var(--muted); font-size: .9rem; margin-top: .25rem; }
    .card {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 18px;
      padding: 2.25rem 2rem;
      backdrop-filter: blur(12px);
    }
    .form-group { margin-bottom: 1.1rem; }
    .form-group label { display: block; font-size: .82rem; font-weight: 500; color: var(--muted); margin-bottom: .4rem; }
    .form-group input {
      width: 100%; background: var(--surface);
      border: 1px solid var(--border); border-radius: 9px;
      padding: .7rem 1rem; color: var(--text);
      font-size: .95rem; font-family: inherit;
      outline: none; transition: border-color .2s, box-shadow .2s;
    }
    .form-group input:focus {
      border-color: var(--accent);
      box-shadow: 0 0 0 3px rgba(108,99,255,.2);
    }
    .btn {
      width: 100%; padding: .8rem; border: none; border-radius: 9px;
      font-size: 1rem; font-weight: 600; font-family: inherit;
      cursor: pointer; transition: opacity .2s, transform .15s;
      background: linear-gradient(135deg, var(--accent), #8b80ff);
      color: #fff; margin-top: .4rem;
    }
    .btn:hover { opacity: .88; transform: translateY(-1px); }
    .alert-error {
      background: rgba(255,77,109,.15); border: 1px solid rgba(255,77,109,.4);
      color: #ff9eb3; border-radius: 9px; padding: .7rem 1rem;
      font-size: .88rem; margin-bottom: 1rem;
    }
    .admin-link {
      text-align: center; margin-top: 1.25rem;
      font-size: .85rem; color: var(--muted);
    }
    .admin-link a { color: var(--accent); text-decoration: none; }
  </style>
</head>
<body>
  <div class="login-wrap">
    <div class="brand">
      <span class="logo">🌐</span>
      <h1>SocialNet</h1>
      <p class="tagline">Connect with the people around you</p>
    </div>

    <div class="card">
      <?php if ($error): ?>
        <div class="alert-error" id="signin-error"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form method="POST" action="/socialnet/signin.php" id="signin-form">
        <div class="form-group">
          <label for="s-username">Username</label>
          <input type="text" id="s-username" name="username"
                 value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
                 placeholder="Enter your username" autocomplete="username" required />
        </div>
        <div class="form-group">
          <label for="s-password">Password</label>
          <input type="password" id="s-password" name="password"
                 placeholder="Enter your password" autocomplete="current-password" required />
        </div>
        <button type="submit" class="btn" id="signin-submit">Sign In →</button>
      </form>

      <p class="admin-link">
        Admin? <a href="/admin/newuser.php" id="admin-link">Create a new user</a>
      </p>
    </div>
  </div>
</body>
</html>
