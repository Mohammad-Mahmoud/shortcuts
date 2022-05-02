

<!DOCTYPE html>
<html>
  <head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDmhyiVkQ3SPYUemjGdP4-5xu-pMDgSvOs&callback=initMap">
    </script>
    <title>Distance Matrix Service</title>
    <style>
      #right-panel {
        font-family: 'Roboto','sans-serif';
        line-height: 30px;
        padding-left: 10px;
      }

      #right-panel select, #right-panel input {
        font-size: 15px;
      }

      #right-panel select {
        width: 100%;
      }

      #right-panel i {
        font-size: 12px;
      }
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 100%;
        width: 50%;
      }
      #right-panel {
        float: right;
        width: 48%;
        padding-left: 2%;
      }
      #output {
        font-size: 11px;
      }
    </style>
  </head>
  <body>
      <button id="but">click</button>

      
         

   <script>
       const service = new google.maps.DistanceMatrixService(); // instantiate Distance Matrix service
       const matrixOptions = {
        origins: ["aabenraa, denmark"], // technician locations
        destinations: ["haderslev, denmark"], // customer address
        travelMode: 'DRIVING',
        unitSystem: google.maps.UnitSystem.METRIC
      };
      // Call Distance Matrix service
     
         
        service.getDistanceMatrix(matrixOptions, callback);
        
      
      

      // Callback function used to process Distance Matrix response
      function callback(response, status) {
        if (status !== "OK") {
          alert("Error with distance matrix");
          return;
        }
        alert( response.rows[0].elements[0].distance.value); 
        console.log(response);   
      }



      
   </script>
    

  </body>
</html>