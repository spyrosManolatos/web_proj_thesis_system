<?php
    session_start();
    $teacherUsername = $_SESSION['username'];
    $topic_id = $_POST['id'];
    $dbname = 'diplomacy_system';
    $host = 'localhost';
    $dbusername = 'root';
    $password = '';
    
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbusername,$password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);    
        if(!isset($_FILES['pdf_file']['name']) || $_FILES['pdf_file']['name'] == ''){
            $stmt = $pdo->prepare("
            UPDATE thesis_topics
            SET title = :topic_title,
                description = :topic_description
            WHERE id = :thesis_topic_id ");
            $stmt->bindParam(':topic_title',$_POST['title'],PDO::PARAM_STR);
            $stmt->bindParam(':topic_description',$_POST['description'],PDO::PARAM_STR);
            $stmt->bindParam(':thesis_topic_id', $topic_id, PDO::PARAM_INT);
            $stmt->execute();
            echo json_encode(['success'=>true,'message'=>"Successfull update for thesis_assignment:".$topic_id]);

        }
        else{
            $stmt = $pdo->prepare("SELECT pdf_file_path FROM thesis_topics WHERE id = :thesis_topic_id");
            $stmt->bindParam(':thesis_topic_id', $topic_id, PDO::PARAM_INT);
            $stmt->execute();
            $oldPdfPath = $stmt->fetchColumn();

            if ($oldPdfPath && file_exists($oldPdfPath)) {
                unlink($oldPdfPath);
            }
            $stmt = $pdo->prepare("SELECT teacher_id FROM teacher WHERE username = :t_username");
            $stmt->bindParam(':t_username',$teacherUsername, PDO::PARAM_STR);
            $stmt->execute();
            $teacher_id = $stmt->fetchColumn();
            $randomString = bin2hex(random_bytes(8));
            $newPdfPath = "uploads/pdf/teacher$teacher_id/" . $randomString . "_" . basename($_FILES['pdf_file']['name']);
            // $newPdfPath = "uploads/pdf/teacher$teacher_id/pdf/" . basename($_FILES['pdf_file']['name']);
            move_uploaded_file($_FILES['pdf_file']['tmp_name'], $newPdfPath);

            $stmt = $pdo->prepare("
                UPDATE thesis_topics
                SET title = :topic_title,
                    description = :topic_description,
                    pdf_file_path = :pdf_path
                WHERE id = :thesis_topic_id
            ");
            $stmt->bindParam(':topic_title', $_POST['title'], PDO::PARAM_STR);
            $stmt->bindParam(':topic_description', $_POST['description'], PDO::PARAM_STR);
            $stmt->bindParam(':pdf_path', $newPdfPath, PDO::PARAM_STR);
            $stmt->bindParam(':thesis_topic_id', $topic_id, PDO::PARAM_INT);
            $stmt->execute();

            echo json_encode(['success' => true, 'message' => "Successfully updated thesis_assignment(withpdf): " . $topic_id]);
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["success"=>false,"error"=>"db error: ".$e->getMessage()]);
    }

?>