<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ΣΥΣΤΗΜΑ ΔΙΑΧΕΙΡΙΣΗΣ ΔΙΠΛΩΜΑΤΙΚΩΝ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<?php
                        
    $name = $_GET["name"];
    $user_password = $_GET["password"];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "diplomacy_system";
                        
    $conn = mysqli_connect($servername,$username,$password,$dbname);
                        
    if ($conn->connect_error) {
        echo "<div class='alert alert-danger'>Connection failed: " . $conn->connect_error . "</div>";
        die();
    }

    $login_query = "SELECT * from user_det where USER='$name' and password='$user_password'";
    $result = $conn->query($login_query);

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $_SESSION["username"] = $row["USER"];
            $_SESSION["userType"] = $row["userType"];
        }
        switch ($_SESSION["userType"]) {
            case 'student':
                header("Location: student_template.php");
                break;
            case 'teacher':
                header("Location: teacher_template.php");
                break;
            case 'secretary':
                header("Location: secretary_template.php");
                break;
            default:
                echo("error:wrong type please wait for help");
                break;
        }
        exit();
    } else {
        $userAuth = "true";
        header('Location: loginPage.php?userAuth='.$userAuth);
        exit();
    }
    ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>