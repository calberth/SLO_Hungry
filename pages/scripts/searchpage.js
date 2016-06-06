$(document).ready(function(){
   var urlInfo = window.location.hash.split('&');
   var uid;

   if (urlInfo[0] === ""){
      uid = 1;
   }
   else {
      uid = parseInt(urlInfo[0].replace("#", ""));

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


   if (uid == 1) {
      $("#profile").hide();
   }

   document.getElementById("login").href = "http://localhost:8080/SLO_Hungry/pages/homepage.html";
   document.getElementById("profile").href = "http://localhost:8080/SLO_Hungry/pages/profile.html#" + uid;
   document.getElementById("Barbecue").href = "http://localhost:8080/SLO_Hungry/pages/listings.html#" + uid +"&" + 1;
   document.getElementById("Delis").href = "http://localhost:8080/SLO_Hungry/pages/listings.html#" + uid +"&" + 2;
   document.getElementById("Seafood").href = "http://localhost:8080/SLO_Hungry/pages/listings.html#" + uid +"&" + 3;
   document.getElementById("Italian").href = "http://localhost:8080/SLO_Hungry/pages/listings.html#" + uid +"&" + 4;
   document.getElementById("Southern").href = "http://localhost:8080/SLO_Hungry/pages/listings.html#" + uid +"&" + 5;
   document.getElementById("Sushi").href = "http://localhost:8080/SLO_Hungry/pages/listings.html#" + uid +"&" + 6;
   document.getElementById("Salad").href = "http://localhost:8080/SLO_Hungry/pages/listings.html#" + uid +"&" + 7;
   document.getElementById("Burgers").href = "http://localhost:8080/SLO_Hungry/pages/listings.html#" + uid +"&" + 8;
   document.getElementById("Gluten-Free").href = "http://localhost:8080/SLO_Hungry/pages/listings.html#" + uid +"&" + 9;
   document.getElementById("Greek").href = "http://localhost:8080/SLO_Hungry/pages/listings.html#" + uid +"&" + 10;
   document.getElementById("Indian").href = "http://localhost:8080/SLO_Hungry/pages/listings.html#" + uid +"&" + 11;
   document.getElementById("Japanese").href = "http://localhost:8080/SLO_Hungry/pages/listings.html#" + uid +"&" + 12;
   document.getElementById("Mexican").href = "http://localhost:8080/SLO_Hungry/pages/listings.html#" + uid +"&" + 13;
   document.getElementById("Pizza").href = "http://localhost:8080/SLO_Hungry/pages/listings.html#" + uid +"&" + 14;
   document.getElementById("Thai").href = "http://localhost:8080/SLO_Hungry/pages/listings.html#" + uid +"&" + 15;
   document.getElementById("American").href = "http://localhost:8080/SLO_Hungry/pages/listings.html#" + uid +"&" + 16;
   document.getElementById("Random").href = "http://localhost:8080/SLO_Hungry/pages/listings.html#" + uid +"&" + getRandomInt(1,16);

   $("#search_button").click(function() {
      var rest = $('#search').val();
      $.post("http://localhost:8080/SLO_Hungry/api/get_restaurant_info.php",
      {restaurant: rest},
      function(data) {
         if (data.status == 1) {
            window.location.href = "http://localhost:8080/SLO_Hungry/pages/restaurant.html#" + data.id + "&" + uid;
         }
         else {   
            alert("Restaurant Not Found")
         }
      },
      'json'
      );
   }); 

});

function getRandomInt(min, max) {
  return Math.floor(Math.random() * (max - min)) + min;
}