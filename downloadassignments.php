<?php
    session_start();
    
    $username = $_SESSION['username'];
    $status = $_GET['status'];
    $file_format = $_GET['file_format'];

    $host = 'localhost';
    $dbusername = 'root';
    $password = '';
    $dbname = 'diplomacy_system';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbusername, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->prepare("SELECT teacher_id FROM teacher WHERE username = :usr");
        $stmt->bindParam(':usr', $username, PDO::PARAM_STR);
        $stmt->execute();
        $t_id = $stmt->fetchColumn();
        if($status==='all'){
            $stmt = $pdo->prepare("
                SELECT
                    assignments.assignment_date,
                    assignments.examination_date,
                    assignments.has_supervisor_put_an_announcement,
                    assignments.status,
                    student.name,
                    topics.title
                FROM thesis_assignments as assignments
                INNER JOIN thesis_topics as topics
                    ON topics.id = assignments.thesis_assignment_id
                INNER JOIN student
                    ON student.student_id = assignments.student_id
                WHERE topics.supervisor_id = :t_id
        ");
            $stmt->bindParam(':t_id',$t_id, PDO::PARAM_STR);
        }
        else{
            $stmt = $pdo->prepare("
                SELECT
                    assignments.assignment_date,
                    assignments.examination_date,
                    assignments.has_supervisor_put_an_announcement,
                    assignments.status,
                    student.name,
                    topics.title
                FROM thesis_assignments as assignments
                INNER JOIN thesis_topics as topics
                    ON topics.id = assignments.thesis_assignment_id
                INNER JOIN student
                    ON student.student_id = assignments.student_id
                WHERE topics.supervisor_id = :t_id AND assignments.status = :status
        ");
            $stmt->bindParam(':t_id',$t_id, PDO::PARAM_STR);
            $stmt->bindParam(':status',$status, PDO::PARAM_STR);
        }
        
        
        $stmt->execute();
        $assignments = $stmt->fetchAll();
        if($file_format === 'json'){
            header('Content-Type: application/json');
            header('Content-Disposition: attachment; filename="data.json"');
            $cleaned_assignments = array_map(function($assignment) {
            return [
                'assignment_date' => $assignment['assignment_date'],
                'examination_date' => $assignment['examination_date'],
                'has_supervisor_put_an_announcement' => $assignment['has_supervisor_put_an_announcement'],
                'status' => $assignment['status'],
                'name' => $assignment['name'],
                'title' => $assignment['title']
            ];
            }, $assignments);
            echo json_encode($cleaned_assignments, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
        elseif($file_format === 'csv'){
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="data.csv"');
            $output = fopen('php://output', 'w');
            fputcsv($output, array('Assignment Date', 'Examination Date', 'Announcement', 'Status', 'Student Name', 'Topic Name'));
            foreach ($assignments as $assignment) {
            fputcsv($output, $assignment);
            }
            fclose($output);
        }
        
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["error"=>"".$e->getMessage()]);
    }
    exit;
?>