$(document).ready(function(){
   var urlInfo = window.location.hash.split('&');
   var commentspage = 0;
   var fid;
   var uid;


   $("#prevComment").hide();
   $("#nextComment").hide(); 

   if (urlInfo[0] === "") {
      fid = getRandomInt(1,16);
      uid = 1;
   }
   else if (urlInfo.length == 1) {
      fid = parseInt(urlInfo[0].replace("#", ""));
      uid = 1;
   }
   else {
      uid = parseInt(urlInfo[0].replace("#", ""));
      fid = parseInt(urlInfo[1]);
   }

   loadResults(fid, commentspage);
   
});

function loadResults(fid, page) {
   $.post("http://localhost:8080/SLO_Hungry/api/search_restaurants.php",
      {fid: fid,
       page: commentspage,
       filter: filter  
      },
      function(data) {
         var table = document.getElementById("results").getElementsByTagName('tbody')[0];
         while(table.rows.length > 0) {
           table.deleteRow(0);
         }
      },
      'json'
   );
}


function getRandomInt(min, max) {
  return Math.floor(Math.random() * (max - min)) + min;
}