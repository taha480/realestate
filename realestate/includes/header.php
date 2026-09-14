<?php
/**
 * AURELIA | Luxury Real Estate & Construction
 * Reusable Header Component
 *
 * @var string|null $pageTitle
 * @var string|null $currentPage
 * @var string|null $metaDescription
 */

$title = isset($pageTitle) && !empty($pageTitle) 
    ? $pageTitle . ' | AURELIA Master Real Estate & Construction' 
    : 'AURELIA | Luxury Real Estate & Architectural Construction';

$metaDesc = isset($metaDescription) && !empty($metaDescription)
    ? $metaDescription
    : 'AURELIA — Premium real estate development and end-to-end master construction solutions built around quality, precision and trust.';

$current = isset($currentPage) ? $currentPage : 'home';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?php echo htmlspecialchars($metaDesc, ENT_QUOTES, 'UTF-8'); ?>">
  <title><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></title>

  <!-- Google Fonts: Cormorant Garamond, Playfair Display, Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- Main Design System CSS -->
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

  <!-- Site Header -->
  <header class="site-header" role="banner">
    <div class="container header-container">
      
      <!-- Brand Logo -->
      <a href="index.php" class="brand-logo" aria-label="Aurelia Real Estate & Construction Home">
        <div class="logo-monogram" aria-hidden="true">
          <!-- Architectural Monogram Vector -->
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="square">
            <polygon points="12 2 2 22 22 22 12 2" />
            <polygon points="12 8 6 19 18 19 12 8" />
          </svg>
        </div>
        <div class="logo-text-group">
          <span class="logo-name">AURELIA</span>
          <span class="logo-tagline">Estates &bull; Construction</span>
        </div>
      </a>

      <!-- Desktop Navigation Menu -->
      <nav class="main-nav" role="navigation" aria-label="Primary Navigation">
        <a href="index.php" class="nav-link <?php echo $current === 'home' ? 'active' : ''; ?>">Home</a>
        <a href="about.php" class="nav-link <?php echo $current === 'about' ? 'active' : ''; ?>">About</a>
        <a href="services.php" class="nav-link <?php echo $current === 'services' ? 'active' : ''; ?>">Services</a>
        <a href="projects.php" class="nav-link <?php echo $current === 'projects' ? 'active' : ''; ?>">Projects</a>
        <a href="properties.php" class="nav-link <?php echo $current === 'properties' ? 'active' : ''; ?>">Properties</a>
        <a href="contact.php" class="nav-link <?php echo $current === 'contact' ? 'active' : ''; ?>">Contact</a>
      </nav>

      <!-- Header Action -->
      <div class="header-action-group">
        <a href="contact.php" class="btn btn-primary header-cta">
          <span>Start a Project</span>
        </a>

        <!-- Mobile Menu Toggle Button -->
        <button class="mobile-toggle" aria-label="Open Navigation Menu" aria-expanded="false" aria-controls="mobile-nav">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
            <line x1="3" y1="7" x2="21" y2="7" />
            <line x1="8" y1="12" x2="21" y2="12" />
            <line x1="3" y1="17" x2="21" y2="17" />
          </svg>
        </button>
      </div>

    </div>
  </header>

  <!-- Mobile Navigation Drawer Backdrop -->
  <div class="mobile-drawer-backdrop" aria-hidden="true"></div>

  <!-- Mobile Navigation Drawer -->
  <div class="mobile-nav-drawer" id="mobile-nav" role="dialog" aria-modal="true" aria-label="Mobile Navigation">
    <div class="mobile-drawer-header">
      <div class="logo-text-group">
        <span class="logo-name">AURELIA</span>
        <span class="logo-tagline">Estates &bull; Construction</span>
      </div>
      <button class="mobile-close-btn" aria-label="Close Navigation Menu">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <line x1="18" y1="6" x2="6" y2="18" />
          <line x1="6" y1="6" x2="18" y2="18" />
        </svg>
      </button>
    </div>

    <nav class="mobile-nav-links">
      <a href="index.php" class="<?php echo $current === 'home' ? 'active' : ''; ?>">Home</a>
      <a href="about.php" class="<?php echo $current === 'about' ? 'active' : ''; ?>">About</a>
      <a href="services.php" class="<?php echo $current === 'services' ? 'active' : ''; ?>">Services</a>
      <a href="projects.php" class="<?php echo $current === 'projects' ? 'active' : ''; ?>">Projects</a>
      <a href="properties.php" class="<?php echo $current === 'properties' ? 'active' : ''; ?>">Properties</a>
      <a href="contact.php" class="<?php echo $current === 'contact' ? 'active' : ''; ?>">Contact</a>
    </nav>

    <div class="mobile-drawer-footer">
      <a href="contact.php" class="btn btn-primary" style="width: 100%; text-align: center;">
        <span>Start a Project</span>
      </a>
      <p style="font-size: 0.75rem; color: var(--text-dim); margin-top: 16px; text-align: center;">
        Private Advisory: +1 (800) 892-0199
      </p>
    </div>
  </div>

  <main id="main-content">
