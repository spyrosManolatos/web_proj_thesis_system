<?php
// get_profile_data.php - Returns student profile data as JSON using username from session

// Set header to return JSON
header('Content-Type: application/json');

// Start session to access the username
session_start();

// Verify the student is logged in
if (!isset($_SESSION['username'])) {
    http_response_code(401); // Unauthorized
    echo json_encode(['error' => 'Not logged in']);
    exit;
}

// Get the username from the session
$username = $_SESSION['username'];

// Database connection parameters
$host = 'localhost';
$dbname = 'diplomacy_system';
$username_db = 'root';
$password = '';

try {
    // Create a PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username_db, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Prepare the SQL query to fetch student data by joining user and student tables
    $stmt = $pdo->prepare("
        SELECT 
            s.username,
            s.student_id,
            s.name,
            s.email,
            s.mobile_phone,
            s.area
        FROM 
            user_det u
        JOIN 
            student s ON u.USER = s.username
        WHERE 
            u.user = :username
    ");
    
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    $student = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$student) {
        http_response_code(404); // Not found
        echo json_encode(['error' => 'Student not found']);
        exit;
    }
    
    // Return the student data as JSON
    echo json_encode($student);
    
} catch (PDOException $e) {
    http_response_code(500); // Server error
    echo json_encode(['error' => 'Database error']);
    
    // Log the actual error but don't expose it to users
    error_log('Database error in get_profile_data.php: ' . $e->getMessage());
}
?>