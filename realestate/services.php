<?php
/**
 * AURELIA | Luxury Real Estate & Architectural Construction
 * Services Page
 */

$pageTitle = 'End-to-End Construction Services';
$currentPage = 'services';
$metaDescription = 'Comprehensive construction, architectural design, general contracting, and project management services by AURELIA.';

include 'includes/header.php';

$serviceDetails = [
    [
        'id'     => 'residential',
        'num'    => '01',
        'title'  => 'Residential Construction',
        'desc'   => 'Custom ground-up estates, architectural villas, and private multi-structure residential compounds built to generational standards. From cantilevered glass pavilions to heritage stone manor houses, our residential division manages every discipline from foundation engineering to final millwork.',
        'img'    => 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=1200&q=85',
        'alt'    => 'Luxury residential estate constructed by Aurelia with cantilevered glass architecture',
        'features' => [
            'Post-tensioned concrete and structural steel',
            'Zero-tolerance interior millwork installation',
            'Acoustic isolation & climate-controlled sanctuaries',
        ],
    ],
    [
        'id'     => 'commercial',
        'num'    => '02',
        'title'  => 'Commercial Construction',
        'desc'   => 'Trophy corporate headquarters, boutique luxury hotels, and private family office flagships engineered for discretion and prestige. Our commercial teams deliver certified sustainable buildings with complex security envelopes and mission-critical MEP infrastructure.',
        'img'    => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1200&q=85',
        'alt'    => 'Modern commercial headquarters building facade engineered by Aurelia',
        'features' => [
            'BREEAM & LEED Platinum energy compliance',
            'High-security building envelopes & access systems',
            'Complex MEP and advanced building automation',
        ],
    ],
    [
        'id'     => 'design-build',
        'num'    => '03',
        'title'  => 'Design & Build',
        'desc'   => 'A single, unified contract uniting licensed architecture, computational engineering, and master general contracting from day one. By collapsing the traditional design-bid-build sequence, we eliminate costly change orders and compress delivery schedules by up to 30 percent.',
        'img'    => 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?auto=format&fit=crop&w=1200&q=85',
        'alt'    => 'Architectural blueprints and 3D BIM model during Aurelia design phase',
        'features' => [
            '3D BIM coordination & solar-path simulations',
            'Elimination of costly change orders & delays',
            'Seamless translation from concept to finished structure',
        ],
    ],
    [
        'id'     => 'renovation',
        'num'    => '04',
        'title'  => 'Renovation & Restoration',
        'desc'   => 'Historic preservation of landmark estates, seismic retrofits, structural modernizations, and haute interior architectural transformations. Our conservators and structural engineers restore irreplaceable fabric while discreetly integrating contemporary performance systems.',
        'img'    => 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=1200&q=85',
        'alt'    => 'Restored historic waterfront villa with preserved heritage masonry',
        'features' => [
            'Archaeological fabric conservation & masonry',
            'Concealed modern MEP & geothermal integration',
            'Municipal landmark board expediting & compliance',
        ],
    ],
    [
        'id'     => 'project-mgmt',
        'num'    => '05',
        'title'  => 'Project Management',
        'desc'   => 'Independent client representation, feasibility studies, international procurement, cost engineering, and on-site quality oversight. For clients engaging third-party builders, Aurelia acts as your expert advocate — protecting capital and enforcing specification at every stage.',
        'img'    => 'https://images.unsplash.com/photo-1541888946425-d0fbb186c5f7?auto=format&fit=crop&w=1200&q=85',
        'alt'    => 'Aurelia project manager inspecting construction quality on site',
        'features' => [
            'Guaranteed Maximum Price (GMP) governance',
            'Bi-weekly 3D LiDAR point-cloud quality scans',
            'Vendor vetting and international logistics management',
        ],
    ],
];
?>

<!-- Page Hero -->
<div class="page-banner">
  <div class="container">
    <div class="breadcrumb">
      <a href="index.php">Home</a>
      <span>/</span>
      <span>Services</span>
    </div>
    <h1>Construction &amp; <span class="gold-gradient-text">Development Services</span></h1>
    <p style="max-width: 600px;">
      Residential construction, commercial flagships, design &amp; build, historic renovation, and full-spectrum project management.
    </p>
  </div>
</div>

<!-- Detailed Services -->
<section class="section section-dark" aria-label="Detailed Construction Services">
  <div class="container">

    <?php foreach ($serviceDetails as $i => $svc): ?>
      <div class="service-detail-block <?php echo $i % 2 === 1 ? 'is-reversed' : ''; ?>" id="<?php echo e($svc['id']); ?>">
        <div class="service-detail-body">
          <span class="service-detail-num">Service <?php echo e($svc['num']); ?></span>
          <h3><?php echo e($svc['title']); ?></h3>
          <p><?php echo e($svc['desc']); ?></p>
          <ul class="service-features" style="margin-bottom: 28px;">
            <?php foreach ($svc['features'] as $feature): ?>
              <li><?php echo e($feature); ?></li>
            <?php endforeach; ?>
          </ul>
          <a href="contact.php" class="link-arrow">
            <span>Inquire About <?php echo e($svc['title']); ?></span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M5 12h14M12 5l7 7-7 7"/>
            </svg>
          </a>
        </div>
        <div class="service-detail-media">
          <img
            src="<?php echo e($svc['img']); ?>"
            alt="<?php echo e($svc['alt']); ?>"
            loading="lazy"
          >
        </div>
      </div>
    <?php endforeach; ?>

  </div>
</section>

<!-- Process -->
<section class="section section-secondary" aria-labelledby="services-process-heading">
  <div class="container">

    <div class="section-header-row">
      <div class="section-header-col">
        <span class="eyebrow">Master Methodology</span>
        <h2 id="services-process-heading">
          How We <span class="gold-gradient-text">Deliver</span>
        </h2>
      </div>
      <p class="section-subtitle">
        Every engagement — regardless of scale — follows the same disciplined five-stage delivery framework.
      </p>
    </div>

    <div class="process-timeline">

      <div class="process-step-card">
        <div class="step-indicator">
          <span class="step-number">01</span>
          <span class="step-phase-badge">Phase 1</span>
        </div>
        <h3 class="step-title">Consultation</h3>
        <p class="step-text">
          Confidential briefing, spatial program definition, topographical survey, zoning review, and financial feasibility analysis.
        </p>
      </div>

      <div class="process-step-card">
        <div class="step-indicator">
          <span class="step-number">02</span>
          <span class="step-phase-badge">Phase 2</span>
        </div>
        <h3 class="step-title">Planning</h3>
        <p class="step-text">
          Municipal permit expediting, environmental impact assessments, structural engineering calculations, and budget locking.
        </p>
      </div>

      <div class="process-step-card">
        <div class="step-indicator">
          <span class="step-number">03</span>
          <span class="step-phase-badge">Phase 3</span>
        </div>
        <h3 class="step-title">Design</h3>
        <p class="step-text">
          3D BIM computational modeling, physical material palette curation, photorealistic VR walkthroughs, and MEP master schematics.
        </p>
      </div>

      <div class="process-step-card">
        <div class="step-indicator">
          <span class="step-number">04</span>
          <span class="step-phase-badge">Phase 4</span>
        </div>
        <h3 class="step-title">Construction</h3>
        <p class="step-text">
          Groundbreaking, structural framing, triple-glazed envelope sealing, artisanal stone masonry, and high-precision millwork.
        </p>
      </div>

      <div class="process-step-card">
        <div class="step-indicator">
          <span class="step-number">05</span>
          <span class="step-phase-badge">Phase 5</span>
        </div>
        <h3 class="step-title">Handover</h3>
        <p class="step-text">
          500-point white-glove inspection, digital twin documentation, systems orientation, and activation of our 10-year master warranty.
        </p>
      </div>

    </div>

  </div>
</section>

<!-- CTA -->
<section class="section section-dark" aria-labelledby="services-cta-heading">
  <div class="container">
    <div class="cta-box">
      <div class="cta-content">

        <div class="cta-text-col">
          <span class="eyebrow">Private Advisory</span>
          <h2 id="services-cta-heading" class="cta-title">
            Have a Custom <br>
            <span class="gold-gradient-text">Build in Mind?</span>
          </h2>
          <p class="cta-desc">
            Our principal architects and master builders are available for direct confidential feasibility assessments.
          </p>
        </div>

        <div class="cta-actions">
          <a href="contact.php" class="btn btn-primary" style="text-align: center;">
            <span>Consult an Expert</span>
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
