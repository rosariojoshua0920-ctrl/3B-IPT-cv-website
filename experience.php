<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Experience</title>
</head>
<body>
    <h2>Education</h2>
<label>Degree:</label><br>
<input type="text" name="degree"><br> 
<label>School:</label><br>
<input type="text" name="school" required><br>
<label>Start Year:</label><br>
<input type="date" name="school_start_year" required><br>
<label>End Year:</label><br>
<input type="date" name="school_end_year" required><br>

<button type="button" onclick="addEducation()">Add Education</button>
<h2>Work Experience</h2>
<label>Company Name:</label><br>
<input type="text" name="company" ><br> 
<label>Position:</label><br>
<input type="text" name="position" ><br> 
<label>Start Year:</label><br>
<input type="date" name="work_start_year" ><br> 
<label>End Year:</label><br>
<input type="date" name="work_end_year" ><br>

<button type="button" onclick="addExperience()">Add Experience</button>
<h2>Skills</h2>
<label>Skill</label><br>
<input type="text" name="skill1" required><br> 
<button type="button" onclick="addSkill()">Add Skill</button>

<h2>References</h2>
<label>Reference:</label><br>
<input type="text" name="reference1" required><br> 
<button type="button" onclick="addReference()">Add Reference</button>

<button type="submit">Next</button>
</body>
</html>