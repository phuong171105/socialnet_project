<?php
// ============================================================
// About Page
// URL: /socialnet/about.php
// ============================================================
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/layout.php';

require_login();

page_header('About', 'about');
?>

<h1 class="page-title">About</h1>

<div class="card">
  <div class="about-box">
    <div style="font-size:4rem;margin-bottom:1rem;">🌐</div>
    <h1>SocialNet</h1>
    <p class="tagline">A lightweight social networking platform</p>

    <div style="margin:2rem 0;">
      <div class="info-item">
        <div class="label">Student Name</div>
        <div class="value">Nguyen Van Phuong</div>
      </div>
      <div class="info-item">
        <div class="label">Student Number</div>
        <div class="value">20225678</div>
      </div>
    </div>

    <div style="text-align:left;max-width:540px;margin:0 auto;">
      <div class="card" style="background:var(--surface);">
        <h2>Tech Stack</h2>
        <ul style="list-style:none;padding:0;line-height:2rem;">
          <li>🐘 <strong>PHP</strong> – Server-side logic (Native PHP, no frameworks)</li>
          <li>🐬 <strong>MySQL</strong> – Relational database (MariaDB compatible)</li>
          <li>🟩 <strong>Nginx</strong> – Web server &amp; reverse proxy</li>
          <li>🐧 <strong>Linux</strong> – Host operating system (Ubuntu)</li>
        </ul>
      </div>
    </div>

    <div style="text-align:left;max-width:540px;margin:1rem auto 0;">
      <div class="card" style="background:var(--surface);">
        <h2>Features</h2>
        <ul style="list-style:none;padding:0;line-height:2rem;">
          <li>✅ User account management (Admin panel)</li>
          <li>✅ Secure bcrypt password hashing</li>
          <li>✅ Session-based authentication</li>
          <li>✅ User profile with custom description</li>
          <li>✅ Browse other users on the network</li>
          <li>✅ Password change from Settings page</li>
          <li>✅ Responsive, modern dark-mode UI</li>
        </ul>
      </div>
    </div>
  </div>
</div>

<?php page_footer(); ?>
