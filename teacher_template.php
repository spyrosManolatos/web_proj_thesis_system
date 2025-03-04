<?php
    session_start();
    
    // Check if user is not logged in or not a teacher
    if(!isset($_SESSION['username'])||$_SESSION['userType']!="teacher"){
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <?php include 'header.php'; ?>
    <div class="container">
        <!-- <div class="title text-center py-5">
            <h1 class="display-4">Σύστημα Διαχείρισης</h1>
            <h2 class="text-muted mb-4">Διπλωματικών Εργασιών</h2>
        </div> -->
        
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h3 class="card-title mb-4">Πίνακας Καθηγητή</h3>
                        
                        <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="thesis-tab" data-bs-toggle="tab" data-bs-target="#thesis" type="button" role="tab" aria-controls="thesis" aria-selected="true">Προσθήκη Θέματος</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="list-tab" data-bs-toggle="tab" data-bs-target="#list" type="button" role="tab" aria-controls="list" aria-selected="false">Λίστα Θεμάτων</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="assign-tab" data-bs-toggle="tab" data-bs-target="#assign" type="button" role="tab" aria-controls="assign" aria-selected="false">Ανάθεση Διπλωματικής</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="assignments-tab" data-bs-toggle="tab" data-bs-target="#assignments" type="button" role="tab" aria-controls="assignments" aria-selected="false">Αναθέσεις</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="invitations-tab" data-bs-toggle="tab" data-bs-target="#invitations" type="button" role="tab" aria-controls="assignments" aria-selected="false">Προσκλήσεις για 3μελή επιτροπή</button>
                            </li>
                        </ul>
                        
                        <div class="tab-content" id="myTabContent">
                            <!-- Thesis Submission Tab -->
                            <div class="tab-pane fade show active" id="thesis" role="tabpanel" aria-labelledby="thesis-tab">
                                <div class="p-4">
                                    <h4 class="mb-4">Υποβολή νέου θέματος διπλωματικής</h4>
                                    
                                    <form id="thesisForm" action="submit_thesis.php" method="post" enctype="multipart/form-data">
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Τίτλος Θέματος</label>
                                            <input type="text" class="form-control" id="title" name="title" required>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Περιγραφή</label>
                                            <textarea class="form-control" id="description" name="description" rows="5"></textarea>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="pdf_file" class="form-label">PDF αρχείο</label>
                                            <input class="form-control" type="file" id="pdf_file" name="pdf_file" accept=".pdf">
                                            <div class="form-text">Προαιρετικά: Ανεβάστε ένα PDF με αναλυτικές πληροφορίες.</div>
                                        </div>
                                        
                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-primary">Υποβολή Θέματος</button>
                                        </div>
                                    </form>
                                    
                                    <div id="thesisSubmitResult" class="mt-3"></div>
                                </div>
                            </div>
                            
                            <!-- List Tab -->
                            <div class="tab-pane fade" id="list" role="tabpanel" aria-labelledby="list-tab">
                                <div class="p-4">
                                    <h4 class="mb-4">Τα θέματα διπλωματικών σας</h4>
                                    <div id="thesisList" class="text-center py-5 text-muted">
                                        <div class="spinner-border" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <p class="mt-2">Φόρτωση θεμάτων...</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Assign Thesis Tab -->
                            <div class="tab-pane fade" id="assign" role="tabpanel" aria-labelledby="assign-tab">
                                <div class="p-4">
                                    <h4 class="mb-4">Ανάθεση θέματος σε φοιτητή</h4>
                                    
                                    <form id="assignThesisForm" action="assign_thesis.php" method="post">
                                        <div class="mb-3">
                                            <label for="topic_id" class="form-label">Θέμα Διπλωματικής</label>
                                            <select class="form-select" id="topic_id" name="topic_id" required>
                                                <option value="" selected disabled>Επιλέξτε θέμα</option>
                                                <!-- Options will be loaded via AJAX -->
                                            </select>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="student_id" class="form-label">Φοιτητής</label>
                                            <select class="form-select" id="student_id" name="student_id" required>
                                                <option value="" selected disabled>Επιλέξτε φοιτητή</option>
                                                <!-- Options will be loaded via AJAX -->
                                            </select>
                                        </div>
                                        
                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-primary">Ανάθεση Διπλωματικής</button>
                                        </div>
                                    </form>
                                    
                                    <div id="assignmentResult" class="mt-3"></div>
                                </div>
                            </div>
                            
                            <!-- Assignments Tab -->
                            <div class="tab-pane fade" id="assignments" role="tabpanel" aria-labelledby="assignments-tab">
                                <div class="p-4">
                                    <h4 class="mb-4">Αναθέσεις Διπλωματικών</h4>
                                    
                                    <div class="mb-3">
                                        <select class="form-select" id="assignmentStatusFilter">
                                            <option value="all" selected>Όλες οι αναθέσεις</option>
                                            <option value="Pending">Εκκρεμείς</option>
                                            <option value="active">Ενεργές</option>
                                            <option value="under_examination">Υπό εξέταση</option>
                                            <option value="complete">Ολοκληρωμένες</option>
                                            <option value="cancelled">Ακυρωμένες</option>
                                        </select>
                                    </div>
                                    
                                    <div id="assignmentsList" class="text-center py-5 text-muted">
                                        <div class="spinner-border" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <p class="mt-2">Φόρτωση αναθέσεων...</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Invitiations for 3-members counclil -->
                            <div class="tab-pane fade" id="invitations" role="tabpanel" aria-labelledby="assignments-tab">
                                <div class="p-4">
                                    <h4 class="mb-4">Προσκλήσεις για 3μελη επιτροπή</h4>
                                    
                                    <div class="mb-3">
                                        <select class="form-select" id="invitationStatusFilter">
                                            <option value="all" selected>Όλες οι προσκλήσεις</option>
                                            <option value="answered">Απαντημένες</option>
                                            <option value="unanswered">Αναπάντητες</option>
                                        </select>
                                    </div>
                                    
                                    <div id="invitationsList" class="text-center py-5 text-muted">
                                        <div class="spinner-border" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <p class="mt-2">Φόρτωση προσκλήσεων...</p>
                                    </div>
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
        function toggleDetails(assignmentId) {
            const detailsRow = document.getElementById(`details-${assignmentId}`);
            const icon = document.getElementById(`icon-${assignmentId}`);
    
            if (detailsRow.style.display === 'none') {
                detailsRow.style.display = 'table-row';
                icon.classList.remove('bi-arrows-angle-expand');
                icon.classList.add('bi-arrows-angle-contract');
            } else {
                detailsRow.style.display = 'none';
                icon.classList.remove('bi-arrows-angle-contract');
                icon.classList.add('bi-arrows-angle-expand');
            }
        }
        function toggleEditForm(topicId) {
            const editForm = document.getElementById(`edit-form-${topicId}`);
            if (editForm.style.display === 'none') {
            editForm.style.display = 'table-row';
            } else {
            editForm.style.display = 'none';
            }
        }
        function viewNoteContent(noteId){
            const noteForm = document.getElementById(`note-content-${noteId}`);
            if (noteForm.style.display === 'none') {
                noteForm.style.display = 'table-row';
            } else {
                noteForm.style.display = 'none';
            }
        }
        function exportAssignments(status,file_format){
            var xhr = new XMLHttpRequest();
            xhr.open('GET', `downloadassignments.php?status=${status}&file_format=${file_format}`, true);
            xhr.responseType = 'blob';

            xhr.onload = function () {
                var blob = xhr.response;
                var url = window.URL.createObjectURL(blob);
                var a = document.createElement('a');
                a.href = url;
                if(file_format==='csv'){
                    a.download = 'data.csv';
                }
                else{
                    a.download = 'data.json';
                }
                
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
            };

            xhr.send();
        }
        document.addEventListener('DOMContentLoaded', function() {
            // Load thesis list when that tab is clicked
            document.getElementById('list-tab').addEventListener('click', function() {
                loadThesisList();
            });
            
            // Load data for assignment form when that tab is clicked
            document.getElementById('assign-tab').addEventListener('click', function() {
                loadAssignmentFormData();
            });
            
            // Load assignments when that tab is clicked
            document.getElementById('assignments-tab').addEventListener('click', function() {
                loadAssignments();
            });
            // Set up invitations
            document.getElementById('invitations-tab').addEventListener('click',function(){
                loadInvitations();
            })
            // Set up the thesis form submission
            document.getElementById('thesisForm').addEventListener('submit', function(e) {
                e.preventDefault();
                submitThesis();
            });
            
            // Set up the assignment form submission
            document.getElementById('assignThesisForm').addEventListener('submit', function(e) {
                e.preventDefault();
                assignThesis();
            });
            
            // Set up assignment status filter
            document.getElementById('assignmentStatusFilter').addEventListener('change', function() {
                loadAssignments();
            });
            
            function loadThesisList() {
                const thesisList = document.getElementById('thesisList');
                
                const xhr = new XMLHttpRequest();
                
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            try {
                                const topics = JSON.parse(xhr.responseText);
                                displayThesisList(topics);
                            } catch (e) {
                                thesisList.innerHTML = '<div class="alert alert-danger">Σφάλμα φόρτωσης δεδομένων. Παρακαλώ ανανεώστε τη σελίδα.</div>';
                                console.error('JSON parsing error:', e);
                            }
                        } else {
                            thesisList.innerHTML = '<div class="alert alert-danger">Αποτυχία φόρτωσης θεμάτων. Παρακαλώ ανανεώστε τη σελίδα.</div>';
                        }
                    }
                };
                
                xhr.open('GET', 'get_thesis_list.php', true);
                xhr.send();
            }
            function loadInvitations(){
                const invitationsList = document.getElementById("invitationsList");
                const xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function(){
                    if(xhr.readyState === 4){
                        if(xhr.status === 200){
                            try{
                                const invitations = JSON.parse(xhr.responseText);
                                displayInvitations(invitations);
                            }catch(e){
                                invitationsList.innerHTML = '<div class="alert alert-danger">Σφάλμα φόρτωσης δεδομένων. Παρακαλώ ανανεώστε τη σελίδα.</div>';

                            }
                        }else {
                            invitationsList.innerHTML = '<div class="alert alert-danger">Αποτυχία φόρτωσης προσκλήσεων. Παρακαλώ ανανεώστε τη σελίδα.</div>';
                        }
                    }
                };
                xhr.open('GET','get_3member_invitations.php',true);
                xhr.send();
            }
            function displayThesisList(topics) {
                const thesisList = document.getElementById('thesisList');
                
                if (!topics || topics.length === 0) {
                    thesisList.innerHTML = '<div class="alert alert-info">Δεν έχετε υποβάλει ακόμα θέματα διπλωματικών.</div>';
                    return;
                }
                
                let html = '<div class="table-responsive"><table class="table table-striped table-hover">';
                html += '<thead><tr>';
                html += '<th>ID</th>';
                html += '<th>Τίτλος</th>';
                html += '<th>Περιγραφή</th>';
                html += '<th>PDF</th>';
                html += '<th>Επεξεργασία</th>'
                html += '</tr></thead><tbody>';
                
                topics.forEach(topic => {
                    html += '<tr>';
                    html += `<td>${topic.id}</td>`;
                    html += `<td>${topic.title || ''}</td>`;
                    html += `<td>${topic.description || ''}</td>`;
                    html += `<td>`;
                    
                    if (topic.pdf_file_path) {
                        // Display both the PDF link and the file path
                        html += `<div>
                            <a href="${topic.pdf_file_path}" target="_blank" class="btn btn-sm btn-primary mb-2">
                                <i class="bi bi-file-pdf"></i> Προβολή PDF
                            </a>
                            <div class="small text-muted" style="word-break: break-all;">
                                ${topic.pdf_file_path}
                            </div>
                        </div>`;
                    } else {
                        html += 'Δεν υπάρχει PDF';
                    }
                    
                    html += `</td>`;
                    html += `<td>
                        <button class="btn btn-sm btn-warning" onclick="toggleEditForm(${topic.id})">
                            <i class="bi bi-pencil-square"></i> Επεξεργασία
                        </button>
                    </td>`;
                    // to be done: edit_thesis_topic.php
                    html += `<tr id="edit-form-${topic.id}" style="display: none;">
                        <td colspan="5">
                            <form id="editThesisForm-${topic.id}">
                                <input type="hidden" name="id" value="${topic.id}">
                                <div class="mb-3">
                                    <label for="title-${topic.id}" class="form-label">Τίτλος Θέματος</label>
                                    <input type="text" class="form-control" id="title-${topic.id}" name="title" value="${topic.title}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="description-${topic.id}" class="form-label">Περιγραφή</label>
                                    <textarea class="form-control" id="description-${topic.id}" name="description" rows="5">${topic.description}</textarea>
                                </div>
                                <div class="mb-4">
                                    <label for="pdf_file-${topic.id}" class="form-label">PDF αρχείο</label>
                                    <input class="form-control" type="file" id="pdf_file-${topic.id}" name="pdf_file" accept=".pdf">
                                    <div class="form-text">Προαιρετικά: Ανεβάστε ένα PDF με αναλυτικές πληροφορίες (αν δε θέλετε να το αλλάξετε, αφήστε το πεδίο ΚΕΝΟ).</div>
                                </div>
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">Αποθήκευση Αλλαγών</button>
                                </div>
                            </form>
                        </td>
                    </tr>`;

                    // Add event listener for form submission after the form is added to the DOM
                    setTimeout(() => {
                        document.getElementById(`editThesisForm-${topic.id}`).addEventListener('submit', function(e) {
                            e.preventDefault();
                            const formData = new FormData(this);
                            const xhr = new XMLHttpRequest();
                            xhr.onreadystatechange = function() {
                                if (xhr.readyState === 4) {
                                    if (xhr.status === 200) {
                                        try {
                                            console.log(xhr.responseText);
                                            const response = JSON.parse(xhr.responseText);
                                            if (response.success) {
                                                alert('Οι αλλαγές αποθηκεύτηκαν με επιτυχία!');
                                                loadThesisList();
                                            } else {
                                                alert('Υπήρξε ένα σφάλμα κατά την αποθήκευση των αλλαγών.');
                                            }
                                        } catch (e) {
                                            alert('Σφάλμα επεξεργασίας απάντησης.');
                                            console.error('JSON parsing error:', e);
                                        }
                                    } else {
                                        alert('Αποτυχία αποθήκευσης αλλαγών. Παρακαλώ προσπαθήστε ξανά.');
                                    }
                                }
                            };
                            xhr.open('POST', `edit_thesis_topic.php?${topic.id}`, true);
                            xhr.send(formData);
                        });
                    }, 0);
                    html += '</tr>';
                });
                
                html += '</tbody></table></div>';
                thesisList.innerHTML = html;
            }
            function displayInvitations(invitations){
                const invitations_list = document.getElementById("invitationsList");
                if(!invitations||invitations.length===0){
                    invitations_list.innerHTML='<div class="alert alert-info">Δεν σας έχουν αποστάλει ακόμα προσκλήσεις για συμμετοχή στη 3μελη απο μαθητές.</div>';
                    return;
                }
                let html = '<div class="table-responsive"><table class="table table-striped table-hover">';
                html += '<thead><tr>';
                html += '<th>ID</th>';
                html += '<th>Όνομα Επιβλέπων</th>';
                html += '<th>Όνομα Μαθητή</th>'
                html += '<th>Περιγραφή</th>';
                html += '<th>Ενέργειες</th>';
                html += '</tr></thead><tbody>';
                
                invitations.forEach(invitation => {
                    html += '<tr>';
                    html += `<td>${invitation.invitation_id}</td>`;
                    html += `<td>${invitation.supervisor_name || ''}</td>`;
                    html += `<td>${invitation.student_name || ''}</td>`;
                    html += `<td>${invitation.title|| ''}</td>`;
                    if(invitation.status==='invited'){
                        html += `
                            <td id="invitation-actions-${invitation.invitation_id}">
                                <button class="btn btn-sm btn-success me-1" onclick="updateInvitationStatus(${invitation.invitation_id}, 'accepted')">
                                    <i class="bi bi-check-circle"></i> Αποδοχή
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="updateInvitationStatus(${invitation.invitation_id}, 'rejected')">
                                    <i class="bi bi-x-circle"></i> Απόρριψη
                                </button>
                            </td>
                        `;
                    }
                    html += `<td>`;
                    
                    html += `</td>`;
                    html += '</tr>';
                });
                
                html += '</tbody></table></div>';
                invitationsList.innerHTML = html;
            }
            function loadAssignmentFormData() {
                // Load thesis topics for the dropdown
                const topicSelect = document.getElementById('topic_id');
                const xhr = new XMLHttpRequest();
                
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        try {
                            const topics = JSON.parse(xhr.responseText);
                            
                            // Clear previous options except the placeholder
                            while (topicSelect.options.length > 1) {
                                topicSelect.remove(1);
                            }
                            
                            // Add options for each topic
                            topics.forEach(topic => {
                                const option = document.createElement('option');
                                option.value = topic.title;
                                option.textContent = topic.title;
                                topicSelect.appendChild(option);
                            });
                        } catch (e) {
                            console.error('Error loading thesis topics:', e);
                        }
                    }
                };
                
                xhr.open('GET', 'get_thesis_list.php', true);
                xhr.send();
                
                // Load students for the dropdown
                const studentSelect = document.getElementById('student_id');
                const studentXhr = new XMLHttpRequest();
                
                studentXhr.onreadystatechange = function() {
                    if (studentXhr.readyState === 4 && studentXhr.status === 200) {
                        try {
                            const students = JSON.parse(studentXhr.responseText);
                            
                            // Clear previous options except the placeholder
                            while (studentSelect.options.length > 1) {
                                studentSelect.remove(1);
                            }
                            
                            // Add options for each student
                            students.forEach(student => {
                                const option = document.createElement('option');
                                option.value = student.name;
                                option.textContent = `${student.name}`;
                                studentSelect.appendChild(option);
                            });
                        } catch (e) {
                            console.error('Error loading students:', e);
                        }
                    }
                };
                
                studentXhr.open('GET', 'get_students.php', true);
                studentXhr.send();
            }
            
            function assignThesis() {
                const assignmentResult = document.getElementById('assignmentResult');
                assignmentResult.innerHTML = `
                    <div class="text-center py-3">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Υποβολή ανάθεσης...</p>
                    </div>
                `;
                
                const formData = new FormData(document.getElementById('assignThesisForm'));
                
                const xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            try {
                                const response = JSON.parse(xhr.responseText);
                                if (response.success) {
                                    assignmentResult.innerHTML = `
                                        <div class="alert alert-success">
                                            ${response.message || 'Η ανάθεση δημιουργήθηκε με επιτυχία!'}
                                        </div>
                                    `;
                                    document.getElementById('assignThesisForm').reset();
                                } else {
                                    assignmentResult.innerHTML = `
                                        <div class="alert alert-danger">
                                            ${response.message || 'Υπήρξε ένα σφάλμα κατά την ανάθεση.'}
                                        </div>
                                    `;
                                }
                            } catch (e) {
                                assignmentResult.innerHTML = '<div class="alert alert-danger">Σφάλμα επεξεργασίας απάντησης.</div>';
                                console.error('JSON parsing error:', e);
                            }
                        } else {
                            assignmentResult.innerHTML = '<div class="alert alert-danger">Αποτυχία υποβολής. Παρακαλώ προσπαθήστε ξανά.</div>';
                        }
                    }
                };
                
                xhr.open('POST', 'assign_thesis.php', true);
                xhr.send(formData);
            }
            
            function loadAssignments() {
                const assignmentsList = document.getElementById('assignmentsList');
                const status = document.getElementById('assignmentStatusFilter').value;
                
                assignmentsList.innerHTML = `
                    <div class="text-center py-3">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Φόρτωση αναθέσεων...</p>
                    </div>
                `;
                
                const xhr = new XMLHttpRequest();
                
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            try {
                                const assignments = JSON.parse(xhr.responseText);
                                displayAssignments(assignments);
                            } catch (e) {
                                assignmentsList.innerHTML = '<div class="alert alert-danger">Σφάλμα φόρτωσης δεδομένων. Παρακαλώ ανανεώστε τη σελίδα.</div>';
                                console.error('JSON parsing error:', e);
                            }
                        } else {
                            assignmentsList.innerHTML = '<div class="alert alert-danger">Αποτυχία φόρτωσης αναθέσεων. Παρακαλώ ανανεώστε τη σελίδα.</div>';
                        }
                    }
                };
                
                xhr.open('GET', `get_assignments.php?status=${status}`, true);
                xhr.send();
            }
            
            function displayAssignments(assignments) {
                const assignmentsList = document.getElementById('assignmentsList');
                const status = document.getElementById('assignmentStatusFilter').value;
                let html = '<div class="d-flex justify-content-center my-3">';
                html += `<button class="btn btn-outline-primary me-2" onclick="exportAssignments('${status}', 'json')">Εξαγωγή σαν JSON</button>`;
                html += `<button class="btn btn-outline-secondary" onclick="exportAssignments('${status}', 'csv')">Εξαγωγή σαν CSV</button>`;
                html += '</div>';
                html += '<div class="table-responsive"><table class="table table-striped table-hover">';
                html += '<thead><tr>';
                html += '<th>ID</th>';
                html += '<th>Θέμα</th>';
                html += '<th>Φοιτητής</th>';
                html += '<th>Ημερομηνία Ανάθεσης</th>';
                html += '<th>Κατάσταση</th>';
                html += '<th>Ενέργειες</th>';
                html += '<th></th>';
                html += '</tr></thead><tbody>';
                
                assignments.forEach(assignment => {
                    let statusBadge = '';
                    console.log(assignment.status);
                    switch(assignment.status) {
                        case 'Pending':
                            statusBadge = '<span class="badge bg-warning text-dark">Εκκρεμής</span>';
                            break;
                        case 'Active':
                            statusBadge = '<span class="badge bg-primary">Ενεργή</span>';
                            break;
                        case 'Under Examination':
                            statusBadge = '<span class="badge bg-info">Υπό Εξέταση</span>';
                            break;
                        case 'Complete':
                            statusBadge = '<span class="badge bg-success">Ενεργή</span>';
                            break;
                        case 'Cancelled':
                            statusBadge = '<span class="badge bg-danger">Ακυρωμένη</span>';
                            break;
                        default:
                            statusBadge = '<span class="badge bg-secondary">Άγνωστη</span>';
                    }
                    
                    html += '<tr>';
                    html += `<td>${assignment.thesis_assignment_id}</td>`;
                    html += `<td>${assignment.title}</td>`;
                    html += `<td>${assignment.name}</td>`;
                    html += `<td>${assignment.assignment_date}</td>`;
                    html += `<td>${statusBadge}</td>`;
                    html += `<td>`;
                    
                    // Show different action buttons based on status
                    if (assignment.status === 'Pending') {
                        html += `<button class="btn btn-sm btn-danger me-1" onclick="updateAssignmentStatus(${assignment.thesis_assignment_id}, 'Cancelled')">
                            <i class="bi bi-x-circle"></i> Ακύρωση
                        </button>`;
                    } else if (assignment.status === 'Active') {
                        html += `<button class="btn btn-sm btn-info" onclick="updateAssignmentStatus(${assignment.thesis_assignment_id}, 'Under Examination')">
                            <i class="bi bi-clipboard-check"></i> Προς Εξέταση
                        </button>`;
                    }

                    html += `</td>`;
                    html += `<td>`;
                    html += `<button class="btn btn-sm btn-secondary" onclick="toggleDetails(${assignment.thesis_assignment_id})">
                        <i class="bi bi-arrows-angle-expand" id="icon-${assignment.thesis_assignment_id}"></i>
                    </button>`;
                    html += `</td>`;
                    html += '</tr>';
                    // Details row (initially hidden)
                    html += `<tr id="details-${assignment.thesis_assignment_id}" style="display: none;">`;
                    html += `<td colspan="7">`;
                    html += `<div class="card">`;
                    html += `<div class="card-body">`;
                    html += `<h5 class="card-title">Λεπτομέρειες Ανάθεσης</h5>`;
                
                    if(assignment.status === 'Pending'){
                        // If you have committee members, you can show them here
                        html += `<p><strong>Μέλη Τριμελούς:</strong></p>`;
                        html += `<div class="table-responsive text-center"><table class="table table-striped table-hover" >`;
                        html += `<thead><tr>`;
                        html += `<th>Όνομα Καθηγητή</th>`;
                        html += `<th>Ημερομηνία Πρόσκλησης</th>`;
                        html += `<th>Ημερομηνία Απάντησης</th>`;
                        html += `<th>Απάντηση</th>`;
                        html += `</tr></thead>`;
                        html += `<tbody id="invitation-table-${assignment.thesis_assignment_id}">`;
                        html += `<tr><td colspan="4" class="text-center"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Φόρτωση...</span></div> Φόρτωση δεδομένων...</td></tr>`;
                          html += `</tbody></table></div>`;
                                                    
                        
                        setTimeout(() => {
                            const xhr = new XMLHttpRequest();
                            xhr.onreadystatechange = function(){
                                if(xhr.readyState === 4){
                                    if(xhr.status == 200){
                                        try {
                                            const response_of_invitation = JSON.parse(xhr.responseText);
                                            let invitationsHtml = '';
                                            
                                            if (response_of_invitation && response_of_invitation.length > 0) {
                                                response_of_invitation.forEach(response => {
                                                    invitationsHtml += `<tr>`;
                                                    invitationsHtml += `<td>${response.teacher_name}</td>`;
                                                    invitationsHtml += `<td>${response.invitation_date}</td>`;
                                                    invitationsHtml += `<td>${response.response_date || 'Δεν έχει απαντήσει ακόμα'}</td>`;
                                                    invitationsHtml += `<td>${response.answer || 'Δεν έχει απαντήσει ακόμα'}</td>`;
                                                    invitationsHtml += `</tr>`;
                                                });
                                            } else {
                                                invitationsHtml += `<tr><td colspan="4" class="text-center text-muted">Δεν έχουν οριστεί ακόμα μέλη τριμελούς επιτροπής</td></tr>`;
                                            }
                                            
                                            // Find the table body and add the rows to it
                                            const tableId = `invitation-table-${assignment.thesis_assignment_id}`;
                                            document.getElementById(tableId).innerHTML = invitationsHtml;
                                        } catch (e) {
                                            console.error(e);
                                            document.getElementById(`invitation-table-${assignment.thesis_assignment_id}`).innerHTML = 
                                                `<tr><td colspan="4" class="text-center text-danger">Σφάλμα φόρτωσης δεδομένων</td></tr>`;
                                        }
                                    }
                                }
                            };
                            xhr.open('GET',`get_invitations.php?assignmentId=${assignment.thesis_assignment_id}`,true);
                            xhr.send();
                            

                        }, 100); // Give the AJAX request time to complete
                    }
                    else if(assignment.status === 'Active'){
                        // Define notesHtml outside with a loading indicator
                        // let notesHtml = `<tr>
                        //     <td colspan="2" class="text-center">
                        //         <div class="spinner-border text-primary" role="status">
                        //             <span class="visually-hidden">Φόρτωση...</span>
                        //         </div>
                        //     </td>
                        // </tr>`;
                        
                        // Create the HTML with the table structure first
                        html += `<div class="row">
                                    <div class="col-md-6">
                                        <h5>Υποβολή Σημειώσεων</h5>
                                        <form id="notesForm-${assignment.thesis_assignment_id}">
                                            <div class="mb-3">
                                                <label for="title-${assignment.thesis_assignment_id}" class="form-label">Τίτλος</label>
                                                <input type="text" class="form-control" id="title-${assignment.thesis_assignment_id}" name="title" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="notes-${assignment.thesis_assignment_id}" class="form-label">Σημειώσεις</label>
                                                <textarea class="form-control" id="notes-${assignment.thesis_assignment_id}" name="notes" rows="5" required></textarea>
                                            </div>
                                            <div class="d-grid gap-2">
                                                <button type="submit" class="btn btn-primary">Υποβολή Σημειώσεων</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-6">
                                        <h5>Προβολή Σημειώσεων</h5>
                                        <div id="notesDisplay-${assignment.thesis_assignment_id}" class="border p-3">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Τίτλος</th>
                                                            <th>Ημερομηνία Δημιουργίας</th>
                                                            <th>Ενέργειες</th>
                                                        </tr>
                                                    </thead>
                                                        <tbody id="notesTableBody-${assignment.thesis_assignment_id}">
                                                        <tr><td colspan="3" class="text-center"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Φόρτωση...</span></div> Φόρτωση δεδομένων...</td></tr>
                                                        </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>`;

                        html += `<div class="row mt-4">
                                    <div class="col-md-12">
                                        <h5>Τριμελής Επιτροπή</h5>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Όνομα Καθηγητή</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="committeeTableBody-${assignment.thesis_assignment_id}">
                                                    <tr><td colspan="4" class="text-center"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Φόρτωση...</span></div> Φόρτωση δεδομένων...</td></tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>`;
                        (function(assignmentId){
                            setTimeout(() => {
                                const committeMembersTableBody = document.getElementById(`committeeTableBody-${assignmentId}`);
                                if(!committeMembersTableBody){
                                    console.error("No committe mebers found!");
                                    return;
                                }
                                const xhrCommitteeMembers = new XMLHttpRequest();
                                xhrCommitteeMembers.onreadystatechange = function(){
                                    if(xhrCommitteeMembers.readyState === 4){
                                        if(xhrCommitteeMembers.status === 200){
                                            try {
                                                if(xhrCommitteeMembers.responseText){
                                                    const members = JSON.parse(xhrCommitteeMembers.responseText);
                                                    if(members && members.length >0){
                                                        let updatedMembersHtml = '';
                                                        members.forEach(member => {
                                                            if(member.is_supervisor){
                                                                updatedMembersHtml += `<tr>
                                                                    <td>${member.teacher_name}(επιβλέπων)</td>
                                                                </tr>`;
                                                            }
                                                            else{
                                                                updatedMembersHtml += `<tr>
                                                                    <td>${member.teacher_name}</td>
                                                                </tr>`;
                                                            }
                                                            
                                                        });
                                                        committeMembersTableBody.innerHTML = updatedMembersHtml;
                                                    }
                                                    else{
                                                        committeMembersTableBody.innerHTML = '<tr><td colspan="4" class="text-center text-muted">Δεν έχουν οριστεί ακόμα μέλη τριμελούς επιτροπής</td></tr>';
                                                    }
                                                }
                                            } catch (error) {
                                                console.error(error);
                                            }
                                        }
                                        else {
                                            console.log("Empty response");
                                            committeMembersTableBody.innerHTML = '<tr><td colspan="4" class="text-center text-muted">Δεν έχουν οριστεί ακόμα μέλη τριμελούς επιτροπής</td></tr>';
                                        }
                                    }
                                };
                                xhrCommitteeMembers.open('GET', `get_committee_members.php?assignment_id=${assignmentId}`, true);
                                xhrCommitteeMembers.send();
                            }, 100);
                            
                        })(assignment.thesis_assignment_id);
                        // After HTML is added to the page, fetch the notes
                        (function(assignmentId) {
                            setTimeout(() => {
                                const notesTableBody = document.getElementById(`notesTableBody-${assignmentId}`);
                                if (!notesTableBody) {
                                    console.error(`Table body element not found for assignment ${assignmentId}`);
                                    return;
                                }
                                
                                const xhrNotes = new XMLHttpRequest();
                                xhrNotes.onreadystatechange = function() {
                                    if (xhrNotes.readyState === 4) {
                                        if (xhrNotes.status === 200) {
                                            try {
                                                if (xhrNotes.responseText) {
                                                    const notes = JSON.parse(xhrNotes.responseText);
                                                    
                                                    if (notes && notes.length > 0) {
                                                        let updatedNotesHtml = '';
                                                        
                                                        notes.forEach(note => {
                                                            updatedNotesHtml += `<tr>
                                                                <td>${note.title}</td>
                                                                <td>${note.date_created}</td>
                                                                <td>
                                                                    <button class="btn btn-sm btn-info" onclick="viewNoteContent(${note.prof_note})">
                                                                        <i class="bi bi-eye"></i> Προβολή
                                                                    </button>
                                                                </td>
                                                            </tr>`;
                                                            updatedNotesHtml += `<tr id="note-content-${note.prof_note}" style="display:none;">
                                                                <td colspan="3" class="p-3 bg-light">
                                                                    <div class="card">
                                                                        <div class="card-body">
                                                                            <h6 class="card-subtitle mb-2 text-muted">Περιεχόμενο Σημείωσης</h6>
                                                                            <p>${note.note_content}</p>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>`;

                                                            // Update the view button to show this row
                                                        });
                                                        
                                                        notesTableBody.innerHTML = updatedNotesHtml;
                                                    } else {
                                                        notesTableBody.innerHTML = '<tr><td colspan="2" class="text-center text-muted">Δεν υπάρχουν σημειώσεις.</td></tr>';
                                                    }
                                                } else {
                                                    console.log("Empty response");
                                                    notesTableBody.innerHTML = '<tr><td colspan="2" class="text-center text-muted">Δεν υπάρχουν σημειώσεις.</td></tr>';
                                                }
                                            } catch (e) {
                                                console.error('JSON parsing error:', e);
                                                notesTableBody.innerHTML = '<tr><td colspan="2" class="text-center text-danger">Σφάλμα φόρτωσης σημειώσεων.</td></tr>';
                                            }
                                        } else {
                                            console.error('AJAX request failed with status:', xhrNotes.status);
                                            notesTableBody.innerHTML = '<tr><td colspan="2" class="text-center text-danger">Αποτυχία φόρτωσης σημειώσεων.</td></tr>';
                                        }
                                    }
                                };
                                
                                xhrNotes.open('GET', `get_notes.php?assignment_id=${assignmentId}`, true);
                                xhrNotes.send();
                                
                                // Set up form submission handler
                                const form = document.getElementById(`notesForm-${assignmentId}`);
                                if (form) {
                                    form.addEventListener('submit', function(e) {
                                        e.preventDefault();
                                        const formData = new FormData(this);
                                        const xhr = new XMLHttpRequest();
                                        xhr.onreadystatechange = function() {
                                            if (xhr.readyState === 4) {
                                                if (xhr.status === 200) {
                                                    try {
                                                        const response = JSON.parse(xhr.responseText);
                                                        if (response.success) {
                                                            alert('Οι σημειώσεις υποβλήθηκαν με επιτυχία!');
                                                            
                                                            // Clear the textarea
                                                            document.getElementById(`notes-${assignmentId}`).value = '';
                                                            
                                                            // Reload notes
                                                            notesTableBody.innerHTML = `<tr>
                                                                <td colspan="2" class="text-center">
                                                                    <div class="spinner-border text-primary" role="status">
                                                                        <span class="visually-hidden">Φόρτωση...</span>
                                                                    </div>
                                                                </td>
                                                            </tr>`;
                                                            
                                                            const reloadXhr = new XMLHttpRequest();
                                                            reloadXhr.onreadystatechange = function() {
                                                                if (reloadXhr.readyState === 4 && reloadXhr.status === 200) {
                                                                    try {
                                                                        const reloadedNotes = JSON.parse(reloadXhr.responseText);
                                                                        
                                                                        if (reloadedNotes && reloadedNotes.length > 0) {
                                                                            let reloadedNotesHtml = '';
                                                                            reloadedNotes.forEach(note => {
                                                                                reloadedNotesHtml += `<tr><td>${note.note_content}</td><td>${note.date_created}</td></tr>`;
                                                                            });
                                                                            notesTableBody.innerHTML = reloadedNotesHtml;
                                                                        } else {
                                                                            notesTableBody.innerHTML = '<tr><td colspan="2" class="text-center text-muted">Δεν υπάρχουν σημειώσεις.</td></tr>';
                                                                        }
                                                                    } catch (e) {
                                                                        console.error('Error reloading notes:', e);
                                                                        notesTableBody.innerHTML = '<tr><td colspan="2" class="text-center text-danger">Σφάλμα φόρτωσης σημειώσεων.</td></tr>';
                                                                    }
                                                                }
                                                            };
                                                            reloadXhr.open('GET', `get_notes.php?assignment_id=${assignmentId}`, true);
                                                            reloadXhr.send();
                                                        } else {
                                                            alert('Υπήρξε ένα σφάλμα κατά την υποβολή των σημειώσεων.');
                                                        }
                                                    } catch (e) {
                                                        alert('Σφάλμα επεξεργασίας απάντησης.');
                                                        console.error('JSON parsing error:', e);
                                                    }
                                                } else {
                                                    alert('Αποτυχία υποβολής σημειώσεων. Παρακαλώ προσπαθήστε ξανά.');
                                                }
                                            }
                                        };
                                        formData.append('assignment_id', assignmentId);
                                        xhr.open('POST', 'submit_notes.php', true);
                                        xhr.send(formData);
                                    });
                                }
                            }, 100); // Small delay to ensure the DOM is updated
                        })(assignment.thesis_assignment_id);
                    }
                    else if(assignment.status === 'Under Examination'){
                        html += `<div class="row">
                                    <div class="col-md-6">
                                        <h5>Κείμενο Διπλωματικής</h5>
                                        <p>${assignment.thesis_text || 'Δεν έχει υποβληθεί ακόμα κείμενο διπλωματικής.'}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h5>Παρουσίαση Διπλωματικής</h5>
                                        <form id="presentationForm-${assignment.thesis_assignment_id}" enctype="multipart/form-data">
                                            <div class="mb-3">
                                                <label for="presentation-${assignment.thesis_assignment_id}" class="form-label">Ανέβασμα Παρουσίασης</label>
                                                <input type="file" class="form-control" id="presentation-${assignment.thesis_assignment_id}" name="presentation" accept=".pdf,.ppt,.pptx" required>
                                            </div>
                                            <div class="d-grid gap-2">
                                                <button type="submit" class="btn btn-primary">Ανέβασμα Παρουσίασης</button>
                                            </div>
                                        </form>
                                        <div id="presentationDisplay-${assignment.thesis_assignment_id}" class="mt-3">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <h5>Βαθμολογίες Τριμελούς Επιτροπής</h5>
                                        <div id="gradesDisplay-${assignment.thesis_assignment_id}" class="border p-3">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Όνομα</th>
                                                            <th>Βαθμός</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="gradesTableBody-${assignment.thesis_assignment_id}">
                                                        <tr>
                                                            <td colspan="2" class="text-center">
                                                                <div class="spinner-border text-primary" role="status">
                                                                    <span class="visually-hidden">Φόρτωση...</span>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="d-grid gap-2 mt-3">
                                            <button class="btn btn-success" onclick="markAsReadyToGrade(${assignment.thesis_assignment_id})">Έτοιμο για Βαθμολόγηση</button>
                                        </div>
                                        <div class="mt-4">
                                            <h5>Βάλτε τη βαθμολογία σας:</h5>
                                            <form id="gradeForm-${assignment.thesis_assignment_id}">
                                                <div class="mb-3">
                                                    <label for="grade-${assignment.thesis_assignment_id}" class="form-label">Βαθμός (0-10)</label>
                                                    <input type="number" class="form-control" id="grade-${assignment.thesis_assignment_id}" name="grade" min="0" max="10" required>
                                                </div>
                                                <div class="d-grid gap-2">
                                                    <button type="submit" class="btn btn-primary">Υποβολή Βαθμολογίας</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>`;
                                (function(assignmentId){
                            setTimeout(() => {
                                const committeMembersTableBody = document.getElementById(`gradesTableBody-${assignmentId}`);
                                if(!committeMembersTableBody){
                                    console.error("No committe mebers found!");
                                    return;
                                }
                                const xhrCommitteeMembers = new XMLHttpRequest();
                                xhrCommitteeMembers.onreadystatechange = function(){
                                    if(xhrCommitteeMembers.readyState === 4){
                                        if(xhrCommitteeMembers.status === 200){
                                            try {
                                                if(xhrCommitteeMembers.responseText){
                                                    const members = JSON.parse(xhrCommitteeMembers.responseText);
                                                    if(members && members.length >0){
                                                        let updatedMembersHtml = '';
                                                        members.forEach(member => {
                                                            if(member.is_supervisor){
                                                                updatedMembersHtml += `<tr>
                                                                    <td>${member.teacher_name}(επιβλέπων)</td>
                                                                    <td>${member.mark || "προς βαθμολόγηση"}</td>
                                                                </tr>`;
                                                            }
                                                            else{
                                                                updatedMembersHtml += `<tr>
                                                                    <td>${member.teacher_name}</td>
                                                                    <td>${member.mark || "προς βαθμολόγηση"}</td>
                                                                </tr>`;
                                                            }
                                                            
                                                        });
                                                        committeMembersTableBody.innerHTML = updatedMembersHtml;
                                                    }
                                                    else{
                                                        committeMembersTableBody.innerHTML = '<tr><td colspan="4" class="text-center text-muted">Δεν έχουν οριστεί ακόμα μέλη τριμελούς επιτροπής</td></tr>';
                                                    }
                                                }
                                            } catch (error) {
                                                console.error(error);
                                            }
                                        }
                                        else {
                                            console.log("Empty response");
                                            committeMembersTableBody.innerHTML = '<tr><td colspan="4" class="text-center text-muted">Δεν έχουν οριστεί ακόμα μέλη τριμελούς επιτροπής</td></tr>';
                                        }
                                    }
                                };
                                xhrCommitteeMembers.open('GET', `get_committee_members.php?assignment_id=${assignmentId}`, true);
                                xhrCommitteeMembers.send();
                            }, 100);
                            
                        })(assignment.thesis_assignment_id);
                    }
                    
                    else{
                        html += `<p class="text-muted">Under construction</p>`;
                    }
                    
                    html += `</div>`;
                    html += `</div>`;
                    
                    html += `</div>`; // End of card-body
                    html += `</div>`; // End of card
                    html += `</td>`;
                    html += `</tr>`;
                });
                
                html += '</tbody></table></div>';
                assignmentsList.innerHTML = html;
            }
            function submitThesis() {
                const thesisSubmitResult = document.getElementById('thesisSubmitResult');
                thesisSubmitResult.innerHTML = `
                    <div class="text-center py-3">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Υποβολή θέματος...</p>
                    </div>
                `;
                
                const formData = new FormData(document.getElementById('thesisForm'));
                
                const xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            try {
                                const response = JSON.parse(xhr.responseText);
                                if (response.success) {
                                    thesisSubmitResult.innerHTML = `
                                        <div class="alert alert-success">
                                            ${response.message || 'Το θέμα υποβλήθηκε με επιτυχία!'}
                                        </div>
                                    `;
                                    document.getElementById('thesisForm').reset();
                                } else {
                                    thesisSubmitResult.innerHTML = `
                                        <div class="alert alert-danger">
                                            ${response.message || 'Υπήρξε ένα σφάλμα κατά την υποβολή.'}
                                        </div>
                                    `;
                                }
                            } catch (e) {
                                thesisSubmitResult.innerHTML = '<div class="alert alert-danger">Σφάλμα επεξεργασίας απάντησης.</div>';
                                console.error('JSON parsing error:', e);
                            }
                        } else {
                            thesisSubmitResult.innerHTML = '<div class="alert alert-danger">Αποτυχία υποβολής. Παρακαλώ προσπαθήστε ξανά.</div>';
                        }
                    }
                };
                
                xhr.open('POST', 'submit_thesis.php', true);
                xhr.send(formData);
            }
        });
        
        // Function to update assignment status
        function updateAssignmentStatus(assignmentId, newStatus) {
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        // Reload the assignments list after status update
                        document.getElementById('assignments-tab').click();
                    } else {
                        alert('Σφάλμα κατά την ενημέρωση της κατάστασης.');
                    }
                }
            };
            
            xhr.open('POST', 'update_assignment_status.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send(`assignment_id=${assignmentId}&status=${newStatus}`);
        }

        function updateInvitationStatus(invitationId, newStatus) {
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        document.getElementById('invitations-tab').click();
                    } else {
                        alert("unexpected happen in update_invitations_status");
                    }
                }
            };
            
            xhr.open('POST', 'update_invitation_status.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send(`invitation_id=${invitationId}&status=${newStatus}`);
            
            setTimeout(() => {
                const actionsTd = document.getElementById(`invitation-actions-${invitationId}`);
                actionsTd.innerHTML = 'Απαντήσατε: παρακαλώ περιμένετε και τους άλλους!';
            }, 1000);
        }
    </script>
</body>
</html>