<html>
<head>
	<link rel="stylesheet" type="text/css" href="../../style/style.css" />
</head>
<body>

<div class = "info_page_container">
<div class= "bigImage">
	<image src = "../../images/restaurants/firestone.jpg" style = "width: inherit; height: inherit">
</div>
<div class = "info_box">
	<h1>
	Firestone Bar and Grill
	</h1>
	<ul style="list-style-type:none">	
		<li>Location:</li> 
		<li>Phone: </li>
		<li>Website: </li>
		<li>Hours: </li>
		<br>
		<li style =  "color:#A2BC13">Rating: </li>
		<li style =  "color:#A2BC13">Price: </li>
	</ul>
<script src='https://maps.googleapis.com/maps/api/js?v=3.exp'></script>
<div style='overflow:hidden;height:300px;width:450px;'>
	<div id='gmap_canvas' style='height:300px;width:450px;'>
	</div>
	<div><small><a href="http://embedgooglemaps.com">embed google maps</a></small></div>
	<div><small><a href="https:/disclaimergenerator.net">disclaimer example</a></small></div>
	<style>#gmap_canvas img{max-width:none!important;background:none!important}</style></div>
	<script type='text/javascript'>function init_map(){
		var myOptions = {zoom:15,center:new google.maps.LatLng(35.28054417002725,-120.65570274282226),mapTypeId: google.maps.MapTypeId.ROADMAP};
		map = new google.maps.Map(document.getElementById('gmap_canvas'), myOptions);
		marker = new google.maps.Marker({map: map,position: new google.maps.LatLng(35.28054417002725,-120.65570274282226)});
		infowindow = new google.maps.InfoWindow({content:'<strong>Firestone </strong><br>1001 Higuera St, San Luis Obispo, CA 93401<br>'});
		google.maps.event.addListener(marker, 'click', function(){infowindow.open(map,marker);});
		infowindow.open(map,marker);}google.maps.event.addDomListener(window, 'load', init_map);
	</script>

</div>

<div class = "reviews">
	<h3>User Reviews</h3>
	<textarea class = "comment_box"></textarea>
	<button class = "review_button">Submit review</button>
	<div class = "restaurant_holder" id = "user_box">
		<div class = "user_image">
			<image src="../../images/users/obama.jpg" style ="height:inherit; width:inherit;">
		</div>
		<div class = "details">
			<h3>Barack Obama</h3>
			<p style="font-style:italic">"Pretty good tri tip!"</p>
		</div>
		<div class = "ratings">
			<h4>Rating: 5/5</h4>
		</div>
	</div>
</div>

</div>


</body>
</html>