<?php
session_start();
include "db.php";

// Get personal_id from session (POST/create) or URL parameter (GET/view)
if (isset($_SESSION['personal_id'])) {
    $personal_id = $_SESSION['personal_id'];
} elseif (isset($_GET['id'])) {
    $personal_id = intval($_GET['id']);
} else {
    die("Error: Personal ID not found.");
}

// Verify the personal_id exists in database
$check = mysqli_query($conn, "SELECT id FROM personal_info WHERE id = $personal_id");
if (!$check) {
    die("Error: Database query failed - " . mysqli_error($conn));
}
if (mysqli_num_rows($check) == 0) {
    die("Error: CV record not found for ID: $personal_id");
}

// Only process POST data (forms from experience.php)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if this is an edit - if so, delete old records first
    $isEdit = isset($_POST['is_edit']) && $_POST['is_edit'] == '1';
    if ($isEdit) {
        mysqli_query($conn, "DELETE FROM education WHERE personal_info_id = $personal_id");
        mysqli_query($conn, "DELETE FROM work_experience WHERE personal_info_id = $personal_id");
        mysqli_query($conn, "DELETE FROM skills WHERE personal_info_id = $personal_id");
        mysqli_query($conn, "DELETE FROM reference_list WHERE personal_info_id = $personal_id");
    }

    /* =========================
       INSERT EDUCATION
    ========================= */
    if (isset($_POST['education']) && is_array($_POST['education'])) {
        foreach ($_POST['education'] as $edu) {
            if (!empty($edu['degree']) || !empty($edu['school'])) {
                $degree = mysqli_real_escape_string($conn, $edu['degree']);
                $school = mysqli_real_escape_string($conn, $edu['school']);
                $start_year = mysqli_real_escape_string($conn, $edu['start_year']);
                $end_year = mysqli_real_escape_string($conn, $edu['end_year']);
                
                mysqli_query($conn, "INSERT INTO education 
                (personal_info_id, degree, school, start_year, end_year)
                VALUES 
                ('$personal_id','$degree','$school','$start_year','$end_year')");
            }
        }
    }

    /* =========================
       INSERT WORK EXPERIENCE
    ========================= */
    if (isset($_POST['experience']) && is_array($_POST['experience'])) {
        foreach ($_POST['experience'] as $exp) {
            if (!empty($exp['company']) || !empty($exp['position'])) {
                $company = mysqli_real_escape_string($conn, $exp['company']);
                $position = mysqli_real_escape_string($conn, $exp['position']);
                $start_year = mysqli_real_escape_string($conn, $exp['start_year']);
                $end_year = mysqli_real_escape_string($conn, $exp['end_year']);
                
                mysqli_query($conn, "INSERT INTO work_experience
                (personal_info_id, company, position, start_year, end_year)
                VALUES
                ('$personal_id','$company','$position','$start_year','$end_year')");
            }
        }
    }

    /* =========================
       INSERT SKILLS
    ========================= */
    if (isset($_POST['skills']) && is_array($_POST['skills'])) {
        foreach ($_POST['skills'] as $skill) {
            if (!empty($skill)) {
                $skill = mysqli_real_escape_string($conn, $skill);
                mysqli_query($conn, "INSERT INTO skills (personal_info_id, skill_name)
                VALUES ('$personal_id','$skill')");
            }
        }
    }

    /* =========================
       INSERT REFERENCES
    ========================= */
    if (isset($_POST['references']) && is_array($_POST['references'])) {
        foreach ($_POST['references'] as $ref) {
            $refName = isset($ref['name']) ? mysqli_real_escape_string($conn, $ref['name']) : '';
            $refContact = isset($ref['contact']) ? mysqli_real_escape_string($conn, $ref['contact']) : '';
            
            if (!empty($refName)) {
                mysqli_query($conn, "INSERT INTO reference_list 
                (personal_info_id, reference_name, reference_contact)
                VALUES ('$personal_id','$refName','$refContact')");
            }
        }
    }
} // END POST CHECK

/* =========================
   FETCH ALL DATA FOR PREVIEW
========================= */

$personal = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT * FROM personal_info WHERE id = $personal_id"));

$education_query = mysqli_query($conn,
"SELECT * FROM education WHERE personal_info_id = $personal_id ORDER BY start_year DESC");
if (!$education_query) {
    die("Database Error: " . mysqli_error($conn));
}

$work_query = mysqli_query($conn,
"SELECT * FROM work_experience WHERE personal_info_id = $personal_id ORDER BY start_year DESC");

$skills_query = mysqli_query($conn,
"SELECT * FROM skills WHERE personal_info_id = $personal_id");

$references_query = mysqli_query($conn,
"SELECT * FROM reference_list WHERE personal_info_id = $personal_id");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV Preview - <?php echo htmlspecialchars($personal['first_name'] . ' ' . $personal['last_name']); ?></title>
    <link rel="stylesheet" href="../cv-form/result.css">
</head>
<body>

<!-- Action buttons - hidden when printing -->
<div class="action-bar no-print">
    <div class="action-buttons">
        <button onclick="window.print()" class="btn btn-print">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="6 9 6 2 18 2 18 9"></polyline>
                <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                <rect x="6" y="14" width="12" height="8"></rect>
            </svg>
            Print CV
        </button>
        <button onclick="downloadPDF()" class="btn btn-download">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                <polyline points="7 10 12 15 17 10"></polyline>
                <line x1="12" y1="15" x2="12" y2="3"></line>
            </svg>
            Download PDF
        </button>
        <button onclick="window.location.href='personal-info.php?id=<?php echo $personal_id; ?>'" class="btn btn-edit">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
            </svg>
            Edit CV
        </button>
        <button onclick="window.location.href='../layout-main-page/nav-bar-main.php'" class="btn btn-home">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
            </svg>
            Home
        </button>
    </div>
</div>

<div class="page-wrapper">
    <div class="cv-container">
        <!-- Header Section with Photo -->
        <div class="cv-header">
            <?php if (!empty($personal['photo_path'])): ?>
                <div class="photo-container">
                    <img src="<?php echo htmlspecialchars($personal['photo_path']); ?>" alt="Profile Photo">
                </div>
            <?php endif; ?>
            
            <div class="header-info">
                <h1 class="name">
                    <?php 
                    echo htmlspecialchars($personal['first_name']) . " " . 
                         htmlspecialchars($personal['last_name']);
                    if (!empty($personal['extension_name'])) {
                        echo " " . htmlspecialchars($personal['extension_name']);
                    }
                    ?>
                </h1>
                
                <div class="contact-info">
                    <div class="contact-item">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                        <?php echo htmlspecialchars($personal['phone']); ?>
                    </div>
                    <div class="contact-item">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                        <?php echo htmlspecialchars($personal['email']); ?>
                    </div>
                    <div class="contact-item">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <?php echo htmlspecialchars($personal['address']); ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Professional Summary -->
        <div class="cv-section">
            <h2 class="section-title">Professional Summary</h2>
            <p class="summary-text"><?php echo nl2br(htmlspecialchars($personal['about'])); ?></p>
        </div>

        <!-- Education -->
        <div class="cv-section">
            <h2 class="section-title">Education</h2>
            <?php 
            $has_education = false;
            while($edu = mysqli_fetch_assoc($education_query)) { 
                $has_education = true;
            ?>
                <div class="entry">
                    <div class="entry-header">
                        <div>
                            <h3 class="entry-title"><?php echo htmlspecialchars($edu['degree']); ?></h3>
                            <p class="entry-subtitle"><?php echo htmlspecialchars($edu['school']); ?></p>
                        </div>
                        <div class="entry-date">
                            <?php echo date('M Y', strtotime($edu['start_year'])); ?> - 
                            <?php echo date('M Y', strtotime($edu['end_year'])); ?>
                        </div>
                    </div>
                </div>
            <?php } 
            if (!$has_education) {
                echo '<p class="empty-state">No education entries added.</p>';
            }
            ?>
        </div>

        <!-- Work Experience -->
        <?php 
        $has_work = false;
        mysqli_data_seek($work_query, 0);
        while($work = mysqli_fetch_assoc($work_query)) { 
            if (!$has_work) {
                echo '<div class="cv-section">';
                echo '<h2 class="section-title">Work Experience</h2>';
                $has_work = true;
            }
        ?>
            <div class="entry">
                <div class="entry-header">
                    <div>
                        <h3 class="entry-title"><?php echo htmlspecialchars($work['position']); ?></h3>
                        <p class="entry-subtitle"><?php echo htmlspecialchars($work['company']); ?></p>
                    </div>
                    <div class="entry-date">
                        <?php echo date('M Y', strtotime($work['start_year'])); ?> - 
                        <?php echo date('M Y', strtotime($work['end_year'])); ?>
                    </div>
                </div>
            </div>
        <?php } 
        if ($has_work) {
            echo '</div>';
        }
        ?>

        <!-- Skills -->
        <div class="cv-section">
            <h2 class="section-title">Skills</h2>
            <div class="skills-grid">
            <?php 
            $has_skills = false;
            while($skill = mysqli_fetch_assoc($skills_query)) { 
                $has_skills = true;
            ?>
                <span class="skill-tag"><?php echo htmlspecialchars($skill['skill_name']); ?></span>
            <?php } 
            if (!$has_skills) {
                echo '<p class="empty-state">No skills added.</p>';
            }
            ?>
            </div>
        </div>

        <!-- References -->
        <?php 
        $has_references = false;
        mysqli_data_seek($references_query, 0);
        while($ref = mysqli_fetch_assoc($references_query)) { 
            if (!$has_references) {
                echo '<div class="cv-section">';
                echo '<h2 class="section-title">References</h2>';
                $has_references = true;
            }
        ?>
            <div class="reference-entry">
                <p class="reference-name"><?php echo htmlspecialchars($ref['reference_name']); ?></p>
                <?php if (!empty($ref['reference_contact'])): ?>
                    <p class="reference-contact"><?php echo htmlspecialchars($ref['reference_contact']); ?></p>
                <?php endif; ?>
            </div>
        <?php } 
        if ($has_references) {
            echo '</div>';
        }
        ?>
    </div>
</div>

<script>
    function downloadPDF() {
        // For now, use print dialog with save as PDF option
        // You can integrate a proper PDF library later if needed
        alert('Please use your browser\'s Print dialog and select "Save as PDF" as the printer.');
        window.print();
    }
</script>

</body>
</html>