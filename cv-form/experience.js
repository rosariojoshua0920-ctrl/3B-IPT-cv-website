// // Helper: get input value by name and clear it
// function getAndClear(name) {
//     const el = document.querySelector(`input[name="${name}"]`);
//     const val = el ? el.value.trim() : '';
//     if (el) el.value = '';
//     return val;
// }

// // Helper: append an entry item to a list container
// function appendEntry(containerId, text) {
//     const list = document.getElementById(containerId);
//     if (!list.querySelector('.entry-list')) {
//         const ul = document.createElement('div');
//         ul.className = 'entry-list';
//         list.appendChild(ul);
//     }
//     const ul = list.querySelector('.entry-list');

//     const item = document.createElement('div');
//     item.className = 'entry-item';
//     item.innerHTML = `<span>${text}</span><button class="remove-btn" title="Remove">&#x2715;</button>`;
//     item.querySelector('.remove-btn').addEventListener('click', () => item.remove());
//     ul.appendChild(item);
// }

// // Add Education
// function addEducation() {
//     const degree    = getAndClear('degree');
//     const school    = getAndClear('school');
//     const startYear = getAndClear('school_start_year');
//     const endYear   = getAndClear('school_end_year');

//     if (!school) { alert('Please enter a Degree and School name.'); return; }

//     const parts = [];
//     if (degree)    parts.push(degree);
//     if (school)    parts.push(school);
//     if (startYear || endYear) parts.push(`(${startYear || '?'} – ${endYear || 'Present'})`);

//     appendEntry('education-list', parts.join(' | '));
// }

// // Add Work Experience
// function addExperience() {
//     const company   = getAndClear('company');
//     const position  = getAndClear('position');
//     const startYear = getAndClear('work_start_year');
//     const endYear   = getAndClear('work_end_year');

//     if (!company && !position) { alert('Please enter a company or position.'); return; }

//     const parts = [];
//     if (position) parts.push(position);
//     if (company)  parts.push(`at ${company}`);
//     if (startYear || endYear) parts.push(`(${startYear || '?'} – ${endYear || 'Present'})`);

//     appendEntry('experience-list', parts.join(' '));
// }

// // Add Skill
// function addSkill() {
//     const skill = getAndClear('skill');
//     if (!skill) { alert('Please enter a skill.'); return; }
//     appendEntry('skill-list', skill);
// }

// // Add Reference
// function addReference() {
//     const reference = getAndClear('reference');
//     if (!reference) { alert('Please enter a reference.'); return; }
//     appendEntry('reference-list', reference);
// }

// // Next / Submit
// function submitForm() {
//     // Placeholder: collect data and proceed
//     alert('Proceeding to next step...');
// }

//         function validateAndNext() {
//             // Get all inputs/textareas in the current content
//             const requiredFields = document.querySelectorAll('input[required], textarea[required]');
//             let isValid = true;
            
//             requiredFields.forEach(field => {
//                 if (!field.value.trim()) {
//                     isValid = false;
//                     field.style.borderColor = 'red';
//                     field.style.borderWidth = '2px';
//                 } else {
//                     field.style.borderColor = '';
//                 }
//             });
            
//             if (!isValid) {
//                 alert('Please fill in all required fields');
//                 return;
//             }
            
//             // Save form data and move to next
//             document.querySelector('form').submit();
//         }

        

// Storage arrays for form data
let educationList = [];
let experienceList = [];
let skillList = [];
let referenceList = [];

// Load existing data from session when page loads
window.addEventListener('DOMContentLoaded', function() {
    // Load existing education
    if (typeof existingEducation !== 'undefined' && existingEducation.length > 0) {
        educationList = existingEducation;
        displayEducation();
    }
    
    // Load existing experience
    if (typeof existingExperience !== 'undefined' && existingExperience.length > 0) {
        experienceList = existingExperience;
        displayExperience();
    }
    
    // Load existing skills
    if (typeof existingSkills !== 'undefined' && existingSkills.length > 0) {
        skillList = existingSkills;
        displaySkills();
    }
    
    // Load existing references
    if (typeof existingReferences !== 'undefined' && existingReferences.length > 0) {
        referenceList = existingReferences;
        displayReferences();
    }
});

// Add Education
function addEducation() {
    const degree = document.querySelector('input[name="degree"]').value;
    const school = document.querySelector('input[name="school"]').value;
    const startYear = document.querySelector('input[name="school_start_year"]').value;
    const endYear = document.querySelector('input[name="school_end_year"]').value;
    
    if (degree && school && startYear && endYear) {
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
    } else {
        alert('Please fill in all education fields');
    }
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
                <strong>${edu.degree}</strong><br>
                ${edu.school}<br>
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
    const company = document.querySelector('input[name="company"]').value;
    const position = document.querySelector('input[name="position"]').value;
    const startYear = document.querySelector('input[name="work_start_year"]').value;
    const endYear = document.querySelector('input[name="work_end_year"]').value;
    
    if (company && position && startYear && endYear) {
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
    } else {
        alert('Please fill in all work experience fields');
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
                <strong>${exp.position}</strong><br>
                ${exp.company}<br>
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
    const skill = document.querySelector('input[name="skill"]').value;
    
    if (skill) {
        skillList.push(skill);
        displaySkills();
        
        // Clear input
        document.querySelector('input[name="skill"]').value = '';
    } else {
        alert('Please enter a skill');
    }
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
                ${skill}
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
    const reference = document.querySelector('input[name="reference"]').value;
    
    if (reference) {
        referenceList.push(reference);
        displayReferences();
        
        // Clear input
        document.querySelector('input[name="reference"]').value = '';
    } else {
        alert('Please enter a reference');
    }
}

function displayReferences() {
    const listDiv = document.getElementById('reference-list');
    
    if (referenceList.length === 0) {
        listDiv.innerHTML = '';
        return;
    }
    
    listDiv.innerHTML = '<h3>Added References:</h3>';
    
    referenceList.forEach((ref, index) => {
        listDiv.innerHTML += `
            <div class="list-item">
                ${ref}
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
    
    // Create hidden form and submit
    const form = document.querySelector('form');
    
    // Clear any existing hidden inputs
    const existingHiddenInputs = form.querySelectorAll('input[type="hidden"]');
    existingHiddenInputs.forEach(input => input.remove());
    
    // Add education data
    educationList.forEach((edu, index) => {
        appendHiddenInput(form, `education[${index}][degree]`, edu.degree);
        appendHiddenInput(form, `education[${index}][school]`, edu.school);
        appendHiddenInput(form, `education[${index}][start_year]`, edu.start_year);
        appendHiddenInput(form, `education[${index}][end_year]`, edu.end_year);
    });
    
    // Add experience data
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
        appendHiddenInput(form, `references[${index}]`, ref);
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