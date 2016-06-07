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
      $.ajax({
         url: "http://localhost:8080/SLO_Hungry/api/check_session.php",
         async: false,
         dataType: "json",
         success: function(data){
            if (data.uid != uid) {
               uid = 1;
            }
         }
      });   
   }

   loadResults(fid, commentspage, uid);

   if (uid == 1) {
      $("#profile").hide();
   }

   document.getElementById("filter").onchange = function() {
      alert("hello");
      loadResults(fid, commentspage, uid);
   }

   document.getElementById("search").href = "http://localhost:8080/SLO_Hungry/pages/searchpage.html#" + uid;
   document.getElementById("login").href = "http://localhost:8080/SLO_Hungry/pages/homepage.html";
   document.getElementById("profile").href = "http://localhost:8080/SLO_Hungry/pages/profile.html#" + uid;
   
});

function loadResults(fid, page, uid) {
   var filter = document.getElementById("filter");
   filter = filter.options[filter.selectedIndex].value;

   $.post("http://localhost:8080/SLO_Hungry/api/search_restaurants.php",
      {fid: fid,
       page: page,
       filter: filter 
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