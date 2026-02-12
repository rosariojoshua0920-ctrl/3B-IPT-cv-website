function loadContent(url) {
    fetch(url)
        .then(response => response.text())
        .then(data => {
            document.getElementById('content').innerHTML = data;
        })
        .catch(error => {
            document.getElementById('content').innerHTML = '<p>Error loading content.</p>';
        });
}

        window.onload = function() {
            loadContent('../main/main-page.php');
        };