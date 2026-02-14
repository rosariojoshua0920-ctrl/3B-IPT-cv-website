// Storage arrays for form data
let educationList = [];
let experienceList = [];
let skillList = [];
let referenceList = [];

// Load existing data from session when page loads
window.addEventListener('DOMContentLoaded', function() {
    // Data is pre-populated via inline script in experience.php
});

// Add Education
function addEducation() {
    const degree = document.querySelector('input[name="degree"]').value.trim();
    const school = document.querySelector('input[name="school"]').value.trim();
    const startYear = document.querySelector('input[name="school_start_year"]').value;
    const endYear = document.querySelector('input[name="school_end_year"]').value;
    
    if (!degree || !school || !startYear || !endYear) {
        alert('Please fill in all education fields');
        return;
    }
    
    // Validate dates
    if (new Date(startYear) > new Date(endYear)) {
        alert('Start date cannot be after end date');
        return;
    }
    
    educationList.push({
        degree: degree,
        school: school,
        start_year: startYear,
        end_year: endYear
    });
    
    // Display in list
    displayEducation();
    
    // Clear inputs
    document.querySelector('input[name="degree"]').value = '';
    document.querySelector('input[name="school"]').value = '';
    document.querySelector('input[name="school_start_year"]').value = '';
    document.querySelector('input[name="school_end_year"]').value = '';
}

function displayEducation() {
    const listDiv = document.getElementById('education-list');
    
    if (educationList.length === 0) {
        listDiv.innerHTML = '';
        return;
    }
    
    listDiv.innerHTML = '<h3>Added Education:</h3>';
    
    educationList.forEach((edu, index) => {
        const startDate = new Date(edu.start_year);
        const endDate = new Date(edu.end_year);
        listDiv.innerHTML += `
            <div class="list-item">
                <strong>${escapeHtml(edu.degree)}</strong><br>
                ${escapeHtml(edu.school)}<br>
                ${startDate.toLocaleDateString('en-US', {month: 'short', year: 'numeric'})} - 
                ${endDate.toLocaleDateString('en-US', {month: 'short', year: 'numeric'})}
                <button type="button" onclick="removeEducation(${index})">Remove</button>
            </div>
        `;
    });
}

function removeEducation(index) {
    educationList.splice(index, 1);
    displayEducation();
}

// Add Work Experience
function addExperience() {
    const company = document.querySelector('input[name="company"]').value.trim();
    const position = document.querySelector('input[name="position"]').value.trim();
    const startYear = document.querySelector('input[name="work_start_year"]').value;
    const endYear = document.querySelector('input[name="work_end_year"]').value;
    
    // Check if any field has value
    const hasAnyValue = company || position || startYear || endYear;
    
    if (hasAnyValue) {
        // If any field has value, all must have value
        if (!company || !position || !startYear || !endYear) {
            alert('Please fill in all work experience fields or leave all empty');
            return;
        }
        
        // Validate dates
        if (new Date(startYear) > new Date(endYear)) {
            alert('Start date cannot be after end date');
            return;
        }
        
        experienceList.push({
            company: company,
            position: position,
            start_year: startYear,
            end_year: endYear
        });
        
        displayExperience();
        
        // Clear inputs
        document.querySelector('input[name="company"]').value = '';
        document.querySelector('input[name="position"]').value = '';
        document.querySelector('input[name="work_start_year"]').value = '';
        document.querySelector('input[name="work_end_year"]').value = '';
    }
}

function displayExperience() {
    const listDiv = document.getElementById('experience-list');
    
    if (experienceList.length === 0) {
        listDiv.innerHTML = '';
        return;
    }
    
    listDiv.innerHTML = '<h3>Added Experience:</h3>';
    
    experienceList.forEach((exp, index) => {
        const startDate = new Date(exp.start_year);
        const endDate = new Date(exp.end_year);
        listDiv.innerHTML += `
            <div class="list-item">
                <strong>${escapeHtml(exp.position)}</strong><br>
                ${escapeHtml(exp.company)}<br>
                ${startDate.toLocaleDateString('en-US', {month: 'short', year: 'numeric'})} - 
                ${endDate.toLocaleDateString('en-US', {month: 'short', year: 'numeric'})}
                <button type="button" onclick="removeExperience(${index})">Remove</button>
            </div>
        `;
    });
}

function removeExperience(index) {
    experienceList.splice(index, 1);
    displayExperience();
}

// Add Skill
function addSkill() {
    const skill = document.querySelector('input[name="skill"]').value.trim();
    
    if (!skill) {
        alert('Please enter a skill');
        return;
    }
    
    // Check for duplicates
    if (skillList.includes(skill)) {
        alert('This skill has already been added');
        return;
    }
    
    skillList.push(skill);
    displaySkills();
    
    // Clear input
    document.querySelector('input[name="skill"]').value = '';
}

function displaySkills() {
    const listDiv = document.getElementById('skill-list');
    
    if (skillList.length === 0) {
        listDiv.innerHTML = '';
        return;
    }
    
    listDiv.innerHTML = '<h3>Added Skills:</h3>';
    
    skillList.forEach((skill, index) => {
        listDiv.innerHTML += `
            <div class="list-item">
                ${escapeHtml(skill)}
                <button type="button" onclick="removeSkill(${index})">Remove</button>
            </div>
        `;
    });
}

function removeSkill(index) {
    skillList.splice(index, 1);
    displaySkills();
}

// Add Reference
function addReference() {
    const reference = document.querySelector('input[name="reference"]').value.trim();
    const contact = document.querySelector('input[name="reference_contact"]').value.trim();
    
    if (!reference) {
        alert('Please enter a reference name');
        return;
    }
    
    referenceList.push({
        name: reference,
        contact: contact
    });
    displayReferences();
    
    // Clear inputs
    document.querySelector('input[name="reference"]').value = '';
    document.querySelector('input[name="reference_contact"]').value = '';
}

function displayReferences() {
    const listDiv = document.getElementById('reference-list');
    
    if (referenceList.length === 0) {
        listDiv.innerHTML = '';
        return;
    }
    
    listDiv.innerHTML = '<h3>Added References:</h3>';
    
    referenceList.forEach((ref, index) => {
        const contactDisplay = ref.contact && ref.contact.trim() ? `<br><em>${escapeHtml(ref.contact)}</em>` : '';
        listDiv.innerHTML += `
            <div class="list-item">
                <strong>${escapeHtml(ref.name)}</strong>${contactDisplay}
                <button type="button" onclick="removeReference(${index})">Remove</button>
            </div>
        `;
    });
}

function removeReference(index) {
    referenceList.splice(index, 1);
    displayReferences();
}

// Validate and Submit
function validateAndNext() {
    if (educationList.length === 0) {
        alert('Please add at least one education entry');
        return false;
    }
    
    if (skillList.length === 0) {
        alert('Please add at least one skill');
        return false;
    }
    
    // Create hidden form and submit
    const form = document.querySelector('form');
    
    // Clear any existing hidden inputs
    const existingHiddenInputs = form.querySelectorAll('input[type="hidden"]');
    existingHiddenInputs.forEach(input => input.remove());
    
    // Add is_edit flag if this is an edit
    if (typeof isEdit !== 'undefined' && isEdit) {
        appendHiddenInput(form, 'is_edit', '1');
    }
    
    // Add education data
    educationList.forEach((edu, index) => {
        appendHiddenInput(form, `education[${index}][degree]`, edu.degree);
        appendHiddenInput(form, `education[${index}][school]`, edu.school);
        appendHiddenInput(form, `education[${index}][start_year]`, edu.start_year);
        appendHiddenInput(form, `education[${index}][end_year]`, edu.end_year);
    });
    
    // Add experience data (optional)
    experienceList.forEach((exp, index) => {
        appendHiddenInput(form, `experience[${index}][company]`, exp.company);
        appendHiddenInput(form, `experience[${index}][position]`, exp.position);
        appendHiddenInput(form, `experience[${index}][start_year]`, exp.start_year);
        appendHiddenInput(form, `experience[${index}][end_year]`, exp.end_year);
    });
    
    // Add skills data
    skillList.forEach((skill, index) => {
        appendHiddenInput(form, `skills[${index}]`, skill);
    });
    
    // Add references data
    referenceList.forEach((ref, index) => {
        appendHiddenInput(form, `references[${index}][name]`, ref.name);
        appendHiddenInput(form, `references[${index}][contact]`, ref.contact);
    });
    
    form.submit();
}

function appendHiddenInput(form, name, value) {
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = name;
    input.value = value;
    form.appendChild(input);
}

// Helper function to escape HTML
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}