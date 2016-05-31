$(document).ready(function(){

   $("#loginbutton").click(function() {
      var email = $('#email').val();
      var pass = $('#password').val(); 

      $.post("http://localhost:8080/SLO_Hungry/api/login.php", 
         {email: email,
         pass: pass + email},
         function(data) {
            if (data.status == 1) {
               var uId = data.uId
               alert("login success " + uId)
            }
            else {
               alert("Invalid Username or Password");
            }
         },
         "json"
      );
   });
});
