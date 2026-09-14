-- ============================================================================
-- AURELIA | Luxury Real Estate & Architectural Construction
-- Master Database Schema & Initial Seeds
-- MySQL 8+ / MariaDB 10.4+ Compatible
-- Character Set: utf8mb4 | Collation: utf8mb4_unicode_ci
-- ============================================================================

CREATE DATABASE IF NOT EXISTS `aurelia_db` 
  CHARACTER SET utf8mb4 
  COLLATE utf8mb4_unicode_ci;

USE `aurelia_db`;

SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------------------------------------------------------
-- 1. Table: admins
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `role` VARCHAR(50) NOT NULL DEFAULT 'administrator',
  `last_login` TIMESTAMP NULL DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_admins_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 2. Table: projects
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `projects`;
CREATE TABLE `projects` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL UNIQUE,
  `category` VARCHAR(100) NOT NULL,
  `location` VARCHAR(200) NOT NULL,
  `status` VARCHAR(100) NOT NULL,
  `area` VARCHAR(100) NOT NULL,
  `completion_date` VARCHAR(50) NOT NULL,
  `short_description` TEXT NOT NULL,
  `full_description` LONGTEXT NULL,
  `featured_image` VARCHAR(500) NOT NULL,
  `is_featured` TINYINT(1) UNSIGNED DEFAULT 0,
  `sort_order` INT DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_projects_slug` (`slug`),
  INDEX `idx_projects_category` (`category`),
  INDEX `idx_projects_status` (`status`),
  INDEX `idx_projects_featured` (`is_featured`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 3. Table: project_images
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `project_images`;
CREATE TABLE `project_images` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `project_id` INT UNSIGNED NOT NULL,
  `image_url` VARCHAR(500) NOT NULL,
  `caption` VARCHAR(255) NULL,
  `sort_order` INT DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_project_images_proj` (`project_id`, `sort_order`),
  CONSTRAINT `fk_project_images_project` 
    FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) 
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 4. Table: properties
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `properties`;
CREATE TABLE `properties` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL UNIQUE,
  `price` VARCHAR(100) NOT NULL,
  `location` VARCHAR(200) NOT NULL,
  `property_type` VARCHAR(100) NOT NULL,
  `bedrooms` INT UNSIGNED DEFAULT 0,
  `bathrooms` INT UNSIGNED DEFAULT 0,
  `area` VARCHAR(100) NOT NULL,
  `status` VARCHAR(100) NOT NULL,
  `short_description` TEXT NOT NULL,
  `full_description` LONGTEXT NULL,
  `featured_image` VARCHAR(500) NOT NULL,
  `is_featured` TINYINT(1) UNSIGNED DEFAULT 0,
  `sort_order` INT DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_properties_slug` (`slug`),
  INDEX `idx_properties_status` (`status`),
  INDEX `idx_properties_type` (`property_type`),
  INDEX `idx_properties_featured` (`is_featured`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 5. Table: property_images
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `property_images`;
CREATE TABLE `property_images` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `property_id` INT UNSIGNED NOT NULL,
  `image_url` VARCHAR(500) NOT NULL,
  `caption` VARCHAR(255) NULL,
  `sort_order` INT DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_property_images_prop` (`property_id`, `sort_order`),
  CONSTRAINT `fk_property_images_property` 
    FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) 
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 6. Table: services
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `services`;
CREATE TABLE `services` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `service_number` VARCHAR(10) NOT NULL,
  `title` VARCHAR(200) NOT NULL,
  `slug` VARCHAR(200) NOT NULL UNIQUE,
  `short_description` TEXT NOT NULL,
  `full_description` LONGTEXT NULL,
  `icon` VARCHAR(100) NULL,
  `image` VARCHAR(500) NULL,
  `sort_order` INT DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_services_slug` (`slug`),
  INDEX `idx_services_sort` (`sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 7. Table: enquiries
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `enquiries`;
CREATE TABLE `enquiries` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `reference_id` VARCHAR(50) NOT NULL UNIQUE,
  `name` VARCHAR(150) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `phone` VARCHAR(50) NOT NULL,
  `subject` VARCHAR(200) NOT NULL,
  `message` TEXT NOT NULL,
  `property_id` INT UNSIGNED NULL,
  `project_id` INT UNSIGNED NULL,
  `budget_range` VARCHAR(100) NULL,
  `target_location` VARCHAR(200) NULL,
  `status` ENUM('new', 'in_review', 'contacted', 'closed') NOT NULL DEFAULT 'new',
  `ip_address` VARCHAR(45) NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_enquiries_ref` (`reference_id`),
  INDEX `idx_enquiries_status` (`status`),
  INDEX `idx_enquiries_created` (`created_at`),
  CONSTRAINT `fk_enquiries_property` 
    FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) 
    ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_enquiries_project` 
    FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) 
    ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 8. Table: testimonials
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `testimonials`;
CREATE TABLE `testimonials` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `author_name` VARCHAR(150) NOT NULL,
  `author_title` VARCHAR(200) NOT NULL,
  `author_avatar` VARCHAR(500) NULL,
  `quote` TEXT NOT NULL,
  `project_referenced` VARCHAR(200) NULL,
  `rating` TINYINT UNSIGNED DEFAULT 5,
  `is_featured` TINYINT(1) UNSIGNED DEFAULT 1,
  `sort_order` INT DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_testimonials_featured` (`is_featured`, `sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 9. Table: site_settings
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `site_settings`;
CREATE TABLE `site_settings` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `setting_key` VARCHAR(100) NOT NULL UNIQUE,
  `setting_value` TEXT NULL,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_settings_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;


-- ============================================================================
-- INITIAL SEED DATA
-- ============================================================================

-- 1. Default Administrator Account (Password: Admin@Aurelia2026!)
INSERT INTO `admins` (`id`, `name`, `email`, `password_hash`, `role`) VALUES
(1, 'Aurelia Principal Admin', 'admin@aurelia.com', '$2y$10$HsY65R4G7IjpeaZaQhBxq.d.DbHY1fL5RlThqD4EiNsk5K9zo5HtK', 'superadmin')
ON DUPLICATE KEY UPDATE `email` = VALUES(`email`);

-- 2. Initial Projects
INSERT INTO `projects` 
(`id`, `title`, `slug`, `category`, `location`, `status`, `area`, `completion_date`, `short_description`, `full_description`, `featured_image`, `is_featured`, `sort_order`) 
VALUES
(1, 'The Solstice Pavilion', 'the-solstice-pavilion', 'Residential &bull; Turnkey', 'Beverly Hills, California', 'Completed', '14,200 sq. ft.', '2025', 
 'Cantilevered glass and Roman silver travertine residence engineered over a dramatic 270-degree promontory.', 
 'Poised on a private promontory with 270-degree jetliner views of the Los Angeles basin to the Pacific Ocean, The Solstice Pavilion represents the pinnacle of contemporary organic architecture. Built with post-tensioned architectural concrete and diamond-honed Roman travertine.',
 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=1200&q=85', 1, 1),

(2, 'Villa Bellissima Belvedere', 'villa-bellissima-belvedere', 'Heritage Revival', 'Lake Como, Italy', 'Completed', '18,500 sq. ft.', '2024',
 'Historic 19th-century waterfront restoration integrating subterranean thermal spa and seismic reinforcement.',
 'An extraordinary union of 19th-century Lombard stone masonry and cutting-edge 21st-century architectural engineering. Boasting 400 meters of direct lake frontage, private stone boathouse, and helicopter landing pad.',
 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=1200&q=85', 1, 2),

(3, 'The Monolith Horizon Estate', 'the-monolith-horizon-estate', 'Active Build &bull; 80% Complete', 'Paradise Valley, Arizona', 'Under Construction', '11,800 sq. ft.', 'Late 2026',
 'Sculptural board-formed concrete and Corten steel sanctuary designed with passive solar cooling and microgrid.',
 'Currently nearing completion of structural glazing and custom interior millwork. A masterclass in thermal mass engineering, monolithic board-formed concrete walls shield the estate from desert heat while framing dramatic Camelback Mountain vistas.',
 'https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?auto=format&fit=crop&w=1200&q=85', 1, 3),

(4, 'The Luminary Headquarters', 'the-luminary-headquarters', 'Commercial Flagship', 'Mayfair, London', 'Completed', '32,000 sq. ft.', '2025',
 'BREEAM Outstanding corporate flagship featuring Portland stone facade and acoustic confidentiality suites.',
 'A benchmark in high-security, ultra-luxury commercial architecture. Designed for private wealth institutions and family offices requiring uncompromising acoustic confidentiality, BREEAM Outstanding rating, and private executive helipad.',
 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1200&q=85', 1, 4)
ON DUPLICATE KEY UPDATE `title` = VALUES(`title`);

-- 3. Initial Project Images
INSERT INTO `project_images` (`project_id`, `image_url`, `caption`, `sort_order`) VALUES
(1, 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=1600&q=85', 'Exterior Cantilevered Deck', 1),
(1, 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=1600&q=85', 'Great Hall Living Room', 2),
(1, 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1600&q=85', 'Primary Suite Terrace', 3),
(2, 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=1600&q=85', 'Lakefront Stone Masonry Façade', 1),
(2, 'https://images.unsplash.com/photo-1613977257363-707ba9348227?auto=format&fit=crop&w=1600&q=85', 'Restored Grand Receiving Salon', 2),
(3, 'https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?auto=format&fit=crop&w=1600&q=85', 'Desert Monolithic Concrete Structure', 1),
(4, 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1600&q=85', 'Mayfair Portland Stone Façade', 1);

-- 4. Initial Properties
INSERT INTO `properties` 
(`id`, `title`, `slug`, `price`, `location`, `property_type`, `bedrooms`, `bathrooms`, `area`, `status`, `short_description`, `full_description`, `featured_image`, `is_featured`, `sort_order`) 
VALUES
(1, 'The Solstice Pavilion', 'the-solstice-pavilion-property', '$38,500,000', 'Beverly Hills, California', 'Private Estate', 6, 9, '14,200 sq. ft.', 'Available Now',
 'Poised on a private promontory with 270-degree panoramic ocean views, private auto gallery, and zero-edge infinity pool.',
 'Featuring 110-foot zero-edge pool, subterranean climate-controlled 8-vehicle auto gallery, 1,200-bottle glass wine vault, and full biometric security controls.',
 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=1200&q=85', 1, 1),

(2, 'Villa Bellissima Belvedere', 'villa-bellissima-belvedere-property', '€44,000,000', 'Lake Como, Italy', 'Historic Villa', 8, 11, '18,500 sq. ft.', 'Off-Market Exclusive',
 'An extraordinary 19th-century waterfront compound with 400m direct lake frontage, private boathouse, and helicopter pad.',
 'Historic neoclassical estate restored to modern seismic and geothermal perfection. Includes private direct-water covered boathouse with Riva yacht lift and century-old terraced olive groves.',
 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=1200&q=85', 1, 2),

(3, 'Crown Triplex Penthouse', 'crown-triplex-penthouse-property', '$62,000,000', 'Upper East Side, New York', 'Triplex Penthouse', 5, 8, '9,600 sq. ft.', 'Turnkey Complete',
 'Occupying the 74th through 76th floors of Manhattan premier limestone tower with private rooftop terrace and plunge pool.',
 'Features private key-locked high-speed elevator to all three levels, 28-foot double-height great room facing Central Park, Poliform custom chef kitchen, and private master wing.',
 'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=1200&q=85', 1, 3)
ON DUPLICATE KEY UPDATE `title` = VALUES(`title`);

-- 5. Initial Property Images
INSERT INTO `property_images` (`property_id`, `image_url`, `caption`, `sort_order`) VALUES
(1, 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=1600&q=85', 'Main Residence & Heated Infinity Pool', 1),
(1, 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=1600&q=85', 'Double-Height Living Pavilion', 2),
(2, 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=1600&q=85', 'Lakeside Frontage & Gardens', 1),
(3, 'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=1600&q=85', 'Sky Sanctuary Terrace over Central Park', 1);

-- 6. Initial Construction Services
INSERT INTO `services` 
(`id`, `service_number`, `title`, `slug`, `short_description`, `full_description`, `icon`, `image`, `sort_order`)
VALUES
(1, '01', 'Residential Construction', 'residential-construction',
 'Custom ground-up estates, architectural villas, and private multi-structure residential compounds built to generational standards.',
 'Post-tensioned concrete foundations, structural steel frames, zero-tolerance interior millwork installation, acoustic isolation between suites, and museum-grade climate control.',
 'Building2', 'https://images.unsplash.com/photo-1541888946425-d0fbb186c5f7?auto=format&fit=crop&w=1200&q=80', 1),

(2, '02', 'Commercial Construction', 'commercial-construction',
 'Trophy corporate headquarters, boutique luxury hotels, and private family office flagships engineered for discretion and prestige.',
 'BREEAM Outstanding and LEED Platinum energy compliance, TEMPEST-rated confidential meeting suites, high-security building envelopes, and complex MEP automation.',
 'Landmark', 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1200&q=80', 2),

(3, '03', 'Design & Build', 'design-build',
 'A single, unified contract uniting licensed architecture, computational engineering, and master general contracting from day one.',
 'Seamless 3D BIM integration from concept to key handover, eliminating design delays and expensive contractor change orders.',
 'Compass', 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?auto=format&fit=crop&w=1200&q=80', 3),

(4, '04', 'Renovation & Restoration', 'renovation-restoration',
 'Historic preservation of landmark estates, seismic retrofits, structural modernizations, and haute interior architectural transformations.',
 'Conservation of ancient stone masonry and carved woodwork combined with micro-climate HVAC and concealed geothermal heating.',
 'Sparkles', 'https://images.unsplash.com/photo-1513694203232-719a280e022f?auto=format&fit=crop&w=1200&q=80', 4),

(5, '05', 'Project Management', 'project-management',
 'Independent client representation, feasibility studies, international procurement, cost engineering, and on-site quality oversight.',
 'Guaranteed Maximum Price (GMP) enforcement, bi-weekly 3D LiDAR point-cloud scans, vendor audits, and comprehensive client reporting.',
 'ShieldCheck', 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?auto=format&fit=crop&w=1200&q=80', 5)
ON DUPLICATE KEY UPDATE `title` = VALUES(`title`);

-- 7. Initial Testimonials
INSERT INTO `testimonials` 
(`id`, `author_name`, `author_title`, `author_avatar`, `quote`, `project_referenced`, `rating`, `is_featured`, `sort_order`) 
VALUES
(1, 'Harrison V. Sterling', 'Managing Partner, Sterling Capital', 
 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=160&q=80', 
 'Aurelia executed our 14,000 sq. ft. estate in Beverly Hills with mathematical perfection. Delivered on time, precisely on budget, and exceeding every architectural expectation.', 
 'The Solstice Pavilion, Beverly Hills', 5, 1, 1),

(2, 'Countess Elena di Marchesi', 'Heritage Estate Custodian', 
 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=160&q=80', 
 'Restoring an 18th-century waterfront villa on Lake Como without compromising the historical masonry was a feat only Aurelia’s master artisans could achieve.', 
 'Villa Bellissima Belvedere, Italy', 5, 1, 2),

(3, 'Sir Arthur Sterling-Knight', 'Chairman, Knight & Co. Private Bank', 
 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=160&q=80', 
 'For our Mayfair corporate headquarters, acoustics and structural discretion were paramount. Aurelia engineered a benchmark commercial facility.', 
 'The Luminary Headquarters, London', 5, 1, 3)
ON DUPLICATE KEY UPDATE `author_name` = VALUES(`author_name`);

-- 8. Core Site Settings
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES
('site_name', 'AURELIA | Luxury Real Estate & Architectural Construction'),
('contact_phone', '+1 (800) 892-0199'),
('contact_email', 'concierge@aureliabuild.com'),
('headquarters_address', 'Bahnhofstrasse 45, 8001 Zürich, Switzerland'),
('us_studio_address', '9600 Wilshire Blvd, Beverly Hills, CA 90212'),
('uk_studio_address', '12 Berkeley Square, Mayfair, London W1J 6BQ'),
('general_contractor_license', '#C-109284'),
('currency_symbol', '$')
ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
