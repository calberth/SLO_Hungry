$(document).ready(function(){

   $("#passCheck").hide();
   $("#emailWarning").hide();

   $("p.signup_button").click(function() {
      var name = $('#usernamesignup').val();
      var email = $('#emailsignup').val();
      var pass1 = $('#passwordsignup').val();
      var pass2 = $('#passwordsignup_confirm').val();

      if (pass1 == pass2) {
         $("#passCheck").hide();
         $("#emailWarning").hide(); 


         $.post("http://localhost:8080/SLO_Hungry/api/signup.php", 
            {name: name,
            email: email,
            pass: pass1 + email},
            function(data) {
               if (data.status == 1) {
                  alert("uId: " + data.id);
               }
               else if (data.msg == "Email already taken") {
                  $("#emailWarning").show();
               }
               else {
                  alert("Error Signing Up Please Try Again");
               }
            },
            "json"
         );

      }
      else {
         $("#passCheck").show();
      }
   });
});
