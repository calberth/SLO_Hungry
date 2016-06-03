$(document).ready(function(){
   var urlInfo = window.location.hash.split('&');
   var commentspage = 0;
   var fid;
   var uid;


   $("#prevComment").hide();
   $("#nextComment").hide(); 

   if (urlInfo[0] === "") {
      window.location.href = "http://localhost:8080/SLO_Hungry/pages/searchpage.html#1";
   }
   else if (urlInfo.length == 1) {
      fid = parseInt(urlInfo[0].replace("#", ""));
      uid = 1;
   }
   else {
      uid = parseInt(urlInfo[0].replace("#", ""));
      fid = parseInt(urlInfo[1]);
   }

   loadResults(fid, commentspage, uid);
   
});

function loadResults(fid, page, uid) {
   $.post("http://localhost:8080/SLO_Hungry/api/search_restaurants.php",
      {fid: fid,
       page: page, 
      },
      function(data) {
         var table = document.getElementById("results").getElementsByTagName('tbody')[0];
         while(table.rows.length > 0) {
           table.deleteRow(0);
         }
         for (var i = 0; i < data.restaurants.length; i++) {
            var rest = data.restaurants[i];
            var row = table.insertRow(i);
            var image = row.insertCell(0);
            var name = row.insertCell(1);
            var price = row.insertCell(2);
            var rating = row.insertCell(3);
            var count = row.insertCell(4);
            image.innerHTML = '<div class="imageContainer"><img src="../images/'+rest.image+'"></image></div>';
            name.innerHTML = '<a href="http://localhost:8080/SLO_Hungry/pages/restaurant.html#'+rest.rid+'&'+uid+'">'+rest.name+'</a>';
            price.innerHTML = rest.price;
            rating.innerHTML = rest.rating;
            count.innerHTML = rest.numRatings;
         }
      },
      'json'
   );
}


function getRandomInt(min, max) {
  return Math.floor(Math.random() * (max - min)) + min;
}