<?php
    session_start();
    
    // Check if user is not logged in
    if(!isset($_SESSION['username']) || $_SESSION['userType']!="Student"){
        $illegal_redirection = "true";
        header('Location: loginPage.php?illegalRedirection='.$illegal_redirection);
        exit();
    }
    // $username = $_SESSION['username'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ΣΥΣΤΗΜΑ ΔΙΑΧΕΙΡΙΣΗΣ ΔΙΠΛΩΜΑΤΙΚΩΝ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php include "header.php"; ?>
    <div class="container">
        
        <!-- <div class="title text-center py-5">
            <h1 class="display-4">Σύστημα Διαχείρισης</h1>
            <h2 class="text-muted mb-4">Διπλωματικών Εργασιών</h2>
        </div> -->
        
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h3 class="card-title mb-4">Πίνακας Φοιτητή</h3>
                        
                        <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="true">Προφίλ</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="courses-tab" data-bs-toggle="tab" data-bs-target="#courses" type="button" role="tab" aria-controls="courses" aria-selected="false">Μαθήματα</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="grades-tab" data-bs-toggle="tab" data-bs-target="#grades" type="button" role="tab" aria-controls="grades" aria-selected="false">Βαθμοί</button>
                            </li>
                        </ul>
                        
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <div id="profileContent" class="text-center py-5 text-muted">
                                    <div class="spinner-border" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <p class="mt-2">Φόρτωση προφίλ...</p>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="courses" role="tabpanel" aria-labelledby="courses-tab">
                                <div class="p-4 text-center text-muted">
                                    <p>Τα μαθήματά σας θα εμφανιστούν εδώ.</p>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="grades" role="tabpanel" aria-labelledby="grades-tab">
                                <div class="p-4 text-center text-muted">
                                    <p>Οι βαθμοί σας θα εμφανιστούν εδώ.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Load the profile data when the page loads
            loadStudentProfile();
            
            function loadStudentProfile() {
                const profileContent = document.getElementById('profileContent');
                
                const xhr = new XMLHttpRequest();
                
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            try {
                                const studentData = JSON.parse(xhr.responseText);
                                displayStudentProfile(studentData);
                            } catch (e) {
                                profileContent.innerHTML = '<div class="alert alert-danger">Σφάλμα φόρτωσης δεδομένων. Παρακαλώ ανανεώστε τη σελίδα.</div>';
                                console.error('JSON parsing error:', e);
                            }
                        } else {
                            profileContent.innerHTML = '<div class="alert alert-danger">Αποτυχία φόρτωσης προφίλ. Παρακαλώ ανανεώστε τη σελίδα.</div>';
                        }
                    }
                };
                
                // parameters are session variables
                xhr.open('GET', 'get_student_profile_data.php', true);
                xhr.send();
            }
            
            function displayStudentProfile(student) {
                const profileContent = document.getElementById('profileContent');
                
                // if (!student) {
                //     profileContent.innerHTML = '<div class="alert alert-danger">Δεν βρέθηκαν δεδομένα προφίλ.</div>';
                //     return;
                // }
                
                // Create the profile HTML with Bootstrap styling
                let html = `
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">${student.name || 'Όνομα Φοιτητή'}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-4 text-muted">Username:</div>
                                <div class="col-md-8">${student.username || 'Μη διαθέσιμο'}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4 text-muted">ID Φοιτητή:</div>
                                <div class="col-md-8">${student.student_id || 'Μη διαθέσιμο'}</div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Προσωπικές Πληροφορίες</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-4 text-muted">Email:</div>
                                <div class="col-md-8">${student.email || 'Μη διαθέσιμο'}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4 text-muted">Τηλέφωνο:</div>
                                <div class="col-md-8">${student.mobile_phone || 'Μη διαθέσιμο'}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4 text-muted">Περιοχή:</div>
                                <div class="col-md-8">${student.area || 'Μη διαθέσιμο'}</div>
                            </div>
                        </div>
                    </div>
                `;
                
                profileContent.innerHTML = html;
            }
        });
    </script>
</body>
</html>