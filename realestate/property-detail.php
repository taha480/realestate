<?php
/**
 * AURELIA | Luxury Real Estate & Architectural Construction
 * Property Detail Page
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/db-functions.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$property = ($id !== false && $id !== null) ? getPropertyById((int) $id) : null;

if (!$property) {
    http_response_code(404);
    $pageTitle = 'Property Not Found';
    $currentPage = 'properties';
    $metaDescription = 'The requested property could not be located in the AURELIA registry.';
    include 'includes/header.php';
    ?>

<div class="page-banner">
  <div class="container">
    <div class="breadcrumb">
      <a href="index.php">Home</a>
      <span>/</span>
      <a href="properties.php">Properties</a>
      <span>/</span>
      <span>Not Found</span>
    </div>
    <h1>Property <span class="gold-gradient-text">Not Found</span></h1>
  </div>
</div>

<section class="section section-dark">
  <div class="container">
    <div class="not-found-box">
      <h2 style="margin-bottom: 12px;">This Property Is Unavailable</h2>
      <p style="color: var(--text-muted); margin-bottom: 24px; max-width: 520px; margin-left: auto; margin-right: auto;">
        The property you requested does not exist, has been acquired, or has moved to our confidential off-market registry.
      </p>
      <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
        <a href="properties.php" class="btn btn-outline-gold">View All Properties</a>
        <a href="contact.php" class="btn btn-primary">Contact Advisory</a>
      </div>
    </div>
  </div>
</section>

    <?php
    include 'includes/footer.php';
    exit;
}

$pageTitle = $property['title'];
$currentPage = 'properties';
$metaDescription = !empty($property['short_description'])
    ? $property['short_description']
    : $property['title'] . ' — a prime AURELIA property in ' . $property['location'] . '.';

$gallery = getPropertyImages((int) $property['id']);
if (empty($gallery) && !empty($property['featured_image'])) {
    $gallery = [['image_url' => $property['featured_image'], 'caption' => $property['title']]];
}

$description = !empty($property['full_description'])
    ? $property['full_description']
    : ($property['short_description'] ?? '');

$descriptionParagraphs = array_filter(array_map('trim', preg_split('/\R{2,}/', (string) $description)));

$amenities = [];
if (!empty($property['bedrooms'])) {
    $amenities[] = (int) $property['bedrooms'] . ' Bedrooms';
}
if (!empty($property['bathrooms'])) {
    $amenities[] = (int) $property['bathrooms'] . ' Bathrooms';
}
if (!empty($property['area'])) {
    $amenities[] = $property['area'] . ' Sq. Ft. Interior';
}
if (!empty($property['property_type'])) {
    $amenities[] = $property['property_type'];
}
if (!empty($property['status'])) {
    $amenities[] = $property['status'];
}

include 'includes/header.php';
?>

<!-- Detail Hero -->
<section class="detail-hero" aria-labelledby="property-heading">
  <div class="detail-hero-media">
    <img
      src="<?php echo e($property['featured_image']); ?>"
      alt="<?php echo e($property['title'] . ' in ' . $property['location']); ?>"
      loading="eager"
      fetchpriority="high"
    >
    <div class="detail-hero-caption">
      <div class="container">
        <div class="breadcrumb" style="margin-bottom: 8px;">
          <a href="index.php">Home</a>
          <span>/</span>
          <a href="properties.php">Properties</a>
          <span>/</span>
          <span><?php echo e($property['title']); ?></span>
        </div>
        <div class="detail-hero-location"><?php echo e($property['location']); ?></div>
        <h1 id="property-heading"><?php echo e($property['title']); ?></h1>
        <?php if (!empty($property['price'])): ?>
          <span class="property-price-badge" style="position: static; display: inline-block;"><?php echo e($property['price']); ?></span>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<!-- Detail Content -->
<section class="section section-dark" aria-label="Property Details">
  <div class="container">
    <div class="detail-grid">

      <!-- Narrative, Amenities & Gallery -->
      <div>
        <span class="eyebrow">Residence Overview</span>
        <h2 style="margin-bottom: 24px;">
          The <span class="gold-gradient-text">Residence</span>
        </h2>

        <div class="detail-description">
          <?php if (!empty($descriptionParagraphs)): ?>
            <?php foreach ($descriptionParagraphs as $paragraph): ?>
              <p><?php echo e($paragraph); ?></p>
            <?php endforeach; ?>
          <?php else: ?>
            <p>Detailed acquisition documentation for this residence is maintained in our confidential registry. Contact our advisory team for the complete dossier.</p>
          <?php endif; ?>
        </div>

        <?php if (!empty($amenities)): ?>
          <h2 style="margin: 48px 0 20px;">
            Amenities &amp; <span class="gold-gradient-text">Features</span>
          </h2>
          <ul class="amenity-list">
            <?php foreach ($amenities as $amenity): ?>
              <li><?php echo e($amenity); ?></li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>

        <?php if (!empty($gallery)): ?>
          <h2 style="margin: 48px 0 24px;">
            Property <span class="gold-gradient-text">Gallery</span>
          </h2>
          <div class="gallery-grid">
            <?php foreach ($gallery as $image): ?>
              <figure>
                <img
                  src="<?php echo e($image['image_url']); ?>"
                  alt="<?php echo e(!empty($image['caption']) ? $image['caption'] : $property['title'] . ' — property photograph'); ?>"
                  loading="lazy"
                >
              </figure>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>

      <!-- Specification Panel -->
      <aside class="detail-specs" aria-label="Property Specifications">
        <h3>Details</h3>

        <?php if (!empty($property['price'])): ?>
          <div class="spec-row">
            <span class="spec-key">Price</span>
            <span class="spec-value" style="color: var(--accent-gold-light); font-weight: 600;"><?php echo e($property['price']); ?></span>
          </div>
        <?php endif; ?>

        <div class="spec-row">
          <span class="spec-key">Location</span>
          <span class="spec-value"><?php echo e($property['location']); ?></span>
        </div>

        <?php if (!empty($property['property_type'])): ?>
          <div class="spec-row">
            <span class="spec-key">Type</span>
            <span class="spec-value"><?php echo e($property['property_type']); ?></span>
          </div>
        <?php endif; ?>

        <?php if (!empty($property['bedrooms'])): ?>
          <div class="spec-row">
            <span class="spec-key">Bedrooms</span>
            <span class="spec-value"><?php echo (int) $property['bedrooms']; ?></span>
          </div>
        <?php endif; ?>

        <?php if (!empty($property['bathrooms'])): ?>
          <div class="spec-row">
            <span class="spec-key">Bathrooms</span>
            <span class="spec-value"><?php echo (int) $property['bathrooms']; ?></span>
          </div>
        <?php endif; ?>

        <?php if (!empty($property['area'])): ?>
          <div class="spec-row">
            <span class="spec-key">Area</span>
            <span class="spec-value"><?php echo e($property['area']); ?> Sq. Ft.</span>
          </div>
        <?php endif; ?>

        <?php if (!empty($property['status'])): ?>
          <div class="spec-row">
            <span class="spec-key">Status</span>
            <span class="spec-value"><?php echo e($property['status']); ?></span>
          </div>
        <?php endif; ?>

        <a href="contact.php?property_id=<?php echo (int) $property['id']; ?>" class="btn btn-primary">
          <span>Enquire About This Property</span>
        </a>
      </aside>

    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
