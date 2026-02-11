<?php
// Determine current page to set active step
$current_page = basename($_SERVER['PHP_SELF']);
$active_step = 'personal';
if ($current_page === 'experience.php') {
    $active_step = 'experience';
} elseif ($current_page === 'result.php') {
    $active_step = 'template';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curriculum Vitae</title>
    <link rel="stylesheet" href="style-nav.css">
</head>
<body>
     <div class="wrapper">
        <!-- Header -->
        <header class="header">
            <div class="logo">Curriculum Vitae</div>
        </header>

        <!-- Progress Steps -->
        <div class="progress-section">
            <div class="progress-container">
                <div class="step-indicator">
                    <button type="button" class="step-btn <?php echo $active_step === 'personal' ? 'active' : ''; ?>" data-step="personal">
                        <div class="step-icon">👤</div>
                        <p>Personal</p>
                    </button>
                    <div class="step-line"></div>
                    <button type="button" class="step-btn <?php echo $active_step === 'experience' ? 'active' : ''; ?>" data-step="experience">
                        <div class="step-icon">💼</div>
                        <p>Experiences</p>
                    </button>
                    <div class="step-line"></div>
                    <button type="button" class="step-btn <?php echo $active_step === 'template' ? 'active' : ''; ?>" data-step="template">
                        <div class="step-icon">✓</div>
                        <p>Template</p>
                    </button>
                </div>
            </div>
        </div>

</body>
</html>