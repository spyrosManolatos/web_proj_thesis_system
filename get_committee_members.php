<?php
    $assignmentId = $_GET['assignment_id'];
    $host = 'localhost';
    $dbusername = 'root';
    $dbname = 'diplomacy_system';
    $dbpassword = '';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname",$dbusername,$dbpassword);
        $stmt = $pdo->prepare("
            SELECT 
                is_supervisor,
                teacher.name as teacher_name,
                mark
            FROM committee_members
            INNER JOIN teacher
                ON teacher.teacher_id = committee_members.teacher_id
            INNER JOIN committee
                ON committee.com_id = committee_members.com_id
            WHERE committee.thesis_assignment_id = :th_as_id
        
        
        ");
        $stmt->bindParam(":th_as_id",$assignmentId,PDO::PARAM_INT);
        $stmt->execute();
        $invitations = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($invitations);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["error"=>$e->getMessage()]);
    }
?>