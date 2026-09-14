<?php
/**
 * AURELIA | Luxury Real Estate & Architectural Construction
 * Admin Authentication — Login
 */

declare(strict_types=1);

require_once __DIR__ . '/../includes/db-functions.php';

startSecureSession();

// Redirect if already authenticated
if (isAdminLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}

$errorMessage = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submittedToken = $_POST['csrf_token'] ?? null;

    if (!validateCsrfToken($submittedToken)) {
        $errorMessage = 'Security validation failed (Invalid CSRF token). Please refresh and try again.';
    } else {
        $email    = cleanInput($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            $errorMessage = 'Please provide both email and password.';
        } else {
            $admin = authenticateAdmin($email, $password);

            if ($admin) {
                // Regenerate session ID to prevent session fixation attacks
                session_regenerate_id(true);
                $_SESSION['admin_user'] = $admin;
                header('Location: dashboard.php');
                exit;
            } else {
                $errorMessage = 'Invalid email or password credentials.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Portal Login | AURELIA</title>
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  
  <link rel="stylesheet" href="../css/style.css">
  
  <style>
    .admin-login-wrapper {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 32px 16px;
      background: radial-gradient(circle at center, #181a23 0%, #0d0e12 100%);
    }
    .admin-login-card {
      width: 100%;
      max-width: 440px;
      background: var(--bg-surface);
      border: 1px solid var(--border-gold);
      padding: 48px 40px;
      border-radius: 2px;
      box-shadow: 0 25px 60px rgba(0, 0, 0, 0.7);
    }
    .admin-logo-center {
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-bottom: 32px;
      text-align: center;
    }
    .form-group {
      margin-bottom: 20px;
    }
    .form-label {
      display: block;
      font-size: 0.75rem;
      text-transform: uppercase;
      letter-spacing: 0.15em;
      color: var(--text-muted);
      margin-bottom: 8px;
    }
    .form-control {
      width: 100%;
      background: var(--bg-secondary);
      border: 1px solid var(--border-subtle);
      padding: 14px 16px;
      font-size: 0.9375rem;
      color: #ffffff;
      border-radius: 2px;
      transition: var(--transition-fast);
    }
    .form-control:focus {
      outline: none;
      border-color: var(--accent-gold);
      background: var(--bg-surface-elevated);
    }
    .alert-error {
      background: rgba(220, 38, 38, 0.15);
      border: 1px solid rgba(220, 38, 38, 0.4);
      color: #fca5a5;
      padding: 12px 16px;
      font-size: 0.8125rem;
      margin-bottom: 24px;
      border-radius: 2px;
    }
    .admin-back-link {
      display: block;
      text-align: center;
      margin-top: 24px;
      font-size: 0.75rem;
      color: var(--text-dim);
      text-transform: uppercase;
      letter-spacing: 0.12em;
    }
    .admin-back-link:hover {
      color: var(--accent-gold);
    }
  </style>
</head>
<body>

  <div class="admin-login-wrapper">
    <div class="admin-login-card">
      
      <div class="admin-logo-center">
        <div class="logo-monogram" style="width: 44px; height: 44px; margin-bottom: 12px;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
            <polygon points="12 2 2 22 22 22 12 2" />
            <polygon points="12 8 6 19 18 19 12 8" />
          </svg>
        </div>
        <div class="logo-name" style="font-size: 1.5rem;">AURELIA</div>
        <div class="logo-tagline" style="font-size: 0.625rem;">Executive Administration Portal</div>
      </div>

      <?php if ($errorMessage): ?>
        <div class="alert-error" role="alert">
          <?php echo e($errorMessage); ?>
        </div>
      <?php endif; ?>

      <form action="login.php" method="POST">
        <?php echo csrfField(); ?>

        <div class="form-group">
          <label class="form-label" for="email">Administrator Email</label>
          <input 
            type="email" 
            id="email" 
            name="email" 
            class="form-control" 
            value="<?php echo e($_POST['email'] ?? 'admin@aurelia.com'); ?>" 
            required 
            autocomplete="email"
          >
        </div>

        <div class="form-group">
          <label class="form-label" for="password">Password</label>
          <input 
            type="password" 
            id="password" 
            name="password" 
            class="form-control" 
            required 
            autocomplete="current-password"
            placeholder="••••••••••••"
          >
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 12px;">
          <span>Access Dashboard</span>
        </button>
      </form>

      <div style="margin-top: 24px; padding-top: 16px; border-top: 1px solid var(--border-subtle); text-align: center; font-size: 0.75rem; color: var(--text-dim);">
        Default demo login: <strong style="color: var(--accent-gold-light);">admin@aurelia.com</strong><br>
        Password: <strong style="color: var(--accent-gold-light);">Admin@Aurelia2026!</strong>
      </div>

      <a href="../index.php" class="admin-back-link">&larr; Return to Public Website</a>

    </div>
  </div>

</body>
</html>
