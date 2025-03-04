<?php
    $st_name = $_POST["student_id"];
    $thesis_topic_name = $_POST["topic_id"];
    $host = "localhost";
    $dbname = "diplomacy_system";
    $dbusername = "root";
    $password = "";
    
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname",$dbusername,$password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // fetch student_id
        $fetchStudentIdStmt = $pdo->prepare("
            SELECT student_id
            FROM student
            WHERE name = :st_usr_name
        ");
        $fetchStudentIdStmt->bindParam(":st_usr_name",$st_name,PDO::PARAM_STR);
        $fetchStudentIdStmt->execute();
        $st_id = $fetchStudentIdStmt->fetch(PDO::FETCH_ASSOC)['student_id'];

        // fetch thesis_topic_id
        $fetchTopicIdStmt = $pdo->prepare("
            SELECT id
            FROM thesis_topics
            WHERE title = :th_topic_usr_title
        ");
        $fetchTopicIdStmt->bindParam(":th_topic_usr_title",$thesis_topic_name,PDO::PARAM_STR);
        $fetchTopicIdStmt->execute();
        $topic_id = $fetchTopicIdStmt->fetch(PDO::FETCH_ASSOC)['id'];
        // insert into thesis_assigments
        $insert_thesis_assignment=$pdo->prepare("
            INSERT INTO thesis_assignments(
                status,
                student_id,
                topic_id
            )
            VALUES(
                :status_pen,
                :st_usr_id,
                :topic_usr_id
            );
        ");
        $status = "pending";
        $insert_thesis_assignment->bindParam(":status_pen",$status,PDO::PARAM_STR);
        $insert_thesis_assignment->bindParam(":st_usr_id",$st_id,PDO::PARAM_INT);
        $insert_thesis_assignment->bindParam(":topic_usr_id",$topic_id,PDO::PARAM_INT);
        $insert_thesis_assignment->execute();
        // success message
        echo json_encode(["success" => true,"message" => "Successfull thesis assignment upload. Wait for student response"]);

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["error_of_db" => $e->getMessage()]);
    }

?>