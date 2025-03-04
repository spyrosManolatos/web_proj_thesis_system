-- Create the user_details table
CREATE TABLE user_det (
    USER VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    userType ENUM('student', 'teacher', 'secrertary') NULL,
    PRIMARY KEY (USER)
);

-- Create the teacher table
CREATE TABLE teacher (
    teacher_id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL,
    PRIMARY KEY (teacher_id),
    FOREIGN KEY (username) REFERENCES user_det(USER)
);

-- Create the student table
CREATE TABLE student (
    student_id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    area VARCHAR(255) NULL,
    email VARCHAR(255) NULL,
    mobile_phone INT NULL,
    username VARCHAR(255) NOT NULL,
    PRIMARY KEY (student_id),
    UNIQUE INDEX idx_username (username),
    FOREIGN KEY (username) REFERENCES user_det(USER)
);

-- Create the thesis_topics (ta themata twn diplomatikwn) table
CREATE TABLE thesis_topics (
    id INT NOT NULL AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    pdf_file_path VARCHAR(255) NULL,
    supervisor_id INT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (supervisor_id) REFERENCES teacher(teacher_id)
);

-- Create the thesis_assignments table
CREATE TABLE thesis_assignments (
    thesis_assignment_id INT NOT NULL AUTO_INCREMENT,
    assignment_date DATE NULL DEFAULT CURRENT_DATE,
    examination_date DATE NULL,
    has_supervisor_put_an_announcement INT NULL,
    status ENUM('Pending', 'Active', 'Completed', 'Under Examination','Cancelled') NOT NULL,
    student_id INT NOT NULL,
    topic_id INT NOT NULL,
    PRIMARY KEY (thesis_assignment_id),
    FOREIGN KEY (student_id) REFERENCES student(student_id),
    FOREIGN KEY (topic_id) REFERENCES thesis_topics(id)
);

-- Create the committee (ejetash apo 3 atoma metaji aytwn kai o enas kathigitis pou anethese to thema) table
CREATE TABLE committee (
    com_id INT NOT NULL AUTO_INCREMENT,
    avg_mark INT NULL,
    thesis_assignment_id INT NOT NULL,
    PRIMARY KEY (com_id),
    FOREIGN KEY (thesis_assignment_id) REFERENCES thesis_assignments(thesis_assignment_id)
);

-- Create the committee_invitations (o foithths afou tou anatethei h diplomatikh prepei na vrei allous duo kathigites) table
CREATE TABLE committee_invitations (
    invitation_id INT NOT NULL AUTO_INCREMENT,
    invitation_date DATE DEFAULT CURRENT_DATE,
    professor_id INT NOT NULL,
    response_date DATE NULL,
    status ENUM('invited', 'accepted', 'rejected') NOT NULL,
    thesis_assignment_id INT NOT NULL,
    PRIMARY KEY (invitation_id),
    FOREIGN KEY (professor_id) REFERENCES teacher(teacher_id),
    FOREIGN KEY (thesis_assignment_id) REFERENCES thesis_assignments(thesis_assignment_id)
);

-- Create the committee_members table
CREATE TABLE committee_members (
    com_id INT NOT NULL,
    teacher_id INT NOT NULL,
    is_supervisor TINYINT NOT NULL DEFAULT 0,
    mark FLOAT NULL,
    PRIMARY KEY (com_id, teacher_id),
    FOREIGN KEY (com_id) REFERENCES committee(com_id),
    FOREIGN KEY (teacher_id) REFERENCES teacher(teacher_id)
);

-- Create the professor_notes table
CREATE TABLE professor_notes (
    prof_note INT NOT NULL AUTO_INCREMENT,
    title VARCHAR(255) NULL,
    note_content TEXT NULL,
    date_created DATE DEFAULT CURRENT_DATE,
    professor_id INT NOT NULL,
    assignment_id INT NOT NULL,
    PRIMARY KEY (prof_note),
    FOREIGN KEY (professor_id) REFERENCES teacher(teacher_id),
    FOREIGN KEY (assignment_id) REFERENCES thesis_assignments(thesis_assignment_id)
);
INSERT INTO `user_det` (`USER`, `password`, `userType`) VALUES
('st1', '123', 'student'),
('st2', '123', 'student'),
('teacher1', '123', 'teacher'),
('teacher2', '123', 'teacher');

INSERT INTO `thesis_topics` (`id`, `title`, `description`, `pdf_file_path`, `supervisor_id`) VALUES
(1, 'Alignment of 3-D Images of Biological Objects by Estimating Elastic Transformations in Image Pairs and Image Sets', 'This research project is supported by the Operational Program ESPA, (2014-2020). research program.', 'uploads/pdf/teacher1/1741078481_qmyJnxBU_Alignment-of-3-D-Images-of-Biological-Objects-by-Estimating-Elastic-Transformations-in-Image-Pairs-and-Image-Sets.pdf', 1),
(2, 'Ανάπτυξη Μοντέλου Πρακτόρων για τη Βελτιστοποίηση της Διαχείρισης Πλαστικών Αποβλήτων στην Αγροτική Παραγωγή', 'Η εργασία θα αναπτύξει ένα Agent-Based Model (ABM) για τη διαχείριση\r\nπλαστικών αποβλήτων από αγροτικές καλλιέργειες, αξιοποιώντας δεδομένα για τα είδη\r\nκαλλιεργειών, τη χρήση πλαστικών προϊόντων, και τα γεωγραφικά χαρακτηριστικά. Στόχος\r\nείναι η βελτιστοποίηση της συλλογής και ανακύκλωσης πλαστικών αποβλήτων,\r\nπροσομοιώνοντας διαφορετικά σενάρια διάρκειας ζωής πλαστικών και την εφαρμογή\r\nβιοδιασπώμενων υλικών, λαμβάνοντας υπόψη τις οικολογικές επιπτώσεις και τις\r\nκοινωνικοοικονομικές παραμέτρους. (ενδεχομένως να οδηγήσει σε δημοσίευση)\r\n', 'uploads/pdf/teacher2/1741080534_HsxNmgCo_------------.pdf', 2);


INSERT INTO `thesis_assignments` (`thesis_assignment_id`, `assignment_date`, `examination_date`, `has_supervisor_put_an_announcement`, `status`, `student_id`, `topic_id`) VALUES
(6, '2025-03-04', NULL, NULL, 'Pending', 1, 1),
(7, '2025-03-04', NULL, NULL, 'Pending', 2, 2);

INSERT INTO `committee_invitations` (`invitation_id`, `invitation_date`, `professor_id`, `response_date`, `status`, `thesis_assignment_id`) VALUES
(2, '2025-03-04', 1, NULL, 'invited', 7);

INSERT INTO `student` (`student_id`, `name`, `area`, `email`, `mobile_phone`, `username`) VALUES
(1, 'Σπυρίδων Μανωλάτος', 'Ρίο', 'spmanolatos@gmail.com', 13888, 'st1'),
(2, 'Ανδρέας Μαρούδας', 'Ρίο', 'erikos202@gmail.com', 13888, 'st2');

INSERT INTO `teacher` (`teacher_id`, `name`, `username`) VALUES
(1, 'Εμμανουηλ Ψαράκης', 'teacher1'),
(2, 'Κώστας Τσίχλας', 'teacher2');


