<?php
/**
 * AURELIA | Luxury Real Estate & Architectural Construction
 * Secure Database Configuration & PDO Connection Wrapper
 * Strict Types, utf8mb4, Prepared Statements Only
 */

declare(strict_types=1);

// Database Configuration Constants (Default XAMPP credentials)
defined('DB_HOST') || define('DB_HOST', 'localhost');
defined('DB_PORT') || define('DB_PORT', 3306);
defined('DB_NAME') || define('DB_NAME', 'aurelia_db');
defined('DB_USER') || define('DB_USER', 'root');
defined('DB_PASS') || define('DB_PASS', '');
defined('DB_CHARSET') || define('DB_CHARSET', 'utf8mb4');

class Database
{
    private static ?PDO $instance = null;
    private static bool $connectionAttempted = false;
    private static ?string $lastError = null;

    /**
     * Get the singleton PDO database connection instance.
     * Returns null gracefully if MySQL is not currently running or credentials are wrong.
     */
    public static function getConnection(): ?PDO
    {
        if (self::$instance !== null) {
            return self::$instance;
        }

        if (self::$connectionAttempted && self::$instance === null) {
            return null;
        }

        self::$connectionAttempted = true;

        $dsn = sprintf(
            'mysql:host=%s;port=%d;dbname=%s;charset=%s',
            DB_HOST,
            (int) DB_PORT,
            DB_NAME,
            DB_CHARSET
        );

        $options = [
            // Throw exceptions on error for clean transaction handling
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            // Return rows as associative arrays by default
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            // Disable emulated prepared statements to ensure true server-side prepares
            PDO::ATTR_EMULATE_PREPARES => false,
            // Enforce UTF-8 collation on connection
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4' COLLATE 'utf8mb4_unicode_ci'",
            // Set reasonable timeout
            PDO::ATTR_TIMEOUT => 3,
        ];

        try {
            self::$instance = new PDO($dsn, DB_USER, DB_PASS, $options);
            return self::$instance;
        } catch (PDOException $e) {
            // Log connection error securely without displaying credentials to end users
            self::$lastError = $e->getMessage();
            error_log('[AURELIA DB ERROR] Failed to connect to MySQL: ' . $e->getMessage());
            self::$instance = null;
            return null;
        }
    }

    /**
     * Check if database connection is active.
     */
    public static function isConnected(): bool
    {
        return self::getConnection() !== null;
    }

    /**
     * Get last connection error (for admin diagnostics only).
     */
    public static function getLastError(): ?string
    {
        return self::$lastError;
    }
}

/**
 * Global helper function to retrieve database connection
 */
function getDB(): ?PDO
{
    return Database::getConnection();
}
