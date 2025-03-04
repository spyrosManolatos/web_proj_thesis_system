<?php
    session_start();
    $assignId = $_POST['assignment_id'];
    $notes = $_POST['notes'];
    $title = $_POST['title'];
    $username = $_SESSION['username'];
    $host = "localhost";
    $dbname = "diplomacy_system";
    $dbusername = "root";
    $password = "";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname",$dbusername,$password);
        $stmt =$pdo->prepare("SELECT teacher_id FROM teacher WHERE username = :usr");
        $stmt->bindParam(":usr",$username,PDO::PARAM_STR);
        $stmt->execute();
        $t_id = $stmt->fetchColumn();
        $stmt = $pdo->prepare("
        INSERT INTO professor_notes(
            assignment_id,
            note_content,
            professor_id,
            title
        )
        values(
            :assign_id,
            :note_content,
            :teacher_id,
            :title
        
        );
        ");
        $stmt->bindParam(":assign_id",$assignId,PDO::PARAM_INT);
        $stmt->bindParam(":note_content",$notes,PDO::PARAM_STR);
        $stmt->bindParam(":teacher_id",$t_id,PDO::PARAM_INT);
        $stmt->bindParam(":title",$title,PDO::PARAM_STR);
        $stmt->execute();
        echo json_encode(["success"=>true]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["error_db"=>$e->getMessage()]);
    }


?>