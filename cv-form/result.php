<?php
session_start();
include "db.php";

if (!isset($_SESSION['personal_id'])) {
    die("Error: Personal ID not found.");
}

$personal_id = $_SESSION['personal_id'];

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
            mysqli_query($conn, "INSERT INTO education 
            (personal_info_id, degree, school, start_year, end_year)
            VALUES 
            ('$personal_id','{$edu['degree']}','{$edu['school']}',
            '{$edu['start_year']}','{$edu['end_year']}')");
        }
    }
}

/* =========================
   INSERT WORK EXPERIENCE
========================= */
if (isset($_POST['experience']) && is_array($_POST['experience'])) {
    foreach ($_POST['experience'] as $exp) {
        if (!empty($exp['company']) || !empty($exp['position'])) {
            mysqli_query($conn, "INSERT INTO work_experience
            (personal_info_id, company, position, start_year, end_year)
            VALUES
            ('$personal_id','{$exp['company']}','{$exp['position']}',
            '{$exp['start_year']}','{$exp['end_year']}')");
        }
    }
}

/* =========================
   INSERT SKILLS
========================= */
if (isset($_POST['skills']) && is_array($_POST['skills'])) {
    foreach ($_POST['skills'] as $skill) {
        if (!empty($skill)) {
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
        if (!empty($ref)) {
            mysqli_query($conn, "INSERT INTO reference_list 
            (personal_info_id, reference_name)
            VALUES ('$personal_id','$ref')");
        }
    }
}

/* =========================
   FETCH ALL DATA FOR PREVIEW
========================= */

$personal = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT * FROM personal_info WHERE id = $personal_id"));

$education_query = mysqli_query($conn,
"SELECT * FROM education WHERE personal_info_id = $personal_id");
if (!$education_query) {
    die("Database Error: " . mysqli_error($conn) . "<br>Please run <a href='reset-db.php'>reset-db.php</a> to fix your database.");
}

$work_query = mysqli_query($conn,
"SELECT * FROM work_experience WHERE personal_info_id = $personal_id");

$skills_query = mysqli_query($conn,
"SELECT * FROM skills WHERE personal_info_id = $personal_id");

$references_query = mysqli_query($conn,
"SELECT * FROM reference_list WHERE personal_info_id = $personal_id");

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>CV Preview</title>
    <link rel="stylesheet" href="result.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📄 Curriculum Vitae Preview</h1>
        </div>

        <div id="cv-container" class="size-a4">
            <div class="cv-content">
                <!-- Header with Photo -->
                <div class="cv-header">
                    <?php if (!empty($personal['photo_path'])): ?>
                        <img src="<?php echo htmlspecialchars($personal['photo_path']); ?>" alt="Photo">
                    <?php endif; ?>
                    <div class="cv-name">
                        <?php 
                        echo htmlspecialchars($personal['first_name'] . " " . $personal['last_name']);
                        if (!empty($personal['extension_name'])) {
                            echo " " . htmlspecialchars($personal['extension_name']);
                        }
                        ?>
                    </div>
                    <div class="cv-contact">
                        <?php if (!empty($personal['phone'])): ?>
                            <span><?php echo htmlspecialchars($personal['phone']); ?></span>
                        <?php endif; ?>
                        <?php if (!empty($personal['email'])): ?>
                            <span> <?php echo htmlspecialchars($personal['email']); ?></span>
                        <?php endif; ?>
                        <br>
                        <?php if (!empty($personal['address'])): ?>
                            <span><?php echo htmlspecialchars($personal['address']); ?></span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- About Me -->
                <?php if (!empty($personal['about'])): ?>
                <div class="cv-section">
                    <div class="cv-section-title">PROFESSIONAL SUMMARY</div>
                    <p><?php echo nl2br(htmlspecialchars($personal['about'])); ?></p>
                </div>
                <?php endif; ?>

                <!-- Education -->
                <?php 
                $education_count = 0;
                while($row = mysqli_fetch_assoc($education_query)) {
                    if ($education_count == 0) {
                        echo '<div class="cv-section">';
                        echo '<div class="cv-section-title">EDUCATION</div>';
                    }
                    $education_count++;
                ?>
                    <div class="cv-entry">
                        <div class="cv-entry-title"><?php echo htmlspecialchars($row['degree']); ?></div>
                        <div class="cv-entry-subtitle"><?php echo htmlspecialchars($row['school']); ?></div>
                        <div class="cv-entry-date">
                            <?php echo htmlspecialchars($row['start_year']); ?> - 
                            <?php echo htmlspecialchars($row['end_year']); ?>
                        </div>
                    </div>
                <?php 
                    if ($education_count > 0) {
                        $remaining = mysqli_num_rows($education_query);
                        if ($remaining == 0) {
                            echo '</div>';
                        }
                    }
                } 
                ?>

                <!-- Work Experience -->
                <?php 
                $exp_count = 0;
                while($row = mysqli_fetch_assoc($work_query)) {
                    if ($exp_count == 0) {
                        echo '<div class="cv-section">';
                        echo '<div class="cv-section-title">WORK EXPERIENCE</div>';
                    }
                    $exp_count++;
                ?>
                    <div class="cv-entry">
                        <div class="cv-entry-title"><?php echo htmlspecialchars($row['position']); ?></div>
                        <div class="cv-entry-subtitle"><?php echo htmlspecialchars($row['company']); ?></div>
                        <div class="cv-entry-date">
                            <?php echo htmlspecialchars($row['start_year']); ?> - 
                            <?php echo htmlspecialchars($row['end_year']); ?>
                        </div>
                    </div>
                <?php 
                    if ($exp_count > 0) {
                        $remaining = mysqli_num_rows($work_query);
                        if ($remaining == 0) {
                            echo '</div>';
                        }
                    }
                } 
                ?>

                <!-- Skills -->
                <?php 
                $skill_count = 0;
                while($row = mysqli_fetch_assoc($skills_query)) {
                    if ($skill_count == 0) {
                        echo '<div class="cv-section">';
                        echo '<div class="cv-section-title">SKILLS</div>';
                    }
                    $skill_count++;
                ?>
                    <div class="cv-entry">
                        <p>• <?php echo htmlspecialchars($row['skill_name']); ?></p>
                    </div>
                <?php 
                    if ($skill_count > 0) {
                        $remaining = mysqli_num_rows($skills_query);
                        if ($remaining == 0) {
                            echo '</div>';
                        }
                    }
                } 
                ?>

                <!-- References -->
                <?php 
                $ref_count = 0;
                while($row = mysqli_fetch_assoc($references_query)) {
                    if ($ref_count == 0) {
                        echo '<div class="cv-section">';
                        echo '<div class="cv-section-title">REFERENCES</div>';
                    }
                    $ref_count++;
                ?>
                    <div class="cv-entry">
                        <p><?php echo htmlspecialchars($row['reference_name']); ?></p>
                    </div>
                <?php 
                    if ($ref_count > 0) {
                        $remaining = mysqli_num_rows($references_query);
                        if ($remaining == 0) {
                            echo '</div>';
                        }
                    }
                } 
                ?>
            </div>
        </div>

        <div class="controls">
            <select id="paperSize" class="paper-size-select" onchange="changePaperSize()">
                <option value="a4">📋 A4 (210 x 297mm)</option>
                <option value="legal">📋 Legal (8.5 x 14in)</option>
                <option value="short">📋 Short (210 x 200mm)</option>
            </select>
            <button class="btn-primary" onclick="printCV()">🖨️ Print CV</button>
            <button class="btn-primary" onclick="downloadPDF()">⬇️ Download PDF</button>
            <button class="btn-secondary" onclick="editCV()">✏️ Edit CV</button>
            <button class="btn-secondary" onclick="goHome()">🏠 Home</button>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        function changePaperSize() {
            const size = document.getElementById('paperSize').value;
            const container = document.getElementById('cv-container');
            
            container.classList.remove('size-a4', 'size-legal', 'size-short');
            container.classList.add('size-' + size);
        }

        function printCV() {
            window.print();
        }

        function downloadPDF() {
            const element = document.getElementById('cv-container');
            const opt = {
                margin: 10,
                filename: 'curriculum-vitae.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { orientation: 'portrait', unit: 'mm', format: 'a4' }
            };
            html2pdf().set(opt).from(element).save();
        }

        function editCV() {
            window.location.href = 'personal-info.php?id=<?php echo $personal_id; ?>';
        }

        function goHome() {
            window.location.href = '../layout-main-page/nav-bar-main.php';
        }
    </script>
</body>
</html>
