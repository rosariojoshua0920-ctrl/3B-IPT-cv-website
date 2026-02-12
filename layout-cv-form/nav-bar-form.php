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
    
      
            <div>Curriculum Vitae</div>
      
                    <button onclick="loadContent('../cv-form/personal-info.php')" class="step-btn <?php echo $active_step === 'personal' ? 'active' : ''; ?>" data-step="personal">
                        <div>👤</div>
                        <p>Personal</p>
                    </button>
                  
                    <button onclick="loadContent('../cv-form/experience.php')" class="step-btn <?php echo $active_step === 'experience' ? 'active' : ''; ?>" data-step="experience">
                        <div>💼</div>
                        <p>Experiences</p>
                    </button>
                  
                    <button onclick="loadContent('../cv-form/result.php')" class="step-btn <?php echo $active_step === 'template' ? 'active' : ''; ?>" data-step="template">
                        <div>✓</div>
                        <p>Template</p>
                    </button>

                    <div id="content"></div>

            <script src="nav-bar-form.js"></script>
                
</body>
</html>