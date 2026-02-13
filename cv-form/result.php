<?php
include 'db.php';
include 'db_helpers_simple.php';

if (!isset($_GET['id'])) {
    die("No CV found.");
}

$id = $_GET['id'];
$cv = getCompleteCV($id);

$personal = $cv['personal_info'];
$experience = $cv['work_experience'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>CV Result</title>
</head>
<body>

<h1><?php echo htmlspecialchars($personal['first_name'] . " " . $personal['last_name']); ?></h1>

<p><strong>Phone:</strong> <?php echo htmlspecialchars($personal['phone']); ?></p>
<p><strong>Email:</strong> <?php echo htmlspecialchars($personal['email']); ?></p>
<p><strong>Address:</strong> <?php echo htmlspecialchars($personal['address']); ?></p>

<h2>About Me</h2>
<p><?php echo nl2br(htmlspecialchars($personal['about'])); ?></p>

<h2>Work Experience</h2>

<?php foreach ($experience as $exp): ?>
    <h3><?php echo htmlspecialchars($exp['position']); ?></h3>
    <p><?php echo htmlspecialchars($exp['company']); ?></p>
    <p>
        <?php echo date("F Y", strtotime($exp['start_year'])); ?> -
        <?php echo date("F Y", strtotime($exp['end_year'])); ?>
    </p>
    <hr>
<?php endforeach; ?>

<button onclick="window.print()">Print CV</button>
<button onclick="window.location.href='personal-info.php'">Create New CV</button>

</body>
</html>
