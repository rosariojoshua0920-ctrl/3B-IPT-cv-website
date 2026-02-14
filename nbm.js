// Track current page
var currentPage = null;

function loadContent(url){
	fetch(url)
	.then(function(res){
		if(!res.ok) throw new Error('Network response was not ok');
		return res.text();
	})
	.then(function(html){
		document.getElementById('content').innerHTML = html;
		window.scrollTo({top:0,behavior:'smooth'});
		
		// Update current page and toggle home button visibility
		currentPage = url;
		updateNavButtonVisibility();
	})
	.catch(function(err){
		console.error(err);
		document.getElementById('content').innerHTML = '<p style="padding:20px">Failed to load content.</p>';
	});
}

function updateNavButtonVisibility(){
	var homeBtn = document.querySelector('button[onclick*="main-page.php"]');
	if(homeBtn){
		// Hide home button if currently on home page, show otherwise
		if(currentPage && currentPage.includes('main-page.php')){
			homeBtn.style.display = 'none';
		} else {
			homeBtn.style.display = 'inline-flex';
		}
	}
}

// Load default view on page load (main page)
document.addEventListener('DOMContentLoaded', function(){
	loadContent('../main/main-page.php');
});
