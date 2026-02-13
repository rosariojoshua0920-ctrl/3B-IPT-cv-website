<?php
session_start();
include "../cv-form/db.php";

if (!isset($_GET['id'])) {
    die("Error: CV ID not found.");
}

$personal_id = mysqli_real_escape_string($conn, $_GET['id']);

// Fetch personal info
$personal = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT * FROM personal_info WHERE id = $personal_id"));

if (!$personal) {
    die("Error: CV not found.");
}

// Fetch education
$education_query = mysqli_query($conn,
"SELECT * FROM education WHERE personal_info_id = $personal_id ORDER BY start_year DESC");

// Fetch work experience
$work_query = mysqli_query($conn,
"SELECT * FROM work_experience WHERE personal_info_id = $personal_id ORDER BY start_year DESC");

// Fetch skills
$skills_query = mysqli_query($conn,
"SELECT * FROM skills WHERE personal_info_id = $personal_id");

// Fetch references
$references_query = mysqli_query($conn,
"SELECT * FROM reference_list WHERE personal_info_id = $personal_id");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV Preview - <?php echo htmlspecialchars($personal['first_name']); ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background-color: white;
            padding: 40px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        .header {
            display: flex;
            gap: 30px;
            margin-bottom: 30px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 30px;
        }
        .header img {
            width: 150px;
            height: 150px;
            border-radius: 8px;
            object-fit: cover;
        }
        .header-info h1 {
            color: #007bff;
            margin-bottom: 10px;
            font-size: 28px;
        }
        .header-info p {
            color: #666;
            margin: 5px 0;
            line-height: 1.6;
        }
        .section {
            margin-bottom: 30px;
        }
        .section h2 {
            color: #007bff;
            font-size: 20px;
            margin-bottom: 15px;
            border-left: 4px solid #007bff;
            padding-left: 10px;
        }
        .section p {
            color: #333;
            line-height: 1.8;
            margin-bottom: 10px;
        }
        .entry {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f9f9f9;
            border-left: 3px solid #007bff;
            padding-left: 15px;
        }
        .entry strong {
            color: #007bff;
        }
        .entry-title {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }
        .entry-subtitle {
            font-size: 14px;
            color: #666;
            font-style: italic;
        }
        .entry-date {
            font-size: 13px;
            color: #999;
            margin-top: 5px;
        }
        .skills-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .skill-item {
            background-color: #e7f3ff;
            color: #007bff;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 14px;
        }
        .actions {
            display: flex;
            gap: 10px;
            margin-top: 30px;
            justify-content: center;
            border-top: 2px solid #f0f0f0;
            padding-top: 30px;
        }
        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
        }
        .btn-print {
            background-color: #28a745;
            color: white;
        }
        .btn-back {
            background-color: #6c757d;
            color: white;
        }
        .btn:hover {
            opacity: 0.9;
        }
        @media print {
            body {
                background: white;
                padding: 0;
            }
            .container {
                box-shadow: none;
                padding: 0;
            }
            .actions {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header with Photo and Basic Info -->
        <div class="header">
            <?php if (!empty($personal['photo_path'])): ?>
                <img src="../cv-form/<?php echo htmlspecialchars($personal['photo_path']); ?>" alt="Profile Photo">
            <?php endif; ?>
            <div class="header-info">
                <h1><?php echo htmlspecialchars($personal['first_name'] . ' ' . $personal['last_name']); ?>
                    <?php if (!empty($personal['extension_name'])): ?>
                        <?php echo htmlspecialchars($personal['extension_name']); ?>
                    <?php endif; ?>
                </h1>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($personal['email']); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($personal['phone']); ?></p>
                <p><strong>Address:</strong> <?php echo htmlspecialchars($personal['address']); ?></p>
            </div>
        </div>

        <!-- About Me -->
        <?php if (!empty($personal['about'])): ?>
        <div class="section">
            <h2>About Me</h2>
            <p><?php echo nl2br(htmlspecialchars($personal['about'])); ?></p>
        </div>
        <?php endif; ?>

        <!-- Education -->
        <?php if (mysqli_num_rows($education_query) > 0): ?>
        <div class="section">
            <h2>Education</h2>
            <?php while ($edu = mysqli_fetch_assoc($education_query)): ?>
                <div class="entry">
                    <div class="entry-title"><?php echo htmlspecialchars($edu['degree']); ?></div>
                    <div class="entry-subtitle"><?php echo htmlspecialchars($edu['school']); ?></div>
                    <div class="entry-date">
                        <?php echo date('M Y', strtotime($edu['start_year'])); ?> - 
                        <?php echo date('M Y', strtotime($edu['end_year'])); ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <?php endif; ?>

        <!-- Work Experience -->
        <?php if (mysqli_num_rows($work_query) > 0): ?>
        <div class="section">
            <h2>Work Experience</h2>
            <?php while ($work = mysqli_fetch_assoc($work_query)): ?>
                <div class="entry">
                    <div class="entry-title"><?php echo htmlspecialchars($work['position']); ?></div>
                    <div class="entry-subtitle"><?php echo htmlspecialchars($work['company']); ?></div>
                    <div class="entry-date">
                        <?php echo date('M Y', strtotime($work['start_year'])); ?> - 
                        <?php echo date('M Y', strtotime($work['end_year'])); ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <?php endif; ?>

        <!-- Skills -->
        <?php if (mysqli_num_rows($skills_query) > 0): ?>
        <div class="section">
            <h2>Skills</h2>
            <div class="skills-list">
                <?php while ($skill = mysqli_fetch_assoc($skills_query)): ?>
                    <div class="skill-item"><?php echo htmlspecialchars($skill['skill_name']); ?></div>
                <?php endwhile; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- References -->
        <?php if (mysqli_num_rows($references_query) > 0): ?>
        <div class="section">
            <h2>References</h2>
            <?php while ($ref = mysqli_fetch_assoc($references_query)): ?>
                <div class="entry">
                    <p><?php echo htmlspecialchars($ref['reference_name']); ?></p>
                </div>
            <?php endwhile; ?>
        </div>
        <?php endif; ?>

        <!-- Actions -->
        <div class="actions">
            <button class="btn btn-print" onclick="window.print()">Print CV</button>
            <a href="view-cv.php" class="btn btn-back">Back to List</a>
        </div>
    </div>
</body>
</html>
