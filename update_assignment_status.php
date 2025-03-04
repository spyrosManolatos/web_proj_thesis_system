<?php
    session_start();
    $username = $_SESSION['username'];
    
    $status = $_POST['status'];
    $assignmentId = $_POST['assignment_id'];
    
    $host = 'localhost';
    $dbname = 'diplomacy_system';
    $dbUsername = 'root';
    $password = '';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname",$dbUsername, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->prepare("
            UPDATE thesis_assignments
            SET status = :new_status
            WHERE thesis_assignment_id = :getAssignmentId 
        ");
        $stmt->bindParam(":getAssignmentId",$assignmentId,PDO::PARAM_INT);
        $stmt->bindParam(":new_status",$status,PDO::PARAM_STR);
        $stmt->execute();
        echo json_encode(["success" => "true","assignmentId" => $assignmentId,"status" => $status]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["success"=>"false","error" => "database_error: ".$e->getMessage()]);
    }





?>