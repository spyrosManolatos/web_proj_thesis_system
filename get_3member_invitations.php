<?php
    session_start();
    $username = $_SESSION['username'];
    $host = 'localhost';
    $dbname = 'diplomacy_system';
    $db_username = 'root';
    $password = '';
    try{
        $pdo = new PDO("mysql:host=$host;dbname=$dbname",$db_username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $fetchproffesorid = $pdo->prepare("
            SELECT teacher_id
            FROM teacher
            WHERE username = :user_username
        
        ");
        $fetchproffesorid->bindParam(":user_username",$username,PDO::PARAM_STR);
        $fetchproffesorid->execute();
        $result = $fetchproffesorid->fetch(PDO::FETCH_ASSOC);
        $prof_id = $result['teacher_id'];

        // Fetch all 3-members invitations for the specific 
        $stmt = $pdo->prepare("
            SELECT 
                invitations.invitation_id,
                supervisor.name as supervisor_name,
                invitations.status,
                thesis_topics.title,
                student.name as student_name
            FROM 
                Committee_Invitations as invitations
            INNER JOIN
                thesis_assignments on
                    invitations.thesis_assignment_id=thesis_assignments.thesis_assignment_id
            INNER JOIN
                thesis_topics
                    on thesis_assignments.topic_id=thesis_topics.id
            INNER JOIN
                teacher as supervisor
                    on supervisor.teacher_id=thesis_topics.supervisor_id
            INNER JOIN
                student 
                    on thesis_assignments.student_id = student.student_id
            WHERE 
                invitations.professor_id = :prof_id 
        ");
        
        $stmt->bindParam(':prof_id', $prof_id, PDO::PARAM_INT);
        $stmt->execute();
        $invitations = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($invitations);
        
    } catch (PDOException $e) {
        http_response_code(500); // Server error
        echo json_encode(['error' => `Database error: `. $e->getMessage()]);
    }



?>