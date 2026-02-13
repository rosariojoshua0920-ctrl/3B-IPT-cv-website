<?php
session_start();
include "db.php";

if (!isset($_SESSION['personal_id'])) {
    die("Error: Personal ID not found.");
}

$personal_id = $_SESSION['personal_id'];

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
    <title>CV Preview</title>
    <style>
        body { font-family: Arial; padding: 40px; }
        img { width: 150px; border-radius: 8px; }
        h2 { margin-top: 30px; border-bottom: 1px solid #ccc; }
    </style>
</head>
<body>

<h1>Curriculum Vitae Preview</h1>

<img src="<?php echo $personal['photo_path']; ?>"><br><br>

<h2><?php 
echo $personal['first_name'] . " " . 
     $personal['last_name'] . " " . 
     $personal['extension_name']; 
?></h2>

<p><strong>Phone:</strong> <?php echo $personal['phone']; ?></p>
<p><strong>Email:</strong> <?php echo $personal['email']; ?></p>
<p><strong>Address:</strong> <?php echo $personal['address']; ?></p>

<h2>About Me</h2>
<p><?php echo $personal['about']; ?></p>

<h2>Education</h2>
<?php while($row = mysqli_fetch_assoc($education_query)) { ?>
    <p>
        <?php echo $row['degree']; ?> - 
        <?php echo $row['school']; ?> 
        (<?php echo $row['start_year']; ?> - 
        <?php echo $row['end_year']; ?>)
    </p>
<?php } ?>

<h2>Work Experience</h2>
<?php while($row = mysqli_fetch_assoc($work_query)) { ?>
    <p>
        <?php echo $row['position']; ?> at 
        <?php echo $row['company']; ?>
        (<?php echo $row['start_year']; ?> - 
        <?php echo $row['end_year']; ?>)
    </p>
<?php } ?>

<h2>Skills</h2>
<?php while($row = mysqli_fetch_assoc($skills_query)) { ?>
    <p><?php echo $row['skill_name']; ?></p>
<?php } ?>

<h2>References</h2>
<?php while($row = mysqli_fetch_assoc($references_query)) { ?>
    <p><?php echo $row['reference_name']; ?></p>
<?php } ?>

</body>
</html>
