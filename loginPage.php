
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ΣΥΣΤΗΜΑ ΔΙΑΧΕΙΡΙΣΗΣ ΔΙΠΛΩΜΑΤΙΚΩΝ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <div class="title text-center py-5">
            <h1 class="display-4">Σύστημα Διαχείρισης</h1>
            <h2 class="text-muted mb-4">Διπλωματικών Εργασιών</h2>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <!-- Notice the extra id="loginForm" added -->
                        <form method="get" action="check_credentials.php" id="loginForm">
                            <div class="mb-3">
                                <label for="username" class="form-label fw-bold">Username:</label>
                                <input id="username" class="form-control form-control-lg" type="text" name="name" placeholder="Εισάγετε το username σας"/>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label fw-bold">Password:</label>
                                <input id="password" class="form-control form-control-lg" type="password" name="password" placeholder="Εισάγετε τον κωδικό σας"/>
                            </div>
                            <?php
                           
                                if(isset($_REQUEST['userAuth'])) {
                                
                                    echo '<div class="alert alert-danger">Λάθος username ή κωδικός πρόσβασης.</div>';
                                }
                                if(isset($_REQUEST['illegalRedirection'])){
                                    echo '<div class="alert alert-danger">Αντικανονικό προσπέρασμα χωρις να εχετε συμπληρώσει τη φόρμα</div>';
                                }
                            ?>
                            
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary btn-lg">Σύνδεση</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>