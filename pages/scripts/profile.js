$(document).ready(function(){

      var user = "Test Username";
      var reviews;

      $("button").click(function(){
         
         var uId = $('input:text').val();

         $.post("http://localhost:8080/SLO_Hungry/api/get_profile_info.php", 
            {uId: uId},

            function(data) { /*not seeing alerts*/
              alert(data.status+data.name);

               uId = data.uId;
               user = data.name;
               document.getElementById("user_name").innerHTML = user;      
              
            },
            "json"
         );

         $.post("http://localhost:8080/SLO_Hungry/api/get_user_comments.php",
            {uId: uId,
            page: 0},

            function(data) {
               alert(data.count);

               reviews = data.count;
               document.getElementById("reviews").innerHTML = reviews;      
              
            },
            "json"
         );
       
      });  
});

