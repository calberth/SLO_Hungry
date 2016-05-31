//load comments 
/*$.post("http://localhost:8080/SLO_Hungry/api/get_rest_comments.php",
   {rId: id
    page: 0  
   },
   function(data) {

   },
   'json'
);*/

$(document).ready(function(){
   var urlInfo = window.location.hash.split('&');
   var rid = parseInt(urlInfo[0].replace("#", ""));
   

   $.post("http://localhost:8080/SLO_Hungry/api/get_rest_byId.php",
      {rId: rid},
      function(data) {
         document.getElementById('location').innerHTML = "Location: " + data.location;
         document.getElementById('phoneNum').innerHTML = "Phone: " + data.phone;
         document.getElementById('website').innerHTML = "Wesbite: " + data.website;
         document.getElementById('hours').innerHTML = "Hours: " + data.hours
      },
      'json'
   );

   $.post("http://localhost:8080/SLO_Hungry/api/get_rest_byId.php",
      {rId: rid},
      function(data) {
         document.getElementById('restName').innerHTML = data.name;
         document.getElementById('location').innerHTML = "Location: " + data.location;
         document.getElementById('phoneNum').innerHTML = "Phone: " + data.phone;
         document.getElementById('website').innerHTML = "Wesbite: " + data.website;
         document.getElementById('hours').innerHTML = "Hours: " + data.hours;
         getRating(data.rating, rid)
      },
      'json'
   );

   $.post("http://localhost:8080/SLO_Hungry/api/restaurant_price.php",
      {rId: rid},
      function(data) {
         var price = "";
         for (i = 0; i < Math.round(data.price); i++) {
            price = price + "$";
         }
         document.getElementById('price').innerHTML = "Price: " + price;
      },
      'json'
   );

   $("#submit_button").click(function() {
      var urlInfo = window.location.hash.split('&');
      var uid = parseInt(urlInfo[1]);
      var comment = $('#comment').val();
      var price = document.getElementById("Price");
      var rating = document.getElementById("Rating");
      price = price.options[price.selectedIndex].value;
      rating = rating.options[rating.selectedIndex].value;

      if (rating === "0") {
         rating = null;
      }
      if (price === "0") {
         price = null;
      }
      if (comment === "Write Review") {
         comment = null;
      }

      alert(comment + " " + rating + " " + price);

   });



});

function getRating (rat, id) {
   var rating = rat * 100;
   $.post("http://localhost:8080/SLO_Hungry/api/restaurant_avg.php",
      {rId: id},
      function(data) {
         avg = data.rating + rating;
         count = data.count + 100;
         if (data.rating == null) {
            document.getElementById('rating').innerHTML = "Rating: " + rat + "/5";
         }
         else {
            document.getElementById('rating').innerHTML = "Rating: " + avg/count + "/5";
         }
      },
      'json'
   );
}

