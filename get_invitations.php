<?php
    session_start();
    $assignmentId = $_GET['assignmentId'];
    $host = 'localhost';
    $dbname = 'diplomacy_system';
    $db_username = 'root';
    $password = '';
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $db_username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->prepare("
        SELECT 
            teacher.name as teacher_name,
            invitation_date,
            response_date,
            invitations.status as answer

        FROM
            committee_invitations as invitations
        INNER JOIN
            teacher ON teacher.teacher_id = invitations.professor_id
        WHERE
            thesis_assignment_id = :assignId;
        "
        );
        $stmt->bindParam(":assignId",$assignmentId,PDO::PARAM_INT);
        $stmt->execute();
        $invitations = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($invitations);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["error"=>"database_error:". $e->getMessage()]);
    }

?>