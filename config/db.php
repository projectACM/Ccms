<?php
// Start session at the beginning
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Show an instructional message if we're not in a Render environment
if (empty(getenv('RENDER'))) {
    echo "<div style='font-family: sans-serif; padding: 1.5rem; background-color: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; border-radius: 5px; margin: 1rem;'>";
    echo "<b>Configuration Incomplete:</b><br>";
    echo "This application requires a database connection. Please deploy it to a hosting environment like Render and set the following environment variables:<br>";
    echo "<ul>";
    echo "<li><b>DB_HOST:</b> Your MySQL database host (e.g., from Railway).</li>";
    echo "<li><b>DB_NAME:</b> Your database name.</li>";
    echo "<li><b>DB_USER:</b> Your database username.</li>";
    echo "<li><b>DB_PASS:</b> Your database password.</li>";
    echo "<li><b>DB_PORT:</b> Your database port (e.g., 3306).</li>";
    echo "</ul>";
    echo "The application will not function correctly until these are configured.";
    echo "</div>";
}

// Database configuration using environment variables
$db_host = getenv('DB_HOST') ?: 'localhost';
$db_name = getenv('DB_NAME') ?: 'ccms';
$db_user = getenv('DB_USER') ?: 'root';
$db_pass = getenv('DB_PASS') ?: '';
$db_port = getenv('DB_PORT') ?: '3306';

// DSN (Data Source Name)
$dsn = "mysql:host={$db_host};port={$db_port};dbname={$db_name};charset=utf8mb4";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $db_user, $db_pass, $options);
} catch (PDOException $e) {
    // For the public, a generic error is better
    error_log("Database Connection Error: " . $e->getMessage()); // Log the detailed error for the developer
    
    // Display a user-friendly message and stop execution
    // In a real production environment, you might have a prettier error page
    http_response_code(503); // Service Unavailable
    echo "<div style='font-family: sans-serif; padding: 1.5rem; background-color: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; border-radius: 5px; margin: 1rem;'>";
    echo "<b>Database Connection Failed</b><br>";
    echo "We are currently unable to connect to the database. Please try again later.";
    echo "</div>";
    exit; // Stop script execution
}

// Function to check if a user is logged in
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

// Function to protect pages
function protect_page() {
    if (!is_logged_in()) {
        header('Location: login.php');
        exit;
    }
}
