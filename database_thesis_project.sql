-- Create the user_det table
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
    UNIQUE INDEX idx_username (username),
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

-- Create the thesis_topics table
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
    status ENUM('Pending', 'Active', 'Completed', 'Under Examination','Cancelled') NULL,
    student_id INT NULL,
    topic_id INT NULL,
    PRIMARY KEY (thesis_assignment_id),
    FOREIGN KEY (student_id) REFERENCES student(student_id),
    FOREIGN KEY (topic_id) REFERENCES thesis_topics(id)
);

-- Create the committee table
CREATE TABLE committee (
    com_id INT NOT NULL AUTO_INCREMENT,
    avg_mark INT NULL,
    thesis_assignment_id INT NULL,
    PRIMARY KEY (com_id),
    FOREIGN KEY (thesis_assignment_id) REFERENCES thesis_assignments(thesis_assignment_id)
);

-- Create the committee_invitations table
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