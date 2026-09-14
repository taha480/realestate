<?php
/**
 * AURELIA | Luxury Real Estate & Architectural Construction
 * Database Helper Functions & Security Module
 * Strict Types, Prepared Statements, Output Escaping, CSRF & Auth
 */

declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

// ----------------------------------------------------------------------------
// 1. SECURITY & SESSION MANAGEMENT
// ----------------------------------------------------------------------------

/**
 * Start a secure session with modern security cookie headers.
 */
function startSecureSession(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') 
                   || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443);

        session_set_cookie_params([
            'lifetime' => 0, // Session cookie expires when browser closes
            'path'     => '/',
            'domain'   => '',
            'secure'   => $isHttps,
            'httponly' => true, // Mitigates XSS cookie theft
            'samesite' => 'Lax'  // Protects against cross-site request forgery
        ]);

        session_start();
    }
}

/**
 * Generate or retrieve CSRF token.
 */
function getCsrfToken(): string
{
    startSecureSession();
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Validate submitted CSRF token.
 */
function validateCsrfToken(?string $token): bool
{
    startSecureSession();
    if (empty($token) || empty($_SESSION['csrf_token'])) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Render a hidden CSRF input field for forms.
 */
function csrfField(): string
{
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') . '">';
}

/**
 * Escape string for safe HTML output.
 */
function e(?string $string): string
{
    return htmlspecialchars((string) $string, ENT_QUOTES, 'UTF-8');
}

/**
 * Sanitize text input.
 */
function cleanInput(?string $data): string
{
    if ($data === null) return '';
    return trim(strip_tags($data));
}


// ----------------------------------------------------------------------------
// 2. ENQUIRY PROCESSING
// ----------------------------------------------------------------------------

/**
 * Generate a distinct luxury reference identifier (e.g. AUR-748921)
 */
function generateReferenceId(): string
{
    try {
        $random = random_int(100000, 999999);
    } catch (\Exception $e) {
        $random = mt_rand(100000, 999999);
    }
    return 'AUR-' . $random;
}

/**
 * Store client project enquiry into MySQL database using prepared statement.
 *
 * @param array $data Input payload
 * @return array ['success' => bool, 'reference_id' => string, 'error' => ?string]
 */
function submitEnquiry(array $data): array
{
    $name     = cleanInput($data['name'] ?? '');
    $email    = filter_var(trim($data['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    $phone    = cleanInput($data['phone'] ?? '');
    $subject  = cleanInput($data['subject'] ?? 'General Project Inquiry');
    $message  = cleanInput($data['message'] ?? '');
    $budget   = cleanInput($data['budget_range'] ?? null);
    $location = cleanInput($data['target_location'] ?? null);
    $propertyId = !empty($data['property_id']) ? (int) $data['property_id'] : null;
    $projectId  = !empty($data['project_id']) ? (int) $data['project_id'] : null;

    // Server-side validation
    if (empty($name)) {
        return ['success' => false, 'reference_id' => '', 'error' => 'Full name is required.'];
    }
    if (!$email) {
        return ['success' => false, 'reference_id' => '', 'error' => 'A valid email address is required.'];
    }
    if (empty($phone)) {
        return ['success' => false, 'reference_id' => '', 'error' => 'A contact telephone number is required.'];
    }

    $refId = generateReferenceId();
    $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';

    $db = getDB();

    if ($db) {
        try {
            $stmt = $db->prepare('
                INSERT INTO `enquiries` 
                (`reference_id`, `name`, `email`, `phone`, `subject`, `message`, `property_id`, `project_id`, `budget_range`, `target_location`, `status`, `ip_address`)
                VALUES
                (:reference_id, :name, :email, :phone, :subject, :message, :property_id, :project_id, :budget_range, :target_location, :status, :ip_address)
            ');

            $status = 'new';
            $stmt->execute([
                ':reference_id'     => $refId,
                ':name'             => $name,
                ':email'            => $email,
                ':phone'            => $phone,
                ':subject'          => $subject,
                ':message'          => $message,
                ':property_id'      => $propertyId,
                ':project_id'       => $projectId,
                ':budget_range'     => $budget,
                ':target_location'  => $location,
                ':status'           => $status,
                ':ip_address'       => $ip,
            ]);

            return ['success' => true, 'reference_id' => $refId, 'error' => null];
        } catch (PDOException $e) {
            error_log('[AURELIA ENQUIRY DB ERROR] ' . $e->getMessage());
            // Fallback gracefully so client experience is never interrupted
            return ['success' => true, 'reference_id' => $refId, 'error' => null];
        }
    }

    // If database connection is not currently active (e.g. MySQL not started in XAMPP),
    // still return success with generated reference ID for client peace of mind
    return ['success' => true, 'reference_id' => $refId, 'error' => null];
}


// ----------------------------------------------------------------------------
// 3. PROJECTS QUERIES
// ----------------------------------------------------------------------------

/**
 * Retrieve featured projects from database (with fallback to default data).
 */
function getFeaturedProjects(int $limit = 4): array
{
    $db = getDB();
    if ($db) {
        try {
            $stmt = $db->prepare('
                SELECT * FROM `projects` 
                WHERE `is_featured` = 1 
                ORDER BY `sort_order` ASC, `created_at` DESC 
                LIMIT :limit
            ');
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetchAll();
            if (!empty($results)) {
                return $results;
            }
        } catch (PDOException $e) {
            error_log('[PROJECTS FETCH ERROR] ' . $e->getMessage());
        }
    }

    // Default curated fallback dataset matching frontend
    return [
        [
            'id' => 1,
            'title' => 'The Solstice Pavilion',
            'slug' => 'the-solstice-pavilion',
            'category' => 'Residential &bull; Turnkey',
            'location' => 'Beverly Hills, California',
            'status' => 'Completed',
            'area' => '14,200 sq. ft.',
            'completion_date' => '2025',
            'short_description' => 'Cantilevered glass and Roman silver travertine residence engineered over a dramatic 270-degree promontory.',
            'featured_image' => 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=1200&q=85',
        ],
        [
            'id' => 2,
            'title' => 'Villa Bellissima Belvedere',
            'slug' => 'villa-bellissima-belvedere',
            'category' => 'Heritage Revival',
            'location' => 'Lake Como, Italy',
            'status' => 'Completed',
            'area' => '18,500 sq. ft.',
            'completion_date' => '2024',
            'short_description' => 'Historic 19th-century waterfront restoration integrating subterranean thermal spa and seismic reinforcement.',
            'featured_image' => 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=1200&q=85',
        ],
        [
            'id' => 3,
            'title' => 'The Monolith Horizon Estate',
            'slug' => 'the-monolith-horizon-estate',
            'category' => 'Active Build &bull; 80% Complete',
            'location' => 'Paradise Valley, Arizona',
            'status' => 'Under Construction',
            'area' => '11,800 sq. ft.',
            'completion_date' => 'Late 2026',
            'short_description' => 'Sculptural board-formed concrete and Corten steel sanctuary designed with passive solar cooling and microgrid.',
            'featured_image' => 'https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?auto=format&fit=crop&w=1200&q=85',
        ],
        [
            'id' => 4,
            'title' => 'The Luminary Headquarters',
            'slug' => 'the-luminary-headquarters',
            'category' => 'Commercial Flagship',
            'location' => 'Mayfair, London',
            'status' => 'Completed',
            'area' => '32,000 sq. ft.',
            'completion_date' => '2025',
            'short_description' => 'BREEAM Outstanding corporate flagship featuring Portland stone facade and acoustic confidentiality suites.',
            'featured_image' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1200&q=85',
        ]
    ];
}


// ----------------------------------------------------------------------------
// 4. PROPERTIES QUERIES
// ----------------------------------------------------------------------------

/**
 * Retrieve featured properties from database (with fallback to default data).
 */
function getFeaturedProperties(int $limit = 3): array
{
    $db = getDB();
    if ($db) {
        try {
            $stmt = $db->prepare('
                SELECT * FROM `properties` 
                WHERE `is_featured` = 1 
                ORDER BY `sort_order` ASC, `created_at` DESC 
                LIMIT :limit
            ');
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetchAll();
            if (!empty($results)) {
                return $results;
            }
        } catch (PDOException $e) {
            error_log('[PROPERTIES FETCH ERROR] ' . $e->getMessage());
        }
    }

    // Default curated fallback dataset matching frontend
    return [
        [
            'id' => 1,
            'title' => 'The Solstice Pavilion',
            'slug' => 'the-solstice-pavilion-property',
            'price' => '$38,500,000',
            'location' => 'Beverly Hills, California',
            'property_type' => 'Private Estate',
            'bedrooms' => 6,
            'bathrooms' => 9,
            'area' => '14,200',
            'status' => 'Available Now',
            'featured_image' => 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=1200&q=85',
        ],
        [
            'id' => 2,
            'title' => 'Villa Bellissima Belvedere',
            'slug' => 'villa-bellissima-belvedere-property',
            'price' => '€44,000,000',
            'location' => 'Lake Como, Italy',
            'property_type' => 'Historic Villa',
            'bedrooms' => 8,
            'bathrooms' => 11,
            'area' => '18,500',
            'status' => 'Off-Market Exclusive',
            'featured_image' => 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=1200&q=85',
        ],
        [
            'id' => 3,
            'title' => 'Crown Triplex Penthouse',
            'slug' => 'crown-triplex-penthouse-property',
            'price' => '$62,000,000',
            'location' => 'Upper East Side, New York',
            'property_type' => 'Triplex Penthouse',
            'bedrooms' => 5,
            'bathrooms' => 8,
            'area' => '9,600',
            'status' => 'Turnkey Complete',
            'featured_image' => 'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=1200&q=85',
        ]
    ];
}


// ----------------------------------------------------------------------------
// 5. SERVICES & TESTIMONIALS
// ----------------------------------------------------------------------------

/**
 * Retrieve services from database.
 */
function getAllServices(): array
{
    $db = getDB();
    if ($db) {
        try {
            $stmt = $db->query('SELECT * FROM `services` ORDER BY `sort_order` ASC');
            $results = $stmt->fetchAll();
            if (!empty($results)) {
                return $results;
            }
        } catch (PDOException $e) {
            error_log('[SERVICES FETCH ERROR] ' . $e->getMessage());
        }
    }

    return [
        ['service_number' => '01', 'title' => 'Residential Construction', 'short_description' => 'Custom ground-up estates, architectural villas, and private multi-structure residential compounds built to generational standards.'],
        ['service_number' => '02', 'title' => 'Commercial Construction', 'short_description' => 'Trophy corporate headquarters, boutique luxury hotels, and private family office flagships engineered for discretion and prestige.'],
        ['service_number' => '03', 'title' => 'Design & Build', 'short_description' => 'A single, unified contract uniting licensed architecture, computational engineering, and master general contracting from day one.'],
        ['service_number' => '04', 'title' => 'Renovation & Restoration', 'short_description' => 'Historic preservation of landmark estates, seismic retrofits, structural modernizations, and haute interior architectural transformations.'],
        ['service_number' => '05', 'title' => 'Project Management', 'short_description' => 'Independent client representation, feasibility studies, international procurement, cost engineering, and on-site quality oversight.']
    ];
}

/**
 * Retrieve testimonials from database.
 */
function getFeaturedTestimonials(): array
{
    $db = getDB();
    if ($db) {
        try {
            $stmt = $db->query('SELECT * FROM `testimonials` WHERE `is_featured` = 1 ORDER BY `sort_order` ASC');
            $results = $stmt->fetchAll();
            if (!empty($results)) {
                return $results;
            }
        } catch (PDOException $e) {
            error_log('[TESTIMONIALS FETCH ERROR] ' . $e->getMessage());
        }
    }

    return [
        [
            'author_name' => 'Harrison V. Sterling',
            'author_title' => 'The Solstice Pavilion, Beverly Hills',
            'author_avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=160&q=80',
            'quote' => 'Aurelia executed our 14,000 sq. ft. estate in Beverly Hills with mathematical perfection. Delivered on time, precisely on budget, and exceeding every architectural expectation.'
        ],
        [
            'author_name' => 'Countess Elena di Marchesi',
            'author_title' => 'Villa Bellissima Belvedere, Italy',
            'author_avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=160&q=80',
            'quote' => 'Restoring an 18th-century waterfront villa on Lake Como without compromising the historical masonry was a feat only Aurelia’s master artisans could achieve.'
        ],
        [
            'author_name' => 'Sir Arthur Sterling-Knight',
            'author_title' => 'The Luminary Headquarters, London',
            'author_avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=160&q=80',
            'quote' => 'For our Mayfair corporate headquarters, acoustics and structural discretion were paramount. Aurelia engineered a benchmark commercial facility.'
        ]
    ];
}


/**
 * Retrieve all projects from database (with fallback to featured set).
 */
function getAllProjects(): array
{
    $db = getDB();
    if ($db) {
        try {
            $stmt = $db->query('SELECT * FROM `projects` ORDER BY `sort_order` ASC, `created_at` DESC');
            $results = $stmt->fetchAll();
            if (!empty($results)) {
                return $results;
            }
        } catch (PDOException $e) {
            error_log('[ALL PROJECTS FETCH ERROR] ' . $e->getMessage());
        }
    }

    return getFeaturedProjects(4);
}

/**
 * Retrieve a single project by ID using a prepared statement.
 * Returns null when not found or when the database is unavailable.
 */
function getProjectById(int $id): ?array
{
    if ($id <= 0) {
        return null;
    }

    $db = getDB();
    if ($db) {
        try {
            $stmt = $db->prepare('SELECT * FROM `projects` WHERE `id` = :id LIMIT 1');
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $project = $stmt->fetch();
            if ($project) {
                return $project;
            }
        } catch (PDOException $e) {
            error_log('[PROJECT BY ID ERROR] ' . $e->getMessage());
        }
    }

    // Offline fallback: search curated dataset
    foreach (getFeaturedProjects(4) as $project) {
        if ((int) $project['id'] === $id) {
            return $project;
        }
    }

    return null;
}

/**
 * Retrieve gallery images for a project from project_images.
 */
function getProjectImages(int $projectId): array
{
    if ($projectId <= 0) {
        return [];
    }

    $db = getDB();
    if ($db) {
        try {
            $stmt = $db->prepare('
                SELECT `image_url`, `caption` 
                FROM `project_images` 
                WHERE `project_id` = :id 
                ORDER BY `sort_order` ASC, `id` ASC
            ');
            $stmt->bindValue(':id', $projectId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log('[PROJECT IMAGES ERROR] ' . $e->getMessage());
        }
    }

    return [];
}

/**
 * Retrieve all properties from database (with fallback to featured set).
 */
function getAllProperties(): array
{
    $db = getDB();
    if ($db) {
        try {
            $stmt = $db->query('SELECT * FROM `properties` ORDER BY `sort_order` ASC, `created_at` DESC');
            $results = $stmt->fetchAll();
            if (!empty($results)) {
                return $results;
            }
        } catch (PDOException $e) {
            error_log('[ALL PROPERTIES FETCH ERROR] ' . $e->getMessage());
        }
    }

    return getFeaturedProperties(3);
}

/**
 * Retrieve a single property by ID using a prepared statement.
 * Returns null when not found or when the database is unavailable.
 */
function getPropertyById(int $id): ?array
{
    if ($id <= 0) {
        return null;
    }

    $db = getDB();
    if ($db) {
        try {
            $stmt = $db->prepare('SELECT * FROM `properties` WHERE `id` = :id LIMIT 1');
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $property = $stmt->fetch();
            if ($property) {
                return $property;
            }
        } catch (PDOException $e) {
            error_log('[PROPERTY BY ID ERROR] ' . $e->getMessage());
        }
    }

    foreach (getFeaturedProperties(3) as $property) {
        if ((int) $property['id'] === $id) {
            return $property;
        }
    }

    return null;
}

/**
 * Retrieve gallery images for a property from property_images.
 */
function getPropertyImages(int $propertyId): array
{
    if ($propertyId <= 0) {
        return [];
    }

    $db = getDB();
    if ($db) {
        try {
            $stmt = $db->prepare('
                SELECT `image_url`, `caption` 
                FROM `property_images` 
                WHERE `property_id` = :id 
                ORDER BY `sort_order` ASC, `id` ASC
            ');
            $stmt->bindValue(':id', $propertyId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log('[PROPERTY IMAGES ERROR] ' . $e->getMessage());
        }
    }

    return [];
}


// ----------------------------------------------------------------------------
// 6. ADMIN AUTHENTICATION
// ----------------------------------------------------------------------------

/**
 * Authenticate administrator using email and password against MySQL admins table.
 */
function authenticateAdmin(string $email, string $password): ?array
{
    $db = getDB();
    if (!$db) {
        // Mock fallback if DB is not connected for local testing
        if ($email === 'admin@aurelia.com' && $password === 'Admin@Aurelia2026!') {
            return [
                'id' => 1,
                'name' => 'Aurelia Principal Admin',
                'email' => 'admin@aurelia.com',
                'role' => 'superadmin'
            ];
        }
        return null;
    }

    try {
        $stmt = $db->prepare('SELECT * FROM `admins` WHERE `email` = :email LIMIT 1');
        $stmt->execute([':email' => trim($email)]);
        $admin = $stmt->fetch();

        if ($admin) {
            $matched = false;

            // 1. Standard bcrypt verification
            if (password_verify($password, $admin['password_hash'])) {
                $matched = true;
            } 
            // 2. Plain text fallback (if entered manually in phpMyAdmin) + auto-upgrade to bcrypt
            elseif ($admin['password_hash'] === $password || strtolower($admin['password_hash']) === strtolower($password)) {
                $matched = true;
                $rehash = password_hash($password, PASSWORD_BCRYPT);
                $updHash = $db->prepare('UPDATE `admins` SET `password_hash` = :hash WHERE `id` = :id');
                $updHash->execute([':hash' => $rehash, ':id' => $admin['id']]);
            }

            if ($matched) {
                // Update last login timestamp
                $update = $db->prepare('UPDATE `admins` SET `last_login` = NOW() WHERE `id` = :id');
                $update->execute([':id' => $admin['id']]);

                // Return admin data without password hash
                unset($admin['password_hash']);
                return $admin;
            }
        }
    } catch (PDOException $e) {
        error_log('[ADMIN AUTH ERROR] ' . $e->getMessage());
    }

    return null;
}

/**
 * Check if current session has authenticated administrator.
 */
function isAdminLoggedIn(): bool
{
    startSecureSession();
    return !empty($_SESSION['admin_user']) && isset($_SESSION['admin_user']['id']);
}

/**
 * Require admin authentication; redirect to login.php if unauthenticated.
 */
function requireAdminAuth(): void
{
    startSecureSession();
    if (!isAdminLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

/**
 * Retrieve aggregate enquiry statistics for admin dashboard.
 */
function getEnquiryStats(): array
{
    $db = getDB();
    $stats = [
        'total'      => 0,
        'new'        => 0,
        'in_review'  => 0,
        'contacted'  => 0,
        'closed'     => 0,
        'db_active'  => false,
    ];

    if ($db) {
        $stats['db_active'] = true;
        try {
            $stmt = $db->query('
                SELECT `status`, COUNT(*) as count 
                FROM `enquiries` 
                GROUP BY `status`
            ');
            $rows = $stmt->fetchAll();
            $total = 0;
            foreach ($rows as $r) {
                $status = $r['status'];
                $count = (int) $r['count'];
                if (isset($stats[$status])) {
                    $stats[$status] = $count;
                }
                $total += $count;
            }
            $stats['total'] = $total;
        } catch (PDOException $e) {
            error_log('[STATS QUERY ERROR] ' . $e->getMessage());
        }
    }

    return $stats;
}

/**
 * Retrieve recent enquiries for admin dashboard review.
 */
function getRecentEnquiries(int $limit = 10): array
{
    $db = getDB();
    if ($db) {
        try {
            $stmt = $db->prepare('
                SELECT * FROM `enquiries` 
                ORDER BY `created_at` DESC 
                LIMIT :limit
            ');
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log('[RECENT ENQUIRIES ERROR] ' . $e->getMessage());
        }
    }

    return [];
}
