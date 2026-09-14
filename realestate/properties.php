<?php
/**
 * AURELIA | Luxury Real Estate & Architectural Construction
 * Properties Listing Page
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/db-functions.php';

$pageTitle = 'Prime Properties & Private Estates';
$currentPage = 'properties';
$metaDescription = 'Exceptional completed residences and off-market estates curated for acquisition by distinguished private buyers.';

$properties = getAllProperties();

include 'includes/header.php';
?>

<!-- Page Hero -->
<div class="page-banner">
  <div class="container">
    <div class="breadcrumb">
      <a href="index.php">Home</a>
      <span>/</span>
      <span>Properties</span>
    </div>
    <h1>Prime <span class="gold-gradient-text">Properties</span></h1>
    <p style="max-width: 600px;">
      Exceptional completed residences and off-market estates curated for acquisition by distinguished private buyers.
    </p>
  </div>
</div>

<!-- Properties Listing -->
<section class="section section-dark" aria-label="All Prime Properties">
  <div class="container">

    <?php if (empty($properties)): ?>
      <div class="not-found-box">
        <h2 style="margin-bottom: 12px;">Registry Temporarily Unavailable</h2>
        <p style="color: var(--text-muted); margin-bottom: 24px;">
          Our property registry is being updated. Please contact our Private Advisory team for current availability.
        </p>
        <a href="contact.php" class="btn btn-primary"><span>Contact Advisory</span></a>
      </div>
    <?php else: ?>
      <div class="properties-grid">

        <?php foreach ($properties as $property): ?>
          <a class="property-card" href="property-detail.php?id=<?php echo (int) $property['id']; ?>" aria-label="View property details for <?php echo e($property['title']); ?>">
            <div class="property-thumb">
              <?php if (!empty($property['status'])): ?>
                <span class="property-status-badge"><?php echo e($property['status']); ?></span>
              <?php endif; ?>
              <?php if (!empty($property['price'])): ?>
                <span class="property-price-badge"><?php echo e($property['price']); ?></span>
              <?php endif; ?>
              <img
                src="<?php echo e($property['featured_image']); ?>"
                alt="<?php echo e($property['title'] . ' in ' . $property['location']); ?>"
                loading="lazy"
              >
            </div>
            <div class="property-info">
              <div class="property-location"><?php echo e($property['location']); ?></div>
              <h3 class="property-title"><?php echo e($property['title']); ?></h3>
              <div class="property-amenities">
                <?php if (!empty($property['area'])): ?>
                  <span><strong><?php echo e($property['area']); ?></strong> Sq. Ft.</span>
                <?php endif; ?>
                <?php if (!empty($property['bedrooms'])): ?>
                  <span><strong><?php echo (int) $property['bedrooms']; ?></strong> Beds</span>
                <?php endif; ?>
                <?php if (!empty($property['bathrooms'])): ?>
                  <span><strong><?php echo (int) $property['bathrooms']; ?></strong> Baths</span>
                <?php endif; ?>
              </div>
              <?php if (!empty($property['property_type'])): ?>
                <div style="margin-top: 10px; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.15em; color: var(--text-dim);">
                  <?php echo e($property['property_type']); ?>
                </div>
              <?php endif; ?>
            </div>
          </a>
        <?php endforeach; ?>

      </div>
    <?php endif; ?>

  </div>
</section>

<!-- CTA -->
<section class="section section-secondary" aria-labelledby="properties-cta-heading">
  <div class="container">
    <div class="cta-box">
      <div class="cta-content">

        <div class="cta-text-col">
          <span class="eyebrow">Private Acquisition</span>
          <h2 id="properties-cta-heading" class="cta-title">
            Seeking an <br>
            <span class="gold-gradient-text">Off-Market Estate?</span>
          </h2>
          <p class="cta-desc">
            Our Private Advisory maintains a confidential registry of off-market residences available exclusively to qualified buyers.
          </p>
        </div>

        <div class="cta-actions">
          <a href="contact.php" class="btn btn-primary" style="text-align: center;">
            <span>Request Private Registry</span>
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
