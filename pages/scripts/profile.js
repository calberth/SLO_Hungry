$(document).ready(function(){
   var urlInfo = window.location.hash.split('&');
   var uid;
   var pid;
   var comments_page = 0;
   var fav_page = 0;

   uid = parseInt(urlInfo[0].replace("#", ""));

   $.ajax({
      url: "http://localhost:8080/SLO_Hungry/api/check_session.php",
      async: false,
      dataType: "json",
      success: function(data){
         pid = data.uid;
      }
   });

   $.post("http://localhost:8080/SLO_Hungry/api/get_profile_info.php", 
      {uId: uid},
      function(data) {
         document.getElementById("user_name").innerHTML = data.name;              
      },
      "json"
   );

   $("#prevComment").click(function() {
      comments_page -= 1;
      loadComments(uid, comments_page);
   });

   $("#nextComment").click(function() {
      comments_page += 1;
      loadComments(uid, comments_page);
   });

   loadComments(uid, comments_page);

   $("#prevFav").click(function() {
      fav_page -= 1;
      loadFavs(uid, fav_page, pid);
   });

   $("#nextFav").click(function() {
      fav_page += 1;
      loadFavs(uid, fav_page, pid);
   });

   loadFavs(uid, fav_page, pid);

   document.getElementById("search").href = "http://localhost:8080/SLO_Hungry/pages/searchpage.html#" + pid;
   document.getElementById("login").href = "http://localhost:8080/SLO_Hungry/pages/homepage.html";
     
});



function loadComments(uid, page, pid) {
   $.post("http://localhost:8080/SLO_Hungry/api/get_user_comments.php",
      {uId: uid,
      page: page},
      function(data) {
         var review;
         var table = document.getElementById("comments").getElementsByTagName('tbody')[0];
         document.getElementById("reviews").innerHTML = "Num of Reviews " + data.count;
         while(table.rows.length > 0) {
           table.deleteRow(0);
         }

         if (data.count > 10 + page * 10) {
            $("#nextComment").show();
         }
         else {
            $("#nextComment").hide();
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
            name.innerHTML = '<a href="http://localhost:8080/SLO_Hungry/pages/restaurant.html#'+review.rid+'&'+pid+'">'+review.name+'</a>';
            comment.innerHTML = review.comment;
            price.innerHTML = review.price;
            rating.innerHTML = review.rating;
         }             
      },
      "json"
   );
}

function loadFavs(uid, page, pid) {
   $.post("http://localhost:8080/SLO_Hungry/api/get_favs.php",
      {uid: uid,
      page: page},
      function(data) {
         var fav;
         var table = document.getElementById("favs").getElementsByTagName('tbody')[0];
         while(table.rows.length > 0) {
           table.deleteRow(0);
         }

         if (data.count > 10 + page * 10) {
            $("#nextFav").show();
         }
         else {
            $("#nextFav").hide();
         }
         if (page == 0) {
            $("#prevFav").hide();
         }
         else {
            $("#prevFav").show();
         }
         for (var i = 0; i < data.restaurants.length; i++) {
            fav = data.restaurants[i];
            var row = table.insertRow(i);
            var name = row.insertCell(0);
            name.innerHTML = '<a href="http://localhost:8080/SLO_Hungry/pages/restaurant.html#'+fav.rid+'&'+pid+'">'+fav.name+'</a>';
         }             
      },
      "json"
   );
}