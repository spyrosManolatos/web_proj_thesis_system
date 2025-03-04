<?php
// get_thesis_list.php - Returns a list of thesis topics for the current teacher

// Set header to return JSON
header('Content-Type: application/json');

// Start session to access the username
session_start();

// Verify the teacher is logged in
if (!isset($_SESSION['username']) || $_SESSION['userType'] != "teacher") {
    http_response_code(401); // Unauthorized
    echo json_encode(['error' => 'Not logged in or not a teacher']);
    exit;
}

// Get the username from the session
$username = $_SESSION['username'];

// Database connection parameters
$host = 'localhost';
$dbname = 'diplomacy_system'; 
$db_username = 'root';
$password = '';

try {
    // Create a PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $db_username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    
    // Fetch all thesis topics for this supervisor
    $stmt = $pdo->prepare("
        SELECT 
            id,
            title,
            description,
            pdf_file_path
        FROM 
            thesis_topics
        INNER JOIN
            teacher on supervisor_id=teacher_id
        INNER JOIN
            user_det on user=username
        WHERE 
            user_det.USER = :supervisor_id
        ORDER BY 
            id DESC
    ");
    
    $stmt->bindParam(':supervisor_id', $_SESSION['username'], PDO::PARAM_STR);
    $stmt->execute();
    $topics = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Return the list of topics as JSON
    echo json_encode($topics);
    
} catch (PDOException $e) {
    http_response_code(500); // Server error
    echo json_encode(['error' => 'Database error']);
    
    // Log the actual error but don't expose it to users
    error_log('Database error in get_thesis_list.php: ' . $e->getMessage());
}