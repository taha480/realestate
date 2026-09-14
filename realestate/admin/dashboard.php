<?php
/**
 * AURELIA | Luxury Real Estate & Architectural Construction
 * Executive Administration Dashboard
 */

declare(strict_types=1);

require_once __DIR__ . '/../includes/db-functions.php';

// Enforce authentication
requireAdminAuth();

$admin = $_SESSION['admin_user'];
$dbConnected = Database::isConnected();
$stats = getEnquiryStats();
$recentEnquiries = getRecentEnquiries(15);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Executive Dashboard | AURELIA Master Admin</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="../css/style.css">

  <style>
    body {
      background-color: var(--bg-primary);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    .admin-navbar {
      background: var(--bg-surface);
      border-bottom: 1px solid var(--border-subtle);
      padding: 18px 32px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: sticky;
      top: 0;
      z-index: 50;
    }
    .admin-brand {
      display: flex;
      align-items: center;
      gap: 12px;
    }
    .admin-user-group {
      display: flex;
      align-items: center;
      gap: 20px;
    }
    .role-badge {
      background: rgba(197, 168, 128, 0.15);
      border: 1px solid var(--border-gold);
      color: var(--accent-gold-light);
      padding: 3px 10px;
      font-size: 0.6875rem;
      text-transform: uppercase;
      letter-spacing: 0.15em;
      border-radius: 2px;
    }
    .admin-content-area {
      flex: 1;
      padding: 48px 0;
    }
    .kpi-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 24px;
      margin-bottom: 36px;
    }
    .kpi-card {
      background: var(--bg-surface);
      border: 1px solid var(--border-subtle);
      padding: 24px 28px;
      border-radius: 2px;
      position: relative;
    }
    .kpi-title {
      font-size: 0.75rem;
      text-transform: uppercase;
      letter-spacing: 0.16em;
      color: var(--text-muted);
      margin-bottom: 8px;
    }
    .kpi-num {
      font-family: var(--font-serif);
      font-size: 2.5rem;
      font-weight: 700;
      color: #ffffff;
      line-height: 1;
    }
    .kpi-sub {
      font-size: 0.75rem;
      color: var(--text-dim);
      margin-top: 6px;
    }
    .db-status-bar {
      padding: 14px 20px;
      border-radius: 2px;
      margin-bottom: 32px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      font-size: 0.8125rem;
    }
    .db-status-connected {
      background: rgba(16, 185, 129, 0.1);
      border: 1px solid rgba(16, 185, 129, 0.3);
      color: #6ee7b7;
    }
    .db-status-disconnected {
      background: rgba(245, 158, 11, 0.1);
      border: 1px solid rgba(245, 158, 11, 0.3);
      color: #fcd34d;
    }
    .data-table-card {
      background: var(--bg-surface);
      border: 1px solid var(--border-subtle);
      border-radius: 2px;
      overflow: hidden;
      margin-bottom: 48px;
    }
    .table-header-bar {
      padding: 24px 28px;
      border-bottom: 1px solid var(--border-subtle);
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .table-responsive {
      width: 100%;
      overflow-x: auto;
    }
    table.luxury-table {
      width: 100%;
      border-collapse: collapse;
      text-align: left;
      font-size: 0.84375rem;
    }
    table.luxury-table th {
      background: var(--bg-secondary);
      padding: 14px 24px;
      font-size: 0.6875rem;
      text-transform: uppercase;
      letter-spacing: 0.15em;
      color: var(--text-muted);
      border-bottom: 1px solid var(--border-subtle);
    }
    table.luxury-table td {
      padding: 18px 24px;
      border-bottom: 1px solid var(--border-subtle);
      color: #e2e0d8;
    }
    table.luxury-table tr:hover td {
      background: rgba(255, 255, 255, 0.02);
    }
    .status-pill {
      display: inline-block;
      padding: 3px 10px;
      border-radius: 2px;
      font-size: 0.6875rem;
      text-transform: uppercase;
      letter-spacing: 0.12em;
      font-weight: 600;
    }
    .status-new {
      background: rgba(59, 130, 246, 0.15);
      color: #93c5fd;
      border: 1px solid rgba(59, 130, 246, 0.3);
    }
    .status-in_review {
      background: rgba(245, 158, 11, 0.15);
      color: #fcd34d;
      border: 1px solid rgba(245, 158, 11, 0.3);
    }
    .status-contacted {
      background: rgba(16, 185, 129, 0.15);
      color: #6ee7b7;
      border: 1px solid rgba(16, 185, 129, 0.3);
    }
    .status-closed {
      background: rgba(107, 114, 128, 0.2);
      color: #9ca3af;
      border: 1px solid rgba(107, 114, 128, 0.3);
    }
    @media (max-width: 1024px) {
      .kpi-grid {
        grid-template-columns: repeat(2, 1fr);
      }
    }
    @media (max-width: 640px) {
      .kpi-grid {
        grid-template-columns: 1fr;
      }
      .admin-navbar {
        padding: 16px;
      }
    }
  </style>
</head>
<body>

  <!-- Top Executive Navigation -->
  <header class="admin-navbar">
    <div class="admin-brand">
      <div class="logo-monogram" style="width: 34px; height: 34px;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
          <polygon points="12 2 2 22 22 22 12 2" />
          <polygon points="12 8 6 19 18 19 12 8" />
        </svg>
      </div>
      <div>
        <span class="logo-name" style="font-size: 1.15rem;">AURELIA</span>
        <span class="logo-tagline" style="font-size: 0.5rem;">Executive Control Center</span>
      </div>
    </div>

    <div class="admin-user-group">
      <div style="text-align: right; display: flex; align-items: center; gap: 10px;">
        <div>
          <div style="font-size: 0.8125rem; font-weight: 600; color: #fff;"><?php echo e($admin['name']); ?></div>
          <div style="font-size: 0.6875rem; color: var(--text-dim);"><?php echo e($admin['email']); ?></div>
        </div>
        <span class="role-badge"><?php echo e($admin['role'] ?? 'Admin'); ?></span>
      </div>

      <a href="../index.php" target="_blank" class="btn btn-outline" style="padding: 8px 16px; font-size: 0.75rem;">
        <span>View Website</span>
      </a>

      <a href="logout.php" class="btn btn-outline-gold" style="padding: 8px 16px; font-size: 0.75rem;">
        <span>Sign Out</span>
      </a>
    </div>
  </header>

  <!-- Dashboard Main Area -->
  <main class="admin-content-area">
    <div class="container">
      
      <!-- DB Status Banner -->
      <?php if ($dbConnected): ?>
        <div class="db-status-bar db-status-connected">
          <div style="display: flex; align-items: center; gap: 8px;">
            <span style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background-color: #10b981;"></span>
            <span><strong>MySQL Database Connected:</strong> Successfully linked to <code>aurelia_db</code> via PDO utf8mb4.</span>
          </div>
          <span style="font-family: monospace; font-size: 0.75rem;">HOST: localhost:3306</span>
        </div>
      <?php else: ?>
        <div class="db-status-bar db-status-disconnected">
          <div style="display: flex; align-items: center; gap: 8px;">
            <span style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background-color: #f59e0b;"></span>
            <span><strong>Notice:</strong> MySQL connection is offline. Start MySQL in XAMPP and import <code>database/database.sql</code> into phpMyAdmin.</span>
          </div>
          <span style="font-family: monospace; font-size: 0.75rem;">PORT: 3306 (Awaiting MySQL)</span>
        </div>
      <?php endif; ?>

      <!-- Executive KPI Cards -->
      <div class="kpi-grid">
        <div class="kpi-card">
          <div class="kpi-title">Total Inquiries</div>
          <div class="kpi-num"><?php echo (int) $stats['total']; ?></div>
          <div class="kpi-sub">Client dossiers received</div>
        </div>

        <div class="kpi-card">
          <div class="kpi-title">New / Unread</div>
          <div class="kpi-num" style="color: var(--accent-gold-light);"><?php echo (int) $stats['new']; ?></div>
          <div class="kpi-sub">Awaiting executive briefing</div>
        </div>

        <div class="kpi-card">
          <div class="kpi-title">In Review</div>
          <div class="kpi-num"><?php echo (int) $stats['in_review']; ?></div>
          <div class="kpi-sub">Architectural feasibility study</div>
        </div>

        <div class="kpi-card">
          <div class="kpi-title">Contacted / Scheduled</div>
          <div class="kpi-num"><?php echo (int) $stats['contacted']; ?></div>
          <div class="kpi-sub">Private consultation active</div>
        </div>
      </div>

      <!-- Recent Enquiries Table -->
      <div class="data-table-card">
        <div class="table-header-bar">
          <div>
            <h2 style="font-size: 1.35rem; margin-bottom: 4px;">Recent Client Briefings &amp; Inquiries</h2>
            <p style="font-size: 0.8125rem;">Submissions from contact.php and consultation CTAs</p>
          </div>
          <span style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.15em; color: var(--accent-gold);">
            Audited Logs
          </span>
        </div>

        <div class="table-responsive">
          <table class="luxury-table">
            <thead>
              <tr>
                <th>Reference ID</th>
                <th>Client Name</th>
                <th>Contact</th>
                <th>Desired Service</th>
                <th>Location / Budget</th>
                <th>Status</th>
                <th>Date Received</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($recentEnquiries)): ?>
                <tr>
                  <td colspan="7" style="text-align: center; padding: 48px; color: var(--text-dim);">
                    <div style="font-size: 1.1rem; margin-bottom: 6px; color: var(--text-muted);">No client inquiries stored yet.</div>
                    <div style="font-size: 0.8125rem;">Submit an inquiry via <a href="../contact.php" target="_blank" style="color: var(--accent-gold-light); text-decoration: underline;">contact.php</a> to test the live database pipeline.</div>
                  </td>
                </tr>
              <?php else: ?>
                <?php foreach ($recentEnquiries as $enq): ?>
                  <tr>
                    <td>
                      <strong style="font-family: monospace; color: var(--accent-gold-light);">
                        <?php echo e($enq['reference_id']); ?>
                      </strong>
                    </td>
                    <td>
                      <div style="font-weight: 600; color: #fff;"><?php echo e($enq['name']); ?></div>
                      <div style="font-size: 0.75rem; color: var(--text-dim);"><?php echo e($enq['ip_address'] ?? '—'); ?></div>
                    </td>
                    <td>
                      <div><a href="mailto:<?php echo e($enq['email']); ?>" style="color: #c9c7c0;"><?php echo e($enq['email']); ?></a></div>
                      <div style="font-size: 0.75rem; color: var(--text-dim);"><?php echo e($enq['phone']); ?></div>
                    </td>
                    <td>
                      <div style="color: #fff; font-weight: 500;"><?php echo e($enq['subject']); ?></div>
                      <div style="font-size: 0.75rem; color: var(--text-muted); max-width: 280px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                        <?php echo e($enq['message']); ?>
                      </div>
                    </td>
                    <td>
                      <div><?php echo e($enq['target_location'] ?: 'Not specified'); ?></div>
                      <div style="font-size: 0.75rem; color: var(--accent-gold);"><?php echo e($enq['budget_range'] ?: 'Standard'); ?></div>
                    </td>
                    <td>
                      <?php 
                        $statusClass = 'status-new';
                        if ($enq['status'] === 'in_review') $statusClass = 'status-in_review';
                        if ($enq['status'] === 'contacted') $statusClass = 'status-contacted';
                        if ($enq['status'] === 'closed') $statusClass = 'status-closed';
                      ?>
                      <span class="status-pill <?php echo $statusClass; ?>">
                        <?php echo e(str_replace('_', ' ', $enq['status'])); ?>
                      </span>
                    </td>
                    <td style="font-size: 0.75rem; color: var(--text-dim); font-family: monospace;">
                      <?php echo e(date('M d, Y H:i', strtotime($enq['created_at']))); ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Database & System Architectural Overview -->
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 32px;">
        <div style="background: var(--bg-surface); border: 1px solid var(--border-subtle); padding: 32px; border-radius: 2px;">
          <h3 style="font-size: 1.15rem; margin-bottom: 12px; color: #fff;">MySQL Schema Entities</h3>
          <p style="font-size: 0.84375rem; color: var(--text-muted); margin-bottom: 16px;">
            The <code>database/database.sql</code> file provisions 9 normalized tables:
          </p>
          <ul style="font-size: 0.8125rem; color: #c9c7c0; display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
            <li>&bull; <code>admins</code></li>
            <li>&bull; <code>projects</code></li>
            <li>&bull; <code>project_images</code></li>
            <li>&bull; <code>properties</code></li>
            <li>&bull; <code>property_images</code></li>
            <li>&bull; <code>services</code></li>
            <li>&bull; <code>enquiries</code></li>
            <li>&bull; <code>testimonials</code></li>
            <li>&bull; <code>site_settings</code></li>
          </ul>
        </div>

        <div style="background: var(--bg-surface); border: 1px solid var(--border-subtle); padding: 32px; border-radius: 2px;">
          <h3 style="font-size: 1.15rem; margin-bottom: 12px; color: #fff;">phpMyAdmin Integration</h3>
          <p style="font-size: 0.84375rem; color: var(--text-muted); margin-bottom: 12px;">
            To manage records directly via phpMyAdmin:
          </p>
          <ol style="font-size: 0.8125rem; color: #c9c7c0; display: flex; flex-direction: column; gap: 6px; padding-left: 18px;">
            <li>1. Start <strong>Apache</strong> and <strong>MySQL</strong> in the XAMPP Control Panel.</li>
            <li>2. Navigate to <code>http://localhost/phpmyadmin</code> in your browser.</li>
            <li>3. Click <strong>Import</strong> and select <code>D:\Website\database\database.sql</code>.</li>
            <li>4. Click <strong>Go</strong> to instantiate the database.</li>
          </ol>
        </div>
      </div>

    </div>
  </main>

  <footer style="background: #08090c; border-top: 1px solid var(--border-subtle); padding: 24px 0; text-align: center; font-size: 0.75rem; color: var(--text-dim);">
    &copy; <?php echo date('Y'); ?> AURELIA Master Real Estate & Construction Group. All administrative actions logged.
  </footer>

</body>
</html>
