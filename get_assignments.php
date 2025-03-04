<?php
    session_start();
    $status = $_GET["status"];
    $user_username = $_SESSION["username"];
    retrieveFromThesisAssignments($status, $user_username);
    function retrieveFromThesisAssignments($status, $user_username){
        $host = 'localhost';
        $dbname = 'diplomacy_system';
        $db_username = 'root';
        $password = '';
        try{
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $db_username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if($status=="all"){
                $stmt = $pdo->prepare("
                SELECT 
                    assignment_date,
                    examination_date,
                    has_supervisor_put_an_announcement,
                    student.name,
                    thesis_topics.title,
                    thesis_assignments.status,
                    thesis_assignments.thesis_assignment_id
                FROM 
                    thesis_assignments
                INNER JOIN
                    thesis_topics on thesis_topics.id = thesis_assignments.topic_id
                INNER JOIN
                    student on student.student_id = thesis_assignments.student_id
                INNER JOIN 
                    teacher on teacher.teacher_id = thesis_topics.supervisor_id
                WHERE 
                    teacher.username = :supervisor_username;
                ");
                $stmt->bindParam(':supervisor_username', $_SESSION['username'], PDO::PARAM_STR);
            }
            else{
                $stmt = $pdo->prepare("
                    SELECT 
                        assignment_date,
                        examination_date,
                        has_supervisor_put_an_announcement,
                        student.name,
                        thesis_topics.title,
                        thesis_assignments.status,
                        thesis_assignments.thesis_assignment_id
                    FROM 
                        thesis_assignments
                    INNER JOIN
                        thesis_topics on thesis_topics.id = thesis_assignments.topic_id
                    INNER JOIN
                        student on student.student_id = thesis_assignments.student_id
                    INNER JOIN 
                        teacher on teacher.teacher_id = thesis_topics.supervisor_id
                    WHERE 
                        teacher.username =:supervisor_username and status =:my_status;
                ");
                $stmt->bindParam(':supervisor_username', $_SESSION['username'], PDO::PARAM_STR);
                $stmt->bindParam(':my_status', $status, PDO::PARAM_STR);
            }

            
            $stmt->execute();
            $assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Return the list of topics as JSON
            echo json_encode($assignments);
        }catch(PDOException $e){
            http_response_code(500);
            echo json_encode(['error' => 'Database error:'.$e->getMessage()]);
        }

    }
?>