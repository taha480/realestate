<?php
/**
 * AURELIA | Luxury Real Estate & Architectural Construction
 * Projects Listing Page
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/db-functions.php';

$pageTitle = 'Featured Construction Projects';
$currentPage = 'projects';
$metaDescription = 'Explore AURELIA\'s curated portfolio of completed and active architectural construction projects across prime global locations.';

$projects = getAllProjects();

include 'includes/header.php';
?>

<!-- Page Hero -->
<div class="page-banner">
  <div class="container">
    <div class="breadcrumb">
      <a href="index.php">Home</a>
      <span>/</span>
      <span>Projects</span>
    </div>
    <h1>Featured <span class="gold-gradient-text">Projects</span></h1>
    <p style="max-width: 600px;">
      A curated portfolio of our recently completed and active construction developments across prime global locations.
    </p>
  </div>
</div>

<!-- Projects Listing -->
<section class="section section-dark" aria-label="All Construction Projects">
  <div class="container">

    <?php if (empty($projects)): ?>
      <div class="not-found-box">
        <h2 style="margin-bottom: 12px;">Portfolio Temporarily Unavailable</h2>
        <p style="color: var(--text-muted); margin-bottom: 24px;">
          Our project registry is being updated. Please contact our Private Advisory team for the current portfolio.
        </p>
        <a href="contact.php" class="btn btn-primary"><span>Contact Advisory</span></a>
      </div>
    <?php else: ?>
      <div class="projects-grid">

        <?php foreach ($projects as $project): ?>
          <a class="project-card" href="project-detail.php?id=<?php echo (int) $project['id']; ?>" aria-label="View project details for <?php echo e($project['title']); ?>">
            <div class="project-thumb">
              <?php if (!empty($project['category'])): ?>
                <span class="project-category-badge"><?php echo e($project['category']); ?></span>
              <?php endif; ?>
              <img
                src="<?php echo e($project['featured_image']); ?>"
                alt="<?php echo e($project['title'] . ' in ' . $project['location']); ?>"
                loading="lazy"
              >
            </div>
            <div class="project-details">
              <div class="project-meta-row">
                <span class="project-location"><?php echo e($project['location']); ?></span>
                <span><?php echo e($project['status']); ?><?php echo !empty($project['completion_date']) ? ' · ' . e($project['completion_date']) : ''; ?></span>
              </div>
              <h3 class="project-title"><?php echo e($project['title']); ?></h3>
              <p class="project-desc"><?php echo e($project['short_description']); ?></p>
              <div class="project-specs">
                <?php if (!empty($project['area'])): ?>
                  <div class="spec-item">Area: <span><?php echo e($project['area']); ?></span></div>
                <?php endif; ?>
                <?php if (!empty($project['category'])): ?>
                  <div class="spec-item">Scope: <span><?php echo e($project['category']); ?></span></div>
                <?php endif; ?>
              </div>
            </div>
          </a>
        <?php endforeach; ?>

      </div>
    <?php endif; ?>

  </div>
</section>

<!-- CTA -->
<section class="section section-secondary" aria-labelledby="projects-cta-heading">
  <div class="container">
    <div class="cta-box">
      <div class="cta-content">

        <div class="cta-text-col">
          <span class="eyebrow">Private Advisory</span>
          <h2 id="projects-cta-heading" class="cta-title">
            Envisioning Your Own <br>
            <span class="gold-gradient-text">Landmark?</span>
          </h2>
          <p class="cta-desc">
            Speak directly with our senior architectural partners about commissioning a bespoke construction project of your own.
          </p>
        </div>

        <div class="cta-actions">
          <a href="contact.php" class="btn btn-primary" style="text-align: center;">
            <span>Start a Project</span>
          </a>
          <a href="tel:+18008920199" class="cta-phone-link">
            Or call: <strong>+1 (800) 892-0199</strong>
          </a>
        </div>

      </div>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
