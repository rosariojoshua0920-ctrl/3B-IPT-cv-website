

 if (!validateForm()) {
        return; // Don't proceed if validation fails
    }
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


function loadNext() {
    // Validate current form before going to next
    currentIndex = (currentIndex + 1) % pages.length; 
     // Increment and loop back to 0
    loadContent(pages[currentIndex]);
}

window.onload = function() {
    loadContent('../cv-form/personal-info.php');
};