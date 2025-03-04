<?php
// session_start();

    
// Check if user is not logged in or not a teacher
// if(!isset($_SESSION['username'])){
//     $illegal_redirection = "true";
//     header('Location: loginPage.php?illegalRedirection='.$illegal_redirection);
//     exit();
// }
// Get username for welcome message
$username = htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8');
?>

<div class="container-fluid bg-primary text-white py-2 mb-4">
    <div class="container">
        <div class="title text-center py-5">
            <h1 class="display-4">Σύστημα Διαχείρισης</h1>
            <h2 class="text-muted mb-4">Διπλωματικών Εργασιών</h2>
        </div>
        <div class="row align-items-center">
            <div class="col-md-6">
                <h5 class="mb-0">Καλώς ήρθατε, <?php echo $username; ?>!</h5>
            </div>
            <div class="col-md-6 text-md-end">
                <form action="logout.php" method="post" class="m-0">
                    <button type="submit" class="btn btn-outline-light btn-sm">
                        <i class="bi bi-box-arrow-right me-1"></i> Αποσύνδεση
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
