function initMap() {
   var urlInfo = window.location.hash.split('&');
   var rid = parseInt(urlInfo[0].replace("#", ""));
   var mapDiv = document.getElementById('map');
   $.post("http://localhost:8080/SLO_Hungry/api/get_rest_byId.php",
      {rId: rid},
      function(data) {
         document.getElementById('restName').innerHTML = data.name;
         document.getElementById('location').innerHTML = "Location: " + data.location;
         document.getElementById('phoneNum').innerHTML = "Phone: " + data.phone;
         document.getElementById('website').innerHTML = "Wesbite: " + data.website;
         document.getElementById('hours').innerHTML = "Hours: " + data.hours;
         $('#mainImage').attr("src", data.image);
         getRating(data.rating, rid);
         var map = new google.maps.Map(
            mapDiv, {
            center: {lat: parseFloat(data.lat), lng: parseFloat(data.long)},
            zoom: 16
         });
         var marker = new google.maps.Marker({
          position: {lat: parseFloat(data.lat), lng: parseFloat(data.long)},
          map: map,
          title: data.name
        });
      },
      'json'
   );
}

$(document).ready(function(){
   var urlInfo = window.location.hash.split('&');
   var rid = parseInt(urlInfo[0].replace("#", ""));
   var uid = parseInt(urlInfo[1]);
   var commentspage = 0;
   $("#prevComment").hide();
   $("#nextComment").hide();
   $("#inFav").hide();

   if (uid == 1) {
      $("#fav_button").hide();
   }
   else {
      $.post("http://localhost:8080/SLO_Hungry/api/check_in_favs.php",
         {rid: rid,
          uid: uid
         },
         function(data) {
            if (data.count != 0) {
               $("#fav_button").hide();
               $("#inFav").show();
            }
         },
         'json'
      );
   }


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

   $("#prevComment").click(function() {
      commentspage -= 1;
      loadComments(rid, commentspage);
   });

   $("#nextComment").click(function() {
      commentspage += 1;
      loadComments(rid, commentspage);
   });

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
      var comment = $('#comment').val();
      var price = document.getElementById("Price");
      var rating = document.getElementById("Rating");
      price = price.options[price.selectedIndex].value;
      rating = rating.options[rating.selectedIndex].value;
      var data = {};
      data['rId'] = rid;
      data['uId'] = uid;

      if (!(rating === "0")) {
         data['rating'] = rating;
      }
      if (!(price === "0")) {
         data['price'] = price;
      }
      if (!(comment === "Write Review")) {
         data['comment'] = comment;
      }


      $.post("http://localhost:8080/SLO_Hungry/api/submit_comment.php",
         data,
         function(data) {
            if (data.status == 1) {
               document.getElementById("comment").value = "Write Review";
               document.getElementById("Price").value = "0";
               document.getElementById("Rating").value = "0";
               loadComments(rid, commentspage);
            }
            else {
               alert("Failed to add comment");
            }
         },
         'json'
      );

   });


   $("#fav_button").click(function() {
      $.post("http://localhost:8080/SLO_Hungry/api/fav_rest.php",
         {rid: rid,
          uid: uid
         },
         function(data) {
            if (data.status == 1) {
               $("#fav_button").hide();
               $("#inFav").show();
            }
            else {
               alert("failed to add to favorites");
            }
         },
         'json'
      );
   });

   loadComments(rid, commentspage);   
});

function getRating (rat, id) {
   $.post("http://localhost:8080/SLO_Hungry/api/restaurant_avg.php",
      {rId: id},
      function(data) {
         var avg = parseInt(data.rating) + rat * 100;
         var count = parseInt(data.count) + 100;
         if (data.rating == null) {
            document.getElementById('rating').innerHTML = "Rating: " + rat + "/5";
         }
         else {
            document.getElementById('rating').innerHTML = "Rating: " + (avg/count).toFixed(2) + "/5";
         }
      },
      'json'
   );
}

function loadComments(rid, page) {
   $.post("http://localhost:8080/SLO_Hungry/api/get_rest_comments.php",
      {rId: rid,
       page: page
      },
      function(data) {
         var review;
         var table = document.getElementById("comments").getElementsByTagName('tbody')[0];
         while(table.rows.length > 0) {
           table.deleteRow(0);
         }

         if (data.count > 10 + page * 10) {
            $("#nextComment").show();
         }
         if (page == 0) {
            $("#prevComment").hide();
         }
         else {
            $("#prevComment").show();
         }
         for (var i = 0; i < data.comments.length; i++) {
            review = data.comments[i];
            var row = table.insertRow(i);
            var name = row.insertCell(0);
            var comment = row.insertCell(1);
            var price = row.insertCell(2);
            var rating = row.insertCell(3);
            name.innerHTML = '<a href="http://localhost:8080/SLO_Hungry/pages/profile.html#'+review.pId+'">'+review.userName+'</a>';
            comment.innerHTML = review.comment;
            price.innerHTML = review.price;
            rating.innerHTML = review.rating;
         }
      },
      'json'
   );
}

