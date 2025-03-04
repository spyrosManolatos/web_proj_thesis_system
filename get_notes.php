<?php
    session_start();
    $assignmentId = $_GET['assignment_id'];
    $username = $_SESSION['username'];
    $host = 'localhost';
    $dbname = 'diplomacy_system';
    $dbusername = 'root';
    $dbpassword = '';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname",$dbusername,$dbpassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->prepare("
        SELECT
            prof_note,
            note_content,
            date_created,
            title
        FROM
            professor_notes
        INNER JOIN
            teacher
        ON teacher.teacher_id = professor_notes.professor_id
        WHERE
            teacher.username = :t_usr
        ");
        $stmt->bindParam(":t_usr",$username,PDO::PARAM_STR);
        $stmt->execute();
        $prof_notes = $stmt->fetchAll();
        echo json_encode($prof_notes);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["error"=>$e->getMessage()]);
    }

?>