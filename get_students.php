<?php
    // fetch students lsit when a teacher wants to take a student list so he can pick the things he wants
    session_start();
    if(!isset($_SESSION['username'])){
        header('Location:loginPage.php');
    }
    $host = "localhost";
    $username_db = "root";
    $database = "diplomacy_system";
    $password = "";
    try{
        $pdo = new PDO("mysql:host=$host;dbname=$database",$username_db, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // in future we are gonna change the students that are availble (they have not assigned thesis)
        $stmt = $pdo->prepare("
            SELECT name
            FROM student
        ");
        $stmt->execute();
        $student_list =$stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($student_list);
    }catch(PDOException $e){
        http_response_code(500);
        echo json_encode(["error"=>"Database error fetching students in upload thesis "]);
            // Log the actual error but don't expose it to users
        error_log('Database error in get_thesis_list.php: ' . $e->getMessage());
    }


?>