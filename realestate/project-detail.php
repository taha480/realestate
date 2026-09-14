<?php
/**
 * AURELIA | Luxury Real Estate & Architectural Construction
 * Project Detail Page
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/db-functions.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$project = ($id !== false && $id !== null) ? getProjectById((int) $id) : null;

if (!$project) {
    http_response_code(404);
    $pageTitle = 'Project Not Found';
    $currentPage = 'projects';
    $metaDescription = 'The requested project could not be located in the AURELIA portfolio.';
    include 'includes/header.php';
    ?>

<div class="page-banner">
  <div class="container">
    <div class="breadcrumb">
      <a href="index.php">Home</a>
      <span>/</span>
      <a href="projects.php">Projects</a>
      <span>/</span>
      <span>Not Found</span>
    </div>
    <h1>Project <span class="gold-gradient-text">Not Found</span></h1>
  </div>
</div>

<section class="section section-dark">
  <div class="container">
    <div class="not-found-box">
      <h2 style="margin-bottom: 12px;">This Project Is Unavailable</h2>
      <p style="color: var(--text-muted); margin-bottom: 24px; max-width: 520px; margin-left: auto; margin-right: auto;">
        The project you requested does not exist or may have been moved to our private registry. Explore our current public portfolio below.
      </p>
      <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
        <a href="projects.php" class="btn btn-outline-gold">View All Projects</a>
        <a href="contact.php" class="btn btn-primary">Contact Advisory</a>
      </div>
    </div>
  </div>
</section>

    <?php
    include 'includes/footer.php';
    exit;
}

$pageTitle = $project['title'];
$currentPage = 'projects';
$metaDescription = !empty($project['short_description'])
    ? $project['short_description']
    : $project['title'] . ' — an AURELIA architectural construction project in ' . $project['location'] . '.';

$gallery = getProjectImages((int) $project['id']);
if (empty($gallery) && !empty($project['featured_image'])) {
    $gallery = [['image_url' => $project['featured_image'], 'caption' => $project['title']]];
}

$description = !empty($project['full_description'])
    ? $project['full_description']
    : ($project['short_description'] ?? '');

$descriptionParagraphs = array_filter(array_map('trim', preg_split('/\R{2,}/', (string) $description)));

include 'includes/header.php';
?>

<!-- Detail Hero -->
<section class="detail-hero" aria-labelledby="project-heading">
  <div class="detail-hero-media">
    <img
      src="<?php echo e($project['featured_image']); ?>"
      alt="<?php echo e($project['title'] . ' in ' . $project['location']); ?>"
      loading="eager"
      fetchpriority="high"
    >
    <div class="detail-hero-caption">
      <div class="container">
        <div class="breadcrumb" style="margin-bottom: 8px;">
          <a href="index.php">Home</a>
          <span>/</span>
          <a href="projects.php">Projects</a>
          <span>/</span>
          <span><?php echo e($project['title']); ?></span>
        </div>
        <div class="detail-hero-location"><?php echo e($project['location']); ?></div>
        <h1 id="project-heading"><?php echo e($project['title']); ?></h1>
        <?php if (!empty($project['category'])): ?>
          <span class="project-category-badge" style="position: static; display: inline-block;"><?php echo e($project['category']); ?></span>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<!-- Detail Content -->
<section class="section section-dark" aria-label="Project Details">
  <div class="container">
    <div class="detail-grid">

      <!-- Narrative & Gallery -->
      <div>
        <span class="eyebrow">Project Overview</span>
        <h2 style="margin-bottom: 24px;">
          Architectural <span class="gold-gradient-text">Narrative</span>
        </h2>

        <div class="detail-description">
          <?php if (!empty($descriptionParagraphs)): ?>
            <?php foreach ($descriptionParagraphs as $paragraph): ?>
              <p><?php echo e($paragraph); ?></p>
            <?php endforeach; ?>
          <?php else: ?>
            <p>Detailed project documentation for this development is maintained in our private registry. Contact our advisory team for the complete architectural dossier.</p>
          <?php endif; ?>
        </div>

        <?php if (!empty($gallery)): ?>
          <h2 style="margin: 48px 0 24px;">
            Project <span class="gold-gradient-text">Gallery</span>
          </h2>
          <div class="gallery-grid">
            <?php foreach ($gallery as $image): ?>
              <figure>
                <img
                  src="<?php echo e($image['image_url']); ?>"
                  alt="<?php echo e(!empty($image['caption']) ? $image['caption'] : $project['title'] . ' — project photograph'); ?>"
                  loading="lazy"
                >
              </figure>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>

      <!-- Specification Panel -->
      <aside class="detail-specs" aria-label="Project Specifications">
        <h3>Specifications</h3>

        <?php if (!empty($project['status'])): ?>
          <div class="spec-row">
            <span class="spec-key">Status</span>
            <span class="spec-value"><?php echo e($project['status']); ?></span>
          </div>
        <?php endif; ?>

        <?php if (!empty($project['category'])): ?>
          <div class="spec-row">
            <span class="spec-key">Category</span>
            <span class="spec-value"><?php echo e($project['category']); ?></span>
          </div>
        <?php endif; ?>

        <div class="spec-row">
          <span class="spec-key">Location</span>
          <span class="spec-value"><?php echo e($project['location']); ?></span>
        </div>

        <?php if (!empty($project['area'])): ?>
          <div class="spec-row">
            <span class="spec-key">Area</span>
            <span class="spec-value"><?php echo e($project['area']); ?></span>
          </div>
        <?php endif; ?>

        <?php if (!empty($project['completion_date'])): ?>
          <div class="spec-row">
            <span class="spec-key">Completion</span>
            <span class="spec-value"><?php echo e($project['completion_date']); ?></span>
          </div>
        <?php endif; ?>

        <a href="contact.php?project_id=<?php echo (int) $project['id']; ?>" class="btn btn-primary">
          <span>Enquire About This Project</span>
        </a>
      </aside>

    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
