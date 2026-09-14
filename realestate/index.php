<?php
/**
 * AURELIA | Luxury Real Estate & Architectural Construction
 * Home Page (PHASE 1: FRONTEND)
 */

$pageTitle = 'Building Spaces. Creating Value.';
$currentPage = 'home';
$metaDescription = 'AURELIA — Premium real estate development and end-to-end construction solutions built around quality, precision and trust.';

include 'includes/header.php';
?>

<!-- ==========================================================================
     2. HERO SECTION
     ========================================================================== -->
<section class="hero-section" aria-labelledby="hero-heading">
  <!-- Background Media & Luxury Overlays -->
  <div class="hero-media-bg">
    <img 
      src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=2200&q=88" 
      alt="Aurelia Architectural Masterpiece Estate"
      loading="eager"
    >
  </div>
  <div class="hero-overlay" aria-hidden="true"></div>

  <div class="container">
    <div class="hero-content">
      <span class="eyebrow">Architectural Excellence &bull; End-to-End Construction</span>
      <h1 id="hero-heading" class="hero-title">
        Building Spaces. <br>
        <span class="gold-gradient-text">Creating Value.</span>
      </h1>
      <p class="hero-text">
        Premium real estate development and end-to-end construction solutions built around quality, precision and trust.
      </p>
      <div class="hero-buttons">
        <a href="#featured-projects" class="btn btn-primary">
          <span>Explore Our Projects</span>
        </a>
        <a href="contact.php" class="btn btn-outline">
          <span>Start Your Project</span>
        </a>
      </div>
    </div>
  </div>
</section>

<!-- ==========================================================================
     4. STATISTICS STRIP
     ========================================================================== -->
<section class="stats-strip" aria-label="Company Key Statistics">
  <div class="container">
    <div class="stats-grid">
      
      <div class="stat-item">
        <div class="stat-value">15+</div>
        <div class="stat-label">Years Experience</div>
        <div class="stat-sub">Master architectural craftsmanship</div>
      </div>

      <div class="stat-item">
        <div class="stat-value">120+</div>
        <div class="stat-label">Projects Completed</div>
        <div class="stat-sub">Residential & commercial landmarks</div>
      </div>

      <div class="stat-item">
        <div class="stat-value">2M+</div>
        <div class="stat-label">Sq. Ft. Developed</div>
        <div class="stat-sub">Precision engineered living spaces</div>
      </div>

      <div class="stat-item">
        <div class="stat-value">98%</div>
        <div class="stat-label">Client Satisfaction</div>
        <div class="stat-sub">Proven turnkey delivery record</div>
      </div>

    </div>
  </div>
</section>

<!-- ==========================================================================
     3. COMPANY INTRODUCTION
     ========================================================================== -->
<section class="section section-dark" id="about-intro" aria-labelledby="intro-heading">
  <div class="container">
    <div class="intro-grid">
      
      <!-- Narrative Column -->
      <div class="intro-text-col">
        <span class="eyebrow">About Aurelia</span>
        <h2 id="intro-heading">
          Where Visionary Design Meets <br>
          <span class="gold-gradient-text">Structural Permanence</span>
        </h2>
        <p style="margin-bottom: 20px;">
          Founded on the conviction that exceptional architecture shapes human experience, AURELIA combines visionary design with uncompromising general contracting. We handle the entire lifecycle of luxury residences, boutique developments, and commercial landmarks under a unified standard of excellence.
        </p>
        <p style="margin-bottom: 32px;">
          By integrating architectural design, structural engineering, and artisan construction under one roof, we eliminate miscommunication, guarantee cost certainty, and deliver structures of enduring cultural and financial value.
        </p>

        <!-- Pillars Grid -->
        <div class="intro-pillars">
          <div class="intro-pillar-item">
            <h4 class="intro-pillar-title">Architectural Rigor</h4>
            <p class="intro-pillar-desc">Sub-millimeter tolerances backed by advanced 3D BIM coordination.</p>
          </div>
          <div class="intro-pillar-item">
            <h4 class="intro-pillar-title">Direct Sourcing</h4>
            <p class="intro-pillar-desc">Rare marbles and sustainable timbers reserved straight from European quarries.</p>
          </div>
        </div>

        <div style="margin-top: 40px;">
          <a href="about.php" class="link-arrow">
            <span>Learn More About Our Philosophy</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M5 12h14M12 5l7 7-7 7"/>
            </svg>
          </a>
        </div>
      </div>

      <!-- Imagery Stack -->
      <div class="intro-media-stack">
        <img 
          src="https://images.unsplash.com/photo-1600585154526-990dced4db0d?auto=format&fit=crop&w=1200&q=85" 
          alt="Aurelia Crafted Contemporary Interior"
          class="intro-img-main"
          loading="lazy"
        >
        <div class="intro-badge-floating">
          <div class="intro-badge-number">100%</div>
          <div class="intro-badge-label">Turnkey Delivery Certainty</div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ==========================================================================
     5. FEATURED PROJECTS
     ========================================================================== -->
<section class="section section-secondary" id="featured-projects" aria-labelledby="projects-heading">
  <div class="container">
    
    <div class="section-header-row">
      <div class="section-header-col">
        <span class="eyebrow">Curated Portfolio</span>
        <h2 id="projects-heading">
          Featured <span class="gold-gradient-text">Projects</span>
        </h2>
      </div>
      <p class="section-subtitle">
        A selection of our recently completed and active construction developments across prime global locations.
      </p>
    </div>

    <div class="projects-grid">
      
      <!-- Project Card 1 -->
      <article class="project-card">
        <div class="project-thumb">
          <span class="project-category-badge">Residential &bull; Turnkey</span>
          <img 
            src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=1200&q=85" 
            alt="The Solstice Pavilion in Beverly Hills"
            loading="lazy"
          >
        </div>
        <div class="project-details">
          <div class="project-meta-row">
            <span class="project-location">Beverly Hills, California</span>
            <span>Completed 2025</span>
          </div>
          <h3 class="project-title">The Solstice Pavilion</h3>
          <p class="project-desc">
            Cantilevered glass and Roman silver travertine residence engineered over a dramatic 270-degree promontory.
          </p>
          <div class="project-specs">
            <div class="spec-item">Area: <span>14,200 sq. ft.</span></div>
            <div class="spec-item">Scope: <span>Ground-Up Construction</span></div>
          </div>
        </div>
      </article>

      <!-- Project Card 2 -->
      <article class="project-card">
        <div class="project-thumb">
          <span class="project-category-badge">Heritage Revival</span>
          <img 
            src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=1200&q=85" 
            alt="Villa Bellissima Belvedere on Lake Como"
            loading="lazy"
          >
        </div>
        <div class="project-details">
          <div class="project-meta-row">
            <span class="project-location">Lake Como, Italy</span>
            <span>Completed 2024</span>
          </div>
          <h3 class="project-title">Villa Bellissima Belvedere</h3>
          <p class="project-desc">
            Historic 19th-century waterfront restoration integrating subterranean thermal spa and seismic reinforcement.
          </p>
          <div class="project-specs">
            <div class="spec-item">Area: <span>18,500 sq. ft.</span></div>
            <div class="spec-item">Scope: <span>Restoration & Expansion</span></div>
          </div>
        </div>
      </article>

      <!-- Project Card 3 -->
      <article class="project-card">
        <div class="project-thumb">
          <span class="project-category-badge">Active Build &bull; 80% Complete</span>
          <img 
            src="https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?auto=format&fit=crop&w=1200&q=85" 
            alt="The Monolith Horizon Estate in Paradise Valley"
            loading="lazy"
          >
        </div>
        <div class="project-details">
          <div class="project-meta-row">
            <span class="project-location">Paradise Valley, Arizona</span>
            <span>Est. Late 2026</span>
          </div>
          <h3 class="project-title">The Monolith Horizon Estate</h3>
          <p class="project-desc">
            Sculptural board-formed concrete and Corten steel sanctuary designed with passive solar cooling and microgrid.
          </p>
          <div class="project-specs">
            <div class="spec-item">Area: <span>11,800 sq. ft.</span></div>
            <div class="spec-item">Scope: <span>Design & Build</span></div>
          </div>
        </div>
      </article>

      <!-- Project Card 4 -->
      <article class="project-card">
        <div class="project-thumb">
          <span class="project-category-badge">Commercial Flagship</span>
          <img 
            src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1200&q=85" 
            alt="The Luminary Headquarters in Mayfair, London"
            loading="lazy"
          >
        </div>
        <div class="project-details">
          <div class="project-meta-row">
            <span class="project-location">Mayfair, London</span>
            <span>Completed 2025</span>
          </div>
          <h3 class="project-title">The Luminary Headquarters</h3>
          <p class="project-desc">
            BREEAM Outstanding corporate flagship featuring Portland stone facade and acoustic confidentiality suites.
          </p>
          <div class="project-specs">
            <div class="spec-item">Area: <span>32,000 sq. ft.</span></div>
            <div class="spec-item">Scope: <span>Commercial General Contracting</span></div>
          </div>
        </div>
      </article>

    </div>

    <div style="text-align: center; margin-top: 60px;">
      <a href="projects.php" class="btn btn-outline-gold">
        <span>View All Projects</span>
      </a>
    </div>

  </div>
</section>

<!-- ==========================================================================
     6. CONSTRUCTION SERVICES
     ========================================================================== -->
<section class="section section-dark" id="services" aria-labelledby="services-heading">
  <div class="container">
    
    <div class="section-header-row">
      <div class="section-header-col">
        <span class="eyebrow">Comprehensive Capabilities</span>
        <h2 id="services-heading">
          Construction <span class="gold-gradient-text">Services</span>
        </h2>
      </div>
      <p class="section-subtitle">
        Disciplined project execution from architectural schematics through general contracting, mechanical engineering, and master handover.
      </p>
    </div>

    <div class="services-grid">
      
      <!-- Service 1 -->
      <div class="service-card">
        <div>
          <div class="service-num">01</div>
          <h3 class="service-title">Residential Construction</h3>
          <p class="service-desc">
            Custom ground-up estates, architectural villas, and private multi-structure residential compounds built to generational standards.
          </p>
          <ul class="service-features">
            <li>Post-tensioned concrete and structural steel</li>
            <li>Zero-tolerance interior millwork installation</li>
            <li>Acoustic isolation & climate-controlled sanctuaries</li>
          </ul>
        </div>
        <a href="services.php#residential" class="link-arrow">Explore Residential</a>
      </div>

      <!-- Service 2 -->
      <div class="service-card">
        <div>
          <div class="service-num">02</div>
          <h3 class="service-title">Commercial Construction</h3>
          <p class="service-desc">
            Trophy corporate headquarters, boutique luxury hotels, and private family office flagships engineered for discretion and prestige.
          </p>
          <ul class="service-features">
            <li>BREEAM & LEED Platinum energy compliance</li>
            <li>High-security building envelopes & access systems</li>
            <li>Complex MEP and advanced building automation</li>
          </ul>
        </div>
        <a href="services.php#commercial" class="link-arrow">Explore Commercial</a>
      </div>

      <!-- Service 3 -->
      <div class="service-card">
        <div>
          <div class="service-num">03</div>
          <h3 class="service-title">Design & Build</h3>
          <p class="service-desc">
            A single, unified contract uniting licensed architecture, computational engineering, and master general contracting from day one.
          </p>
          <ul class="service-features">
            <li>3D BIM coordination & solar-path simulations</li>
            <li>Elimination of costly change orders & delays</li>
            <li>Seamless translation from concept to finished structure</li>
          </ul>
        </div>
        <a href="services.php#design-build" class="link-arrow">Explore Design & Build</a>
      </div>

      <!-- Service 4 -->
      <div class="service-card">
        <div>
          <div class="service-num">04</div>
          <h3 class="service-title">Renovation & Restoration</h3>
          <p class="service-desc">
            Historic preservation of landmark estates, seismic retrofits, structural modernizations, and haute interior architectural transformations.
          </p>
          <ul class="service-features">
            <li>Archaeological fabric conservation & masonry</li>
            <li>Concealed modern MEP & geothermal integration</li>
            <li>Municipal landmark board expediting & compliance</li>
          </ul>
        </div>
        <a href="services.php#renovation" class="link-arrow">Explore Renovation</a>
      </div>

      <!-- Service 5 -->
      <div class="service-card">
        <div>
          <div class="service-num">05</div>
          <h3 class="service-title">Project Management</h3>
          <p class="service-desc">
            Independent client representation, feasibility studies, international procurement, cost engineering, and on-site quality oversight.
          </p>
          <ul class="service-features">
            <li>Guaranteed Maximum Price (GMP) governance</li>
            <li>Bi-weekly 3D LiDAR point-cloud quality scans</li>
            <li>Vendor vetting and international logistics management</li>
          </ul>
        </div>
        <a href="services.php#project-mgmt" class="link-arrow">Explore Project Management</a>
      </div>

      <!-- Service 6 / Action Card -->
      <div class="service-card" style="border-color: var(--border-gold); background: linear-gradient(135deg, var(--bg-surface) 0%, #1c1e28 100%);">
        <div>
          <div class="service-num" style="opacity: 1; color: var(--accent-gold-light);">CTA</div>
          <h3 class="service-title">Have a Custom Build in Mind?</h3>
          <p class="service-desc">
            Our principal architects and master builders are available for direct confidential feasibility assessments.
          </p>
        </div>
        <div style="margin-top: 24px;">
          <a href="contact.php" class="btn btn-primary" style="width: 100%;">
            <span>Consult an Expert</span>
          </a>
        </div>
      </div>

    </div>

  </div>
</section>

<!-- ==========================================================================
     7. WHY CHOOSE US
     ========================================================================== -->
<section class="section section-secondary" id="why-us" aria-labelledby="why-heading">
  <div class="container">
    <div class="why-grid">
      
      <!-- Left Features Stack -->
      <div class="why-content-col">
        <span class="eyebrow">The Aurelia Standard</span>
        <h2 id="why-heading">
          Why Discerning Clients <br>
          <span class="gold-gradient-text">Choose Our Firm</span>
        </h2>
        <p style="margin-bottom: 32px;">
          In luxury real estate and complex construction, uncertainty is unacceptable. We govern every project with mathematical precision, contractual clarity, and artisanal pride.
        </p>

        <div class="why-card-stack">
          
          <div class="why-feature-box">
            <h3 class="why-feature-title">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
              </svg>
              <span>Guaranteed Maximum Price</span>
            </h3>
            <p class="why-feature-text">
              We fix both the capital budget and delivery date before ground is broken, insulating our clients from budget creep and unexpected surprises.
            </p>
          </div>

          <div class="why-feature-box">
            <h3 class="why-feature-title">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <polygon points="12 8 8 12 12 16 16 12 12 8"/>
              </svg>
              <span>Sub-Millimeter Structural Tolerance</span>
            </h3>
            <p class="why-feature-text">
              Our master site superintendents perform bi-weekly 3D LiDAR point-cloud scans to ensure framing, glazing, and stone match engineering drawings within &plusmn;0.8mm.
            </p>
          </div>

          <div class="why-feature-box">
            <h3 class="why-feature-title">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                <polyline points="22 4 12 14.01 9 11.01"/>
              </svg>
              <span>Turnkey Single-Point Accountability</span>
            </h3>
            <p class="why-feature-text">
              No finger-pointing between separate architects, engineers, and builders. Aurelia assumes total responsibility for the final outcome.
            </p>
          </div>

        </div>
      </div>

      <!-- Right Visual Feature -->
      <div class="why-image-wrapper">
        <img 
          src="https://images.unsplash.com/photo-1541888946425-d0fbb186c5f7?auto=format&fit=crop&w=1200&q=85" 
          alt="Precision Construction Craftsmanship"
          loading="lazy"
        >
      </div>

    </div>
  </div>
</section>

<!-- ==========================================================================
     8. OUR PROCESS
     ========================================================================== -->
<section class="section section-dark" id="process" aria-labelledby="process-heading">
  <div class="container">
    
    <div class="section-header-row">
      <div class="section-header-col">
        <span class="eyebrow">Master Methodology</span>
        <h2 id="process-heading">
          Our <span class="gold-gradient-text">Process</span>
        </h2>
      </div>
      <p class="section-subtitle">
        A structured five-stage journey that transforms raw topography into a refined architectural sanctuary with complete predictability.
      </p>
    </div>

    <div class="process-timeline">
      
      <!-- Step 1: Consultation -->
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

      <!-- Step 2: Planning -->
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

      <!-- Step 3: Design -->
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

      <!-- Step 4: Construction -->
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

      <!-- Step 5: Handover -->
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

<!-- ==========================================================================
     9. FEATURED PROPERTIES
     ========================================================================== -->
<section class="section section-secondary" id="properties" aria-labelledby="properties-heading">
  <div class="container">
    
    <div class="section-header-row">
      <div class="section-header-col">
        <span class="eyebrow">Prime Real Estate</span>
        <h2 id="properties-heading">
          Featured <span class="gold-gradient-text">Properties</span>
        </h2>
      </div>
      <p class="section-subtitle">
        Exceptional completed residences and off-market estates curated for acquisition by distinguished private buyers.
      </p>
    </div>

    <div class="properties-grid">
      
      <!-- Property 1 -->
      <article class="property-card">
        <div class="property-thumb">
          <span class="property-status-badge">Available Now</span>
          <span class="property-price-badge">$38,500,000</span>
          <img 
            src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=1200&q=85" 
            alt="The Solstice Pavilion Estate in Beverly Hills"
            loading="lazy"
          >
        </div>
        <div class="property-info">
          <div class="property-location">Beverly Hills, California</div>
          <h3 class="property-title">The Solstice Pavilion</h3>
          <div class="property-amenities">
            <span><strong>14,200</strong> Sq. Ft.</span>
            <span><strong>6</strong> Beds</span>
            <span><strong>9</strong> Baths</span>
          </div>
        </div>
      </article>

      <!-- Property 2 -->
      <article class="property-card">
        <div class="property-thumb">
          <span class="property-status-badge">Off-Market Exclusive</span>
          <span class="property-price-badge">€44,000,000</span>
          <img 
            src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=1200&q=85" 
            alt="Villa Bellissima Belvedere on Lake Como"
            loading="lazy"
          >
        </div>
        <div class="property-info">
          <div class="property-location">Lake Como, Italy</div>
          <h3 class="property-title">Villa Bellissima Belvedere</h3>
          <div class="property-amenities">
            <span><strong>18,500</strong> Sq. Ft.</span>
            <span><strong>8</strong> Beds</span>
            <span><strong>11</strong> Baths</span>
          </div>
        </div>
      </article>

      <!-- Property 3 -->
      <article class="property-card">
        <div class="property-thumb">
          <span class="property-status-badge">Turnkey Complete</span>
          <span class="property-price-badge">$62,000,000</span>
          <img 
            src="https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=1200&q=85" 
            alt="Crown Penthouse at Aurelia Tower in Manhattan"
            loading="lazy"
          >
        </div>
        <div class="property-info">
          <div class="property-location">Upper East Side, New York</div>
          <h3 class="property-title">Crown Triplex Penthouse</h3>
          <div class="property-amenities">
            <span><strong>9,600</strong> Sq. Ft.</span>
            <span><strong>5</strong> Beds</span>
            <span><strong>8</strong> Baths</span>
          </div>
        </div>
      </article>

    </div>

    <div style="text-align: center; margin-top: 60px;">
      <a href="properties.php" class="btn btn-outline-gold">
        <span>Explore All Properties</span>
      </a>
    </div>

  </div>
</section>

<!-- ==========================================================================
     10. TESTIMONIALS
     ========================================================================== -->
<section class="section section-dark" id="testimonials" aria-labelledby="testimonials-heading">
  <div class="container">
    
    <div class="section-header-row" style="justify-content: center; text-align: center;">
      <div>
        <span class="eyebrow" style="justify-content: center;">Client Endorsements</span>
        <h2 id="testimonials-heading">
          Trusted by <span class="gold-gradient-text">Generational Patrons</span>
        </h2>
      </div>
    </div>

    <div class="testimonials-grid">
      
      <!-- Testimonial 1 -->
      <div class="testimonial-card">
        <div>
          <div class="testimonial-quote-mark">&ldquo;</div>
          <p class="testimonial-text">
            Aurelia executed our 14,000 sq. ft. estate in Beverly Hills with mathematical perfection. Delivered on time, precisely on budget, and exceeding every architectural expectation.
          </p>
        </div>
        <div class="testimonial-author">
          <img 
            src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=160&q=80" 
            alt="Harrison V. Sterling" 
            class="author-avatar"
            loading="lazy"
          >
          <div>
            <div class="author-name">Harrison V. Sterling</div>
            <div class="author-title">The Solstice Pavilion, Beverly Hills</div>
          </div>
        </div>
      </div>

      <!-- Testimonial 2 -->
      <div class="testimonial-card">
        <div>
          <div class="testimonial-quote-mark">&ldquo;</div>
          <p class="testimonial-text">
            Restoring an 18th-century waterfront villa on Lake Como without compromising the historical masonry was a feat only Aurelia’s master artisans could achieve.
          </p>
        </div>
        <div class="testimonial-author">
          <img 
            src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=160&q=80" 
            alt="Countess Elena di Marchesi" 
            class="author-avatar"
            loading="lazy"
          >
          <div>
            <div class="author-name">Countess Elena di Marchesi</div>
            <div class="author-title">Villa Bellissima Belvedere, Italy</div>
          </div>
        </div>
      </div>

      <!-- Testimonial 3 -->
      <div class="testimonial-card">
        <div>
          <div class="testimonial-quote-mark">&ldquo;</div>
          <p class="testimonial-text">
            For our Mayfair corporate headquarters, acoustics and structural discretion were paramount. Aurelia engineered a benchmark commercial facility.
          </p>
        </div>
        <div class="testimonial-author">
          <img 
            src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=160&q=80" 
            alt="Sir Arthur Sterling-Knight" 
            class="author-avatar"
            loading="lazy"
          >
          <div>
            <div class="author-name">Sir Arthur Sterling-Knight</div>
            <div class="author-title">The Luminary Headquarters, London</div>
          </div>
        </div>
      </div>

    </div>

  </div>
</section>

<!-- ==========================================================================
     11. STRONG CONSULTATION CTA
     ========================================================================== -->
<section class="section section-secondary" id="consultation-cta" aria-labelledby="cta-heading">
  <div class="container">
    <div class="cta-box">
      <div class="cta-content">
        
        <div class="cta-text-col">
          <span class="eyebrow">Private Advisory</span>
          <h2 id="cta-heading" class="cta-title">
            Planning to Build <br>
            <span class="gold-gradient-text">or Invest?</span>
          </h2>
          <p class="cta-desc">
            Speak directly with our senior architectural partners to discuss site feasibility, capital budgeting, and turnkey construction delivery.
          </p>
        </div>

        <div class="cta-actions">
          <a href="contact.php" class="btn btn-primary" style="text-align: center;">
            <span>Schedule a Consultation</span>
          </a>
          <a href="tel:+18008920199" class="cta-phone-link">
            Or call: <strong>+1 (800) 892-0199</strong>
          </a>
        </div>

      </div>
    </div>
  </div>
</section>

<?php
// Include Reusable Footer
include 'includes/footer.php';
?>
