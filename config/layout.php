<?php
// ----------------------------------------------------------------
// Shared HTML helpers – header, footer, and menu bar
// ----------------------------------------------------------------

/**
 * Renders the opening HTML, <head>, and opens <body>.
 * $title  – page <title> text
 * $active – which nav link is "active" (home|setting|profile|about|signout)
 */
function page_header(string $title, string $active = ''): void
{
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= htmlspecialchars($title) ?> – SocialNet</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <style>
    /* ── Reset & base ─────────────────────────────────── */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --bg:        #0f1117;
      --surface:   #1a1d27;
      --card:      #22263a;
      --accent:    #6c63ff;
      --accent2:   #48cfad;
      --text:      #e8eaf0;
      --muted:     #8891a8;
      --border:    #2e3348;
      --danger:    #ff4d6d;
      --radius:    14px;
      --nav-h:     64px;
    }
    html { scroll-behavior: smooth; }
    body {
      font-family: 'Inter', sans-serif;
      background: var(--bg);
      color: var(--text);
      min-height: 100vh;
    }

    /* ── Navbar ─────────────────────────────────────────── */
    nav.topnav {
      position: sticky; top: 0; z-index: 100;
      height: var(--nav-h);
      background: rgba(26,29,39,.85);
      backdrop-filter: blur(16px);
      border-bottom: 1px solid var(--border);
      display: flex; align-items: center;
      padding: 0 2rem; gap: 1.5rem;
    }
    nav.topnav .brand {
      font-size: 1.3rem; font-weight: 700;
      background: linear-gradient(135deg, var(--accent), var(--accent2));
      -webkit-background-clip: text; -webkit-text-fill-color: transparent;
      margin-right: auto; text-decoration: none;
    }
    nav.topnav a.nav-link {
      font-size: .9rem; font-weight: 500;
      color: var(--muted); text-decoration: none;
      padding: .4rem .85rem; border-radius: 8px;
      transition: background .2s, color .2s;
    }
    nav.topnav a.nav-link:hover   { background: rgba(108,99,255,.15); color: var(--text); }
    nav.topnav a.nav-link.active  { background: rgba(108,99,255,.25); color: var(--accent); }
    nav.topnav a.nav-link.signout { color: var(--danger); }
    nav.topnav a.nav-link.signout:hover { background: rgba(255,77,109,.15); color: var(--danger); }

    /* ── Main content wrapper ────────────────────────── */
    .page-wrap {
      max-width: 960px;
      margin: 2.5rem auto;
      padding: 0 1.25rem;
    }

    /* ── Cards ──────────────────────────────────────── */
    .card {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      padding: 1.75rem 2rem;
      margin-bottom: 1.5rem;
    }
    .card h2 {
      font-size: 1.1rem; font-weight: 600;
      color: var(--accent); margin-bottom: 1rem;
      text-transform: uppercase; letter-spacing: .05em;
    }

    /* ── Forms ──────────────────────────────────────── */
    .form-group { margin-bottom: 1.1rem; }
    .form-group label {
      display: block; font-size: .82rem; font-weight: 500;
      color: var(--muted); margin-bottom: .4rem;
    }
    .form-group input[type="text"],
    .form-group input[type="password"],
    .form-group textarea {
      width: 100%;
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 9px;
      padding: .65rem 1rem;
      color: var(--text);
      font-size: .95rem;
      font-family: inherit;
      transition: border-color .2s, box-shadow .2s;
      outline: none;
    }
    .form-group input:focus,
    .form-group textarea:focus {
      border-color: var(--accent);
      box-shadow: 0 0 0 3px rgba(108,99,255,.2);
    }
    .form-group textarea { resize: vertical; min-height: 110px; }

    /* ── Buttons ─────────────────────────────────────── */
    .btn {
      display: inline-block; cursor: pointer;
      font-size: .9rem; font-weight: 600; font-family: inherit;
      padding: .65rem 1.6rem; border-radius: 9px; border: none;
      transition: opacity .2s, transform .15s;
    }
    .btn:hover  { opacity: .88; transform: translateY(-1px); }
    .btn:active { transform: translateY(0); }
    .btn-primary  { background: linear-gradient(135deg, var(--accent), #8b80ff); color: #fff; }
    .btn-success  { background: linear-gradient(135deg, var(--accent2), #36b89c); color: #fff; }
    .btn-danger   { background: linear-gradient(135deg, var(--danger), #e8305e); color: #fff; }

    /* ── Alert messages ──────────────────────────────── */
    .alert {
      border-radius: 9px; padding: .75rem 1.1rem;
      font-size: .9rem; margin-bottom: 1rem;
    }
    .alert-error   { background: rgba(255,77,109,.15); border: 1px solid rgba(255,77,109,.4); color: #ff9eb3; }
    .alert-success { background: rgba(72,207,173,.15); border: 1px solid rgba(72,207,173,.4); color: #7de8cc; }
    .alert-info    { background: rgba(108,99,255,.15); border: 1px solid rgba(108,99,255,.4); color: #b3adff; }

    /* ── User list / grid ────────────────────────────── */
    .user-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: 1rem;
    }
    .user-card {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      padding: 1.2rem 1rem;
      text-align: center;
      transition: border-color .2s, transform .2s;
    }
    .user-card:hover { border-color: var(--accent); transform: translateY(-3px); }
    .user-card .avatar {
      width: 60px; height: 60px; border-radius: 50%;
      background: linear-gradient(135deg, var(--accent), var(--accent2));
      display: flex; align-items: center; justify-content: center;
      font-size: 1.5rem; font-weight: 700;
      margin: 0 auto .75rem;
      color: #fff;
    }
    .user-card .uname { font-weight: 600; font-size: .95rem; }
    .user-card .fname { font-size: .82rem; color: var(--muted); margin: .2rem 0 .75rem; }
    .user-card a.view-btn {
      font-size: .8rem; font-weight: 600;
      background: rgba(108,99,255,.2); color: var(--accent);
      text-decoration: none; padding: .35rem .9rem;
      border-radius: 20px; transition: background .2s;
    }
    .user-card a.view-btn:hover { background: rgba(108,99,255,.4); }

    /* ── Profile header ──────────────────────────────── */
    .profile-hero {
      display: flex; align-items: center; gap: 1.5rem;
      margin-bottom: 1.5rem;
    }
    .profile-hero .avatar-lg {
      width: 90px; height: 90px; border-radius: 50%;
      background: linear-gradient(135deg, var(--accent), var(--accent2));
      display: flex; align-items: center; justify-content: center;
      font-size: 2.5rem; font-weight: 700; color: #fff;
      flex-shrink: 0;
    }
    .profile-hero .info h1 { font-size: 1.5rem; font-weight: 700; }
    .profile-hero .info .username-tag {
      font-size: .9rem; color: var(--muted);
    }

    /* ── About page ──────────────────────────────────── */
    .about-box { text-align: center; padding: 2rem 0; }
    .about-box h1 { font-size: 2rem; font-weight: 700; margin-bottom: .5rem; }
    .about-box .tagline { color: var(--muted); margin-bottom: 2rem; }
    .about-box .info-item {
      background: var(--surface); border: 1px solid var(--border);
      border-radius: var(--radius); display: inline-block;
      padding: 1rem 2rem; margin: .4rem; min-width: 220px;
    }
    .about-box .info-item .label { font-size: .8rem; color: var(--muted); text-transform: uppercase; letter-spacing: .05em; }
    .about-box .info-item .value { font-size: 1.1rem; font-weight: 600; margin-top: .25rem; }

    /* ── Page title ──────────────────────────────────── */
    .page-title {
      font-size: 1.6rem; font-weight: 700;
      margin-bottom: 1.5rem;
      background: linear-gradient(135deg, var(--text), var(--muted));
      -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    }

    /* ── Utility ─────────────────────────────────────── */
    .text-muted   { color: var(--muted); }
    .mt-1 { margin-top: .5rem; }
    .mt-2 { margin-top: 1rem; }
    .description-box {
      background: var(--surface);
      border-radius: 9px;
      padding: 1rem 1.25rem;
      line-height: 1.7;
      white-space: pre-wrap;
      border: 1px solid var(--border);
      min-height: 60px;
    }

    /* Responsive */
    @media (max-width: 600px) {
      nav.topnav { gap: .8rem; padding: 0 1rem; }
      nav.topnav .brand { font-size: 1.1rem; }
      nav.topnav a.nav-link { padding: .35rem .55rem; font-size: .82rem; }
      .page-wrap { margin: 1.5rem auto; }
      .card { padding: 1.25rem; }
      .profile-hero { flex-direction: column; text-align: center; }
    }
  </style>
</head>
<body>
<?php
    $nav_items = [
        'home'    => ['/socialnet/index.php',   'Home'],
        'setting' => ['/socialnet/setting.php',  'Setting'],
        'profile' => ['/socialnet/profile.php',  'Profile'],
        'about'   => ['/socialnet/about.php',    'About'],
        'signout' => ['/socialnet/signout.php',  'Sign Out'],
    ];
    echo '<nav class="topnav">';
    echo '<a class="brand" href="/socialnet/index.php">🌐 SocialNet</a>';
    foreach ($nav_items as $key => [$url, $label]) {
        $cls = 'nav-link';
        if ($key === $active) $cls .= ' active';
        if ($key === 'signout') $cls .= ' signout';
        echo '<a class="' . $cls . '" href="' . $url . '">' . $label . '</a>';
    }
    echo '</nav>';
    echo '<div class="page-wrap">';
}

/**
 * Closes the page layout.
 */
function page_footer(): void
{
    echo '</div>'; // .page-wrap
    ?>
  <footer style="text-align:center;padding:2rem;color:var(--muted);font-size:.8rem;">
    &copy; <?= date('Y') ?> SocialNet &mdash; All rights reserved.
  </footer>
</body>
</html>
<?php
}
