function loadContent(url){
	fetch(url)
	.then(function(res){
		if(!res.ok) throw new Error('Network response was not ok');
		return res.text();
	})
	.then(function(html){
		document.getElementById('content').innerHTML = html;
		window.scrollTo({top:0,behavior:'smooth'});
	})
	.catch(function(err){
		console.error(err);
		document.getElementById('content').innerHTML = '<p style="padding:20px">Failed to load content.</p>';
	});
}

// Load default view on page load (main page)
document.addEventListener('DOMContentLoaded', function(){
	loadContent('../main/main-page.php');
});
