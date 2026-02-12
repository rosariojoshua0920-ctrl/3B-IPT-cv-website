
// Array of pages in sequence
const pages = ['../cv-form/personal-info.php', '../cv-form/experience.php', '../cv-form/result.php'];
let currentIndex = 0;  // Start at the first page

function loadContent(url) {
    fetch(url)
        .then(response => response.text())
        .then(data => {
            document.getElementById('content').innerHTML = data;
        })
        .catch(error => {
            document.getElementById('content').innerHTML = '<p> Error loading content.</p>';
        });
}

function validateForm() {
    // Get all required input and textarea fields in the current content
    const contentDiv = document.getElementById('content');
    const requiredFields = contentDiv.querySelectorAll('input[required], textarea[required]');
    
    console.log('Checking fields:', requiredFields.length); // Debug
    
    let isValid = true;
    let emptyFields = [];
    
    requiredFields.forEach(field => {
        console.log('Field:', field.name, 'Value:', field.value.trim()); // Debug
        if (!field.value || field.value.trim() === '') {
            isValid = false;
            emptyFields.push(field.placeholder || field.name || 'Unknown field');
            field.style.borderColor = 'red'; // Highlight empty fields
            field.style.borderWidth = '2px';
        } else {
            field.style.borderColor = ''; // Reset border
        }
    });
    
    if (!isValid) {
        alert('Please fill in all required fields:\n\n' + emptyFields.join('\n'));
    }
    
    return isValid;
}

function loadNext() {
    // Validate current form before going to next
    if (!validateForm()) {
        return; // Don't proceed if validation fails
    }
    
    currentIndex = (currentIndex + 1) % pages.length;  // Increment and loop back to 0
    loadContent(pages[currentIndex]);
}

window.onload = function() {
    loadContent('../cv-form/personal-info.php');
};