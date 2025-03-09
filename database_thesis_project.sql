-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2025 at 02:53 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `diplomacy_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `committee`
--

CREATE TABLE `committee` (
  `com_id` int(11) NOT NULL,
  `avg_mark` int(11) DEFAULT NULL,
  `thesis_assignment_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `committee`
--

INSERT INTO `committee` (`com_id`, `avg_mark`, `thesis_assignment_id`) VALUES
(1, NULL, 7),
(2, NULL, 8),
(3, NULL, 9);

-- --------------------------------------------------------

--
-- Table structure for table `committee_invitations`
--

CREATE TABLE `committee_invitations` (
  `invitation_id` int(11) NOT NULL,
  `invitation_date` date DEFAULT curdate(),
  `professor_id` int(11) NOT NULL,
  `response_date` date DEFAULT NULL,
  `status` enum('invited','accepted','rejected') NOT NULL,
  `thesis_assignment_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `committee_invitations`
--

INSERT INTO `committee_invitations` (`invitation_id`, `invitation_date`, `professor_id`, `response_date`, `status`, `thesis_assignment_id`) VALUES
(2, '2025-03-04', 1, '2025-03-05', 'accepted', 7),
(4, '2025-03-05', 3, '2025-03-05', 'accepted', 7),
(6, '2025-03-05', 2, '2025-03-05', 'accepted', 8),
(8, '2025-03-05', 1, '2025-03-05', 'accepted', 8),
(9, '2025-03-06', 4, '2025-03-06', 'accepted', 9),
(10, '2025-03-06', 2, '2025-03-06', 'accepted', 9),
(11, '2025-03-07', 2, '2025-03-07', 'rejected', 10);

-- --------------------------------------------------------

--
-- Table structure for table `committee_members`
--

CREATE TABLE `committee_members` (
  `com_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `is_supervisor` tinyint(1) NOT NULL DEFAULT 0,
  `mark_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `committee_members`
--

INSERT INTO `committee_members` (`com_id`, `teacher_id`, `is_supervisor`, `mark_id`) VALUES
(1, 1, 0, 0),
(1, 2, 1, 0),
(1, 3, 0, 0),
(2, 1, 0, 0),
(2, 2, 0, 0),
(2, 3, 1, 0),
(3, 2, 0, 4),
(3, 4, 0, 3),
(3, 5, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `marks`
--

CREATE TABLE `marks` (
  `mark_id` int(11) NOT NULL,
  `targets_fulfiled` float NOT NULL,
  `quality_completeness` float NOT NULL,
  `readable_thesis` float NOT NULL,
  `time_satisfied` float NOT NULL DEFAULT 10,
  `final_mark` float GENERATED ALWAYS AS (0.6 * `targets_fulfiled` + 0.15 * `time_satisfied` + 0.15 * `quality_completeness` + 0.1 * `readable_thesis`) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `marks`
--

INSERT INTO `marks` (`mark_id`, `targets_fulfiled`, `quality_completeness`, `readable_thesis`, `time_satisfied`) VALUES
(2, 10, 10, 10, 10),
(3, 8.5, 9, 10, 10),
(4, 10, 7.5, 9, 10);

-- --------------------------------------------------------

--
-- Table structure for table `professor_notes`
--

CREATE TABLE `professor_notes` (
  `prof_note` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `note_content` text DEFAULT NULL,
  `date_created` date DEFAULT curdate(),
  `professor_id` int(11) NOT NULL,
  `assignment_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `professor_notes`
--

INSERT INTO `professor_notes` (`prof_note`, `title`, `note_content`, `date_created`, `professor_id`, `assignment_id`) VALUES
(1, 'σημειωση', 'γεια σας', '2025-03-05', 2, 7),
(2, 'σημειωση1', 'Καλησπέρα σας', '2025-03-07', 1, 7),
(3, 'σημείωση2', 'τι είναι αυτό;', '2025-03-07', 1, 7);

-- --------------------------------------------------------

--
-- Table structure for table `secrertary`
--

CREATE TABLE `secrertary` (
  `secrertary_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO secrertary (username,name, email, phone) VALUES
('secretary1','Ανθή Παππά', 'anthi@gmail.com', '2610444');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `area` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile_phone` int(20) DEFAULT NULL,
  `username` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `name`, `area`, `email`, `mobile_phone`, `username`) VALUES
(1, 'Σπυρίδων Μανωλάτος', 'Ρίο', 'spmanolatos@gmail.com', 13888, 'st1'),
(2, 'Ανδρέας Μαρούδας', 'Ρίο', 'erikos202@gmail.com', 13888, 'st2'),
(3, 'Πάρης Βαλλιανάτος', 'Πάτρα', 'pvalian@gmail.com', 13888, 'st3'),
(4, 'Γιάννης Κοκκίνης', 'Καστελλόκαμπος Πάτρας', 'gkokkinis@gmail.com', 11880, 'st4'),
(5, 'Kendrick Nunn', 'Chicago', 'knunn@gmail.com', 13888, 'st5'),
(6, 'Αλέξης Λαζανάς', 'Ανθούπολη', 'alazanas@gmail.com', 11880, 'st6');

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `teacher_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`teacher_id`, `name`, `username`) VALUES
(1, 'Εμμανουηλ Ψαράκης', 'teacher1'),
(2, 'Κώστας Τσίχλας', 'teacher2'),
(3, 'Χρήστος Μπούρας', 'teacher3'),
(4, 'Ελένη Βογιατζάκη', 'teacher4'),
(5, 'Δημήτριος Κουτσομητρόπουλος ', 'teacher5');

-- --------------------------------------------------------

--
-- Table structure for table `thesis_assignments`
--

CREATE TABLE `thesis_assignments` (
  `thesis_assignment_id` int(11) NOT NULL,
  `assignment_date` date NOT NULL DEFAULT curdate(),
  `examination_date` date DEFAULT NULL,
  `has_supervisor_put_an_announcement` int(11) DEFAULT NULL,
  `status` enum('Pending','Active','Completed','Under Examination','Cancelled','Under Grading') NOT NULL,
  `student_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `thesis_assignments`
--

INSERT INTO `thesis_assignments` (`thesis_assignment_id`, `assignment_date`, `examination_date`, `has_supervisor_put_an_announcement`, `status`, `student_id`, `topic_id`) VALUES
(6, '2025-03-04', NULL, NULL, 'Pending', 1, 1),
(7, '2025-03-04', NULL, NULL, 'Active', 2, 2),
(8, '2025-03-05', NULL, NULL, 'Under Examination', 3, 3),
(9, '2025-03-06', NULL, NULL, 'Under Grading', 4, 4),
(10, '2025-03-07', NULL, NULL, 'Cancelled', 5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `thesis_topics`
--

CREATE TABLE `thesis_topics` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `pdf_file_path` varchar(255) DEFAULT NULL,
  `supervisor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `thesis_topics`
--

INSERT INTO `thesis_topics` (`id`, `title`, `description`, `pdf_file_path`, `supervisor_id`) VALUES
(1, 'Alignment of 3-D Images of Biological Objects by Estimating Elastic Transformations in Image Pairs and Image Sets', 'This research project is supported by the Operational Program ESPA, (2014-2020). research program.', 'uploads/pdf/teacher1/1741078481_qmyJnxBU_Alignment-of-3-D-Images-of-Biological-Objects-by-Estimating-Elastic-Transformations-in-Image-Pairs-and-Image-Sets.pdf', 1),
(2, 'Ανάπτυξη Μοντέλου Πρακτόρων για τη Βελτιστοποίηση της Διαχείρισης Πλαστικών Αποβλήτων στην Αγροτική Παραγωγή', 'Η εργασία θα αναπτύξει ένα Agent-Based Model (ABM) για τη διαχείριση\r\nπλαστικών αποβλήτων από αγροτικές καλλιέργειες, αξιοποιώντας δεδομένα για τα είδη\r\nκαλλιεργειών, τη χρήση πλαστικών προϊόντων, και τα γεωγραφικά χαρακτηριστικά. Στόχος\r\nείναι η βελτιστοποίηση της συλλογής και ανακύκλωσης πλαστικών αποβλήτων,\r\nπροσομοιώνοντας διαφορετικά σενάρια διάρκειας ζωής πλαστικών και την εφαρμογή\r\nβιοδιασπώμενων υλικών, λαμβάνοντας υπόψη τις οικολογικές επιπτώσεις και τις\r\nκοινωνικοοικονομικές παραμέτρους. (ενδεχομένως να οδηγήσει σε δημοσίευση)\r\n', 'uploads/pdf/teacher2/1741080534_HsxNmgCo_------------.pdf', 2),
(3, ' Τεχνητά νευρωνικά δίκτυα για τη βελτίωση της ανάθεσης πόρων σε δίκτυα 5G με χρήση της τεχνολογίας MIMO', 'Χρήση τεχνητών νευρωνικών δικτύων (Artificial Neural Networks - ANNs) για τη βελτίωση της δυναμικής ανάθεσης πόρων σε δίκτυα πέμπτης γενιάς (5G), με έμφαση στην τεχνολογία Massive MIMO (Multiple Input Multiple Output). Η αυξανόμενη ζήτηση για υπηρεσίες υψηλής ταχύτητας και ποιότητας δημιουργεί την ανάγκη για αποδοτική διαχείριση πόρων, όπως το φάσμα και η ενέργεια. Τα δίκτυα 5G, σε συνδυασμό με την τεχνολογία MIMO και τις μεθόδους τεχνητής νοημοσύνης, αποτελούν τη βάση για τη βελτιστοποίηση αυτών των διαδικασιών.', 'uploads/pdf/teacher3/1741167748_oFZQvXBm_------------5G-----MIMO.pdf', 3),
(4, 'Μικροσυντονισμός (finetuning) πολυγλωσσικών μοντέλων για ταξινόμηση βιοϊατρικής πληροφορίας με μηδενική εκμάθηση (Zero-Shot Learning)', 'Η ταξινόμηση με μηδενική εκμάθηση (zero-shot classification) βασίζεται στο γεγονός ότι μοντέλα γενικής γλώσσας που έχουν βελτιστοποιηθεί στον συμπερασμό μπορούν να χρησιμοποιηθούν για ταξινόμηση χωρίς ειδική εκπαίδευση σε σύνολα δεδομένων. Μεγάλα μοντέλα γλώσσας έχουν ικανοποιητικά αποτελέσματα με πολύ λιγότερα εξειδικευμένα δεδομένα εκπαίδευσης σε σύγκριση με μικρότερα μοντέλα.Επίσης, προκαλεί έκπληξη το γεγονός ότι πολυγλωσσικά μοντέλα ξεπερνούν αντίστοιχα μονογλωσσικά ακόμα και σε μονογλωσσικές εργασίες. Η παρούσα εργασία θα διερευνήσει κατά πόσο ο μικροσυντονισμός (finetuning) ενός προεκπαιδευμένου μοντέλου μπορεί να βοηθήσει στην απόδοση και την ακρίβεια της τεχνικής μηδενικής εκμάθησης. Για τον μικροσυντονισμό μπορούν να χρησιμοποιηθούν σώματα βιοϊατρικών κειμένων ή και οι αναπαραστάσεις των κλάσεων ταξινόμησης (για παράδειγμα, οντολογία σε λεκτική περιγραφή). Απώτερος στόχος είναι να επιτευχθεί εξοικονόμηση πόρων και ταξινόμηση σε πραγματικό χρόνο.', 'uploads/pdf/teacher5/1741254921_yzmgrCch_-finetuning----------Zero-Shot-Learning.pdf', 5),
(5, 'Σχεδίαση και υλοποίηση εφαρμογής, για κινητό, για παροχή υπηρεσιών εθελοντών σε ευπαθείς ομάδες.', 'κατι δικα μου', 'uploads/pdf/teacher4/1741343709_QNcyZMaA_------------.pdf', 4);

-- --------------------------------------------------------

--
-- Table structure for table `user_det`
--

CREATE TABLE `user_det` (
  `USER` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `userType` enum('student','teacher','secrertary') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_det`
--

INSERT INTO `user_det` (`USER`, `password`, `userType`) VALUES
('st1', '123', 'student'),
('st2', '123', 'student'),
('st3', '123', 'student'),
('st4', '123', 'student'),
('st5', '123', 'student'),
('st6', '123', 'student'),
('teacher1', '123', 'teacher'),
('teacher2', '123', 'teacher'),
('teacher3', '123', 'teacher'),
('teacher4', '123', 'teacher'),
('teacher5', '123', 'teacher');
INSERT INTO `user_det` (`USER`, `password`, `userType`) VALUES
('secretary1', '123', 'secrertary');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `committee`
--
ALTER TABLE `committee`
  ADD PRIMARY KEY (`com_id`),
  ADD KEY `thesis_assignment_id` (`thesis_assignment_id`);

--
-- Indexes for table `committee_invitations`
--
ALTER TABLE `committee_invitations`
  ADD PRIMARY KEY (`invitation_id`),
  ADD KEY `professor_id` (`professor_id`),
  ADD KEY `thesis_assignment_id` (`thesis_assignment_id`);

--
-- Indexes for table `committee_members`
--
ALTER TABLE `committee_members`
  ADD PRIMARY KEY (`com_id`,`teacher_id`),
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `committe_members_mark_id` (`mark_id`);

--
-- Indexes for table `marks`
--
ALTER TABLE `marks`
  ADD PRIMARY KEY (`mark_id`);

--
-- Indexes for table `professor_notes`
--
ALTER TABLE `professor_notes`
  ADD PRIMARY KEY (`prof_note`),
  ADD KEY `professor_id` (`professor_id`),
  ADD KEY `assignment_id` (`assignment_id`);

--
-- Indexes for table `secrertary`
--
ALTER TABLE `secrertary`
  ADD PRIMARY KEY (`secrertary_id`),
  ADD UNIQUE KEY `idx_username` (`username`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `idx_username` (`username`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`teacher_id`),
  ADD UNIQUE KEY `idx_username` (`username`);

--
-- Indexes for table `thesis_assignments`
--
ALTER TABLE `thesis_assignments`
  ADD PRIMARY KEY (`thesis_assignment_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `topic_id` (`topic_id`);

--
-- Indexes for table `thesis_topics`
--
ALTER TABLE `thesis_topics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supervisor_id` (`supervisor_id`);

--
-- Indexes for table `user_det`
--
ALTER TABLE `user_det`
  ADD PRIMARY KEY (`USER`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `committee`
--
ALTER TABLE `committee`
  MODIFY `com_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `committee_invitations`
--
ALTER TABLE `committee_invitations`
  MODIFY `invitation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `marks`
--
ALTER TABLE `marks`
  MODIFY `mark_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `professor_notes`
--
ALTER TABLE `professor_notes`
  MODIFY `prof_note` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `secrertary`
--
ALTER TABLE `secrertary`
  MODIFY `secrertary_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `thesis_assignments`
--
ALTER TABLE `thesis_assignments`
  MODIFY `thesis_assignment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `thesis_topics`
--
ALTER TABLE `thesis_topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `committee`
--
ALTER TABLE `committee`
  ADD CONSTRAINT `committee_ibfk_1` FOREIGN KEY (`thesis_assignment_id`) REFERENCES `thesis_assignments` (`thesis_assignment_id`);

--
-- Constraints for table `committee_invitations`
--
ALTER TABLE `committee_invitations`
  ADD CONSTRAINT `committee_invitations_ibfk_1` FOREIGN KEY (`professor_id`) REFERENCES `teacher` (`teacher_id`),
  ADD CONSTRAINT `committee_invitations_ibfk_2` FOREIGN KEY (`thesis_assignment_id`) REFERENCES `thesis_assignments` (`thesis_assignment_id`);

--
-- Constraints for table `committee_members`
--
ALTER TABLE `committee_members`
  ADD CONSTRAINT `committee_members_ibfk_1` FOREIGN KEY (`com_id`) REFERENCES `committee` (`com_id`),
  ADD CONSTRAINT `committee_members_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`teacher_id`);

--
-- Constraints for table `professor_notes`
--
ALTER TABLE `professor_notes`
  ADD CONSTRAINT `professor_notes_ibfk_1` FOREIGN KEY (`professor_id`) REFERENCES `teacher` (`teacher_id`),
  ADD CONSTRAINT `professor_notes_ibfk_2` FOREIGN KEY (`assignment_id`) REFERENCES `thesis_assignments` (`thesis_assignment_id`);

--
-- Constraints for table `secrertary`
--
ALTER TABLE `secrertary`
  ADD CONSTRAINT `secrertary_ibfk_1` FOREIGN KEY (`username`) REFERENCES `user_det` (`USER`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`username`) REFERENCES `user_det` (`USER`);

--
-- Constraints for table `teacher`
--
ALTER TABLE `teacher`
  ADD CONSTRAINT `teacher_ibfk_1` FOREIGN KEY (`username`) REFERENCES `user_det` (`USER`);

--
-- Constraints for table `thesis_assignments`
--
ALTER TABLE `thesis_assignments`
  ADD CONSTRAINT `thesis_assignments_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`),
  ADD CONSTRAINT `thesis_assignments_ibfk_2` FOREIGN KEY (`topic_id`) REFERENCES `thesis_topics` (`id`);

--
-- Constraints for table `thesis_topics`
--
ALTER TABLE `thesis_topics`
  ADD CONSTRAINT `thesis_topics_ibfk_1` FOREIGN KEY (`supervisor_id`) REFERENCES `teacher` (`teacher_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
