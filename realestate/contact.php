<?php
/**
 * AURELIA | Luxury Real Estate & Architectural Construction
 * Contact & Project Initiation Page (Connected to MySQL Persistence Layer)
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/db-functions.php';

$pageTitle = 'Start a Project & Private Consultation';
$currentPage = 'contact';
$metaDescription = 'Initiate a confidential feasibility discussion with AURELIA master builders and principal architects.';

$submitted = false;
$refCode = '';
$formError = null;

// Retain form inputs if validation error occurs
$formData = [
    'name'     => '',
    'email'    => '',
    'phone'    => '',
    'service'  => 'Residential Construction',
    'location' => '',
    'budget'   => '$10M – $25M',
    'notes'    => ''
];

// Prefill context when arriving from a project or property detail page
$prefillProjectId  = filter_input(INPUT_GET, 'project_id', FILTER_VALIDATE_INT) ?: null;
$prefillPropertyId = filter_input(INPUT_GET, 'property_id', FILTER_VALIDATE_INT) ?: null;

if ($prefillProjectId) {
    $prefillProject = getProjectById((int) $prefillProjectId);
    if ($prefillProject) {
        $formData['service'] = 'Design & Build';
        $formData['notes']   = 'Regarding project: ' . $prefillProject['title'];
    } else {
        $prefillProjectId = null;
    }
}

if ($prefillPropertyId) {
    $prefillProperty = getPropertyById((int) $prefillPropertyId);
    if ($prefillProperty) {
        $formData['service'] = 'Prime Property Acquisition';
        $formData['notes']   = 'Regarding property: ' . $prefillProperty['title'];
    } else {
        $prefillPropertyId = null;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submittedToken = $_POST['csrf_token'] ?? null;

    if (!validateCsrfToken($submittedToken)) {
        $formError = 'Security verification failed. Please refresh and resubmit.';
    } else {
        $prefillProjectId  = !empty($_POST['project_id']) ? (int) $_POST['project_id'] : null;
        $prefillPropertyId = !empty($_POST['property_id']) ? (int) $_POST['property_id'] : null;
        $formData['name']     = cleanInput($_POST['client_name'] ?? '');
        $formData['email']    = cleanInput($_POST['client_email'] ?? '');
        $formData['phone']    = cleanInput($_POST['client_phone'] ?? '');
        $formData['service']  = cleanInput($_POST['project_service'] ?? 'Residential Construction');
        $formData['location'] = cleanInput($_POST['project_location'] ?? '');
        $formData['budget']   = cleanInput($_POST['project_budget'] ?? '$10M – $25M');
        $formData['notes']    = cleanInput($_POST['project_notes'] ?? '');

        $result = submitEnquiry([
            'name'            => $formData['name'],
            'email'           => $formData['email'],
            'phone'           => $formData['phone'],
            'subject'         => $formData['service'],
            'message'         => $formData['notes'],
            'budget_range'    => $formData['budget'],
            'target_location' => $formData['location'],
            'project_id'      => $prefillProjectId,
            'property_id'     => $prefillPropertyId
        ]);

        if ($result['success']) {
            $submitted = true;
            $refCode = $result['reference_id'];
        } else {
            $formError = $result['error'] ?? 'Unable to process inquiry. Please check the fields and try again.';
        }
    }
}

include 'includes/header.php';
?>

<div class="page-banner">
  <div class="container">
    <div class="breadcrumb">
      <a href="index.php">Home</a>
      <span>/</span>
      <span>Contact</span>
    </div>
    <h1>Start Your <span class="gold-gradient-text">Project</span></h1>
    <p style="max-width: 620px;">
      Initiate a confidential briefing with our senior architectural partners. We evaluate site feasibility, zoning parameters, and construction budgets worldwide.
    </p>
  </div>
</div>

<section class="section section-dark">
  <div class="container">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 64px; align-items: flex-start;" class="contact-grid-container">
      
      <!-- Left Column: Form -->
      <div style="background: var(--bg-surface); border: 1px solid var(--border-gold); padding: 48px; border-radius: 2px;">
        
        <?php if ($submitted): ?>
          <div style="text-align: center; padding: 24px 0;">
            <div style="width: 60px; height: 60px; border-radius: 50%; border: 1px solid var(--accent-gold); color: var(--accent-gold-light); display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; font-size: 1.5rem;">
              &#10003;
            </div>
            <h2 style="font-size: 1.8rem; margin-bottom: 12px;">Briefing Received</h2>
            <p style="margin-bottom: 24px; font-size: 0.95rem;">
              Thank you for initiating contact with Aurelia. Your confidential dossier reference is <strong style="color: var(--accent-gold-light); font-family: monospace;"><?php echo e($refCode); ?></strong>.
            </p>
            <p style="font-size: 0.85rem; color: var(--text-dim); margin-bottom: 32px;">
              Your submission has been securely stored in our executive client registry. An executive partner from our Private Advisory team will contact you within 4 business hours.
            </p>
            <a href="index.php" class="btn btn-outline-gold">Return to Home</a>
          </div>
        <?php else: ?>
          <span class="eyebrow">Confidential Briefing</span>
          <h2 style="font-size: 1.85rem; margin-bottom: 24px;">Project Inquiry Form</h2>
          
          <?php if ($formError): ?>
            <div style="background: rgba(220, 38, 38, 0.15); border: 1px solid rgba(220, 38, 38, 0.4); color: #fca5a5; padding: 12px 16px; font-size: 0.8125rem; margin-bottom: 20px; border-radius: 2px;">
              <?php echo e($formError); ?>
            </div>
          <?php endif; ?>

          <form action="contact.php" method="POST" style="display: flex; flex-direction: column; gap: 20px;">
            <?php echo csrfField(); ?>
            <?php if ($prefillProjectId): ?>
              <input type="hidden" name="project_id" value="<?php echo (int) $prefillProjectId; ?>">
            <?php endif; ?>
            <?php if ($prefillPropertyId): ?>
              <input type="hidden" name="property_id" value="<?php echo (int) $prefillPropertyId; ?>">
            <?php endif; ?>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
              <div>
                <label for="client_name" style="display: block; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.15em; color: var(--text-muted); margin-bottom: 6px;">Full Name *</label>
                <input 
                  type="text" 
                  id="client_name" 
                  name="client_name" 
                  value="<?php echo e($formData['name']); ?>" 
                  required 
                  style="width: 100%; background: var(--bg-secondary); border: 1px solid var(--border-subtle); padding: 12px 14px; font-size: 0.9rem; color: #fff; border-radius: 2px;"
                >
              </div>
              <div>
                <label for="client_email" style="display: block; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.15em; color: var(--text-muted); margin-bottom: 6px;">Confidential Email *</label>
                <input 
                  type="email" 
                  id="client_email" 
                  name="client_email" 
                  value="<?php echo e($formData['email']); ?>" 
                  required 
                  style="width: 100%; background: var(--bg-secondary); border: 1px solid var(--border-subtle); padding: 12px 14px; font-size: 0.9rem; color: #fff; border-radius: 2px;"
                >
              </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
              <div>
                <label for="client_phone" style="display: block; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.15em; color: var(--text-muted); margin-bottom: 6px;">Telephone Number *</label>
                <input 
                  type="tel" 
                  id="client_phone" 
                  name="client_phone" 
                  value="<?php echo e($formData['phone']); ?>" 
                  required 
                  style="width: 100%; background: var(--bg-secondary); border: 1px solid var(--border-subtle); padding: 12px 14px; font-size: 0.9rem; color: #fff; border-radius: 2px;"
                >
              </div>
              <div>
                <label for="project_service" style="display: block; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.15em; color: var(--text-muted); margin-bottom: 6px;">Desired Service</label>
                <select id="project_service" name="project_service" style="width: 100%; background: var(--bg-secondary); border: 1px solid var(--border-subtle); padding: 12px 14px; font-size: 0.85rem; color: #fff; border-radius: 2px;">
                  <?php 
                    $servicesList = [
                        'Residential Construction',
                        'Commercial Construction',
                        'Design & Build',
                        'Renovation & Restoration',
                        'Prime Property Acquisition',
                        'Project Management'
                    ];
                    foreach ($servicesList as $s) {
                        $selected = ($formData['service'] === $s) ? 'selected' : '';
                        echo "<option value=\"" . e($s) . "\" $selected>" . e($s) . "</option>";
                    }
                  ?>
                </select>
              </div>
            </div>

            <div>
              <label for="project_location" style="display: block; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.15em; color: var(--text-muted); margin-bottom: 6px;">Target Location / Site</label>
              <input 
                type="text" 
                id="project_location" 
                name="project_location" 
                value="<?php echo e($formData['location']); ?>" 
                placeholder="e.g. Beverly Hills, London, Lake Como, Zurich" 
                style="width: 100%; background: var(--bg-secondary); border: 1px solid var(--border-subtle); padding: 12px 14px; font-size: 0.9rem; color: #fff; border-radius: 2px;"
              >
            </div>

            <div>
              <label for="project_budget" style="display: block; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.15em; color: var(--text-muted); margin-bottom: 6px;">Estimated Capital Scale</label>
              <select id="project_budget" name="project_budget" style="width: 100%; background: var(--bg-secondary); border: 1px solid var(--border-subtle); padding: 12px 14px; font-size: 0.85rem; color: #fff; border-radius: 2px;">
                <?php
                  $budgetTiers = ['$5M – $10M', '$10M – $25M', '$25M – $50M', '$50M – $100M+'];
                  foreach ($budgetTiers as $b) {
                      $selected = ($formData['budget'] === $b) ? 'selected' : '';
                      echo "<option value=\"" . e($b) . "\" $selected>" . e($b) . "</option>";
                  }
                ?>
              </select>
            </div>

            <div>
              <label for="project_notes" style="display: block; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.15em; color: var(--text-muted); margin-bottom: 6px;">Project Overview &amp; Specific Requirements</label>
              <textarea 
                id="project_notes" 
                name="project_notes" 
                rows="4" 
                placeholder="Describe the site, architectural style, square footage, or target schedule..." 
                style="width: 100%; background: var(--bg-secondary); border: 1px solid var(--border-subtle); padding: 12px 14px; font-size: 0.9rem; color: #fff; border-radius: 2px; resize: vertical;"
              ><?php echo e($formData['notes']); ?></textarea>
            </div>

            <div style="font-size: 0.75rem; color: var(--text-dim); margin-top: 4px;">
              Protected by international Non-Disclosure Covenant. Your information will never be shared.
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 10px;">
              <span>Submit Confidential Briefing</span>
            </button>
          </form>
        <?php endif; ?>

      </div>

      <!-- Right Column: Advisory Details -->
      <div>
        <span class="eyebrow">Direct Engagement</span>
        <h2 style="margin-bottom: 20px;">Global Private Studios</h2>
        <p style="margin-bottom: 36px;">
          For expedited private client inquiries, our partners may be reached directly by phone or via private appointment at any of our architectural studios.
        </p>

        <div style="display: flex; flex-direction: column; gap: 24px; margin-bottom: 40px;">
          
          <div style="padding: 24px; background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: 2px;">
            <div style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.15em; color: var(--accent-gold); margin-bottom: 4px;">Zurich Headquarters</div>
            <div style="font-family: var(--font-serif); font-size: 1.25rem; color: #fff; margin-bottom: 6px;">Bahnhofstrasse 45, 8001 Zürich</div>
            <div style="font-size: 0.85rem; color: var(--text-muted);">Telephone: +41 44 211 88 00</div>
          </div>

          <div style="padding: 24px; background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: 2px;">
            <div style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.15em; color: var(--accent-gold); margin-bottom: 4px;">Beverly Hills Studio</div>
            <div style="font-family: var(--font-serif); font-size: 1.25rem; color: #fff; margin-bottom: 6px;">9600 Wilshire Blvd, Beverly Hills, CA</div>
            <div style="font-size: 0.85rem; color: var(--text-muted);">Telephone: +1 (310) 892-0199</div>
          </div>

          <div style="padding: 24px; background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: 2px;">
            <div style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.15em; color: var(--accent-gold); margin-bottom: 4px;">London Studio</div>
            <div style="font-family: var(--font-serif); font-size: 1.25rem; color: #fff; margin-bottom: 6px;">12 Berkeley Square, Mayfair, London</div>
            <div style="font-size: 0.85rem; color: var(--text-muted);">Telephone: +44 20 7946 0921</div>
          </div>

        </div>

      </div>

    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
