<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Train Tracker</title>
  
  <link
    href="css/bootstrap.min.css"
    rel="stylesheet"
  />
  <link 
    rel="stylesheet" 
    href="css/bootstrap-icons.css"
  />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <style>

    body {
      background-color: #f8f9fa;
      color: #4e0261;
      font-family: 'Poppins', sans-serif;
    }

    .header {
      background-color: #4e0261;
      color: #fff;
      padding: 10px;
      text-align: center;
    }
    .header img {
      max-width: 100%;
      height: auto;
    }

    .train-image {
      text-align: center;
      margin: 20px 0;
    }
    .train-image img {
      max-width: 100%;
      height: auto;
    }

    /* Arrival Info Card (Replaces older .arrival-info style) */
    .arrival-info {
      background-color: #4e0261; /* Purple background */
      color: #fff;
      border: 3px solid #fff;
      border-radius: 10px;
      padding: 20px;
      text-align: center;
      max-width: 400px; /* Just for demo centering, adjust or remove as needed */
      margin: 20px auto; /* Center horizontally */
    }
    .arrival-info p {
      margin: 0;
      font-size: 1rem;
      font-weight: 500;
    }
    .arrival-info .station {
      font-size: 1.3rem;
      margin: 10px 0;
      font-weight: 600;
      display: inline-block;
      color: #fff;
    }
    /* ETA styling in orange (or #f1916e) */
    .arrival-info .eta {
      font-size: 2rem;
      color: #f1916e;
      margin: 0;
      font-weight: 700;
    }
    .arrival-info .info-subtitle {
      font-size: 1rem;
      font-style: italic;
      color: #f1916e;
    }

        /* Popup image styling */
     #popupImage {
        display: none;
        position: fixed;
        top: 45%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 1000;
        }
    #popupImage img {
        width: clamp(185px, 170vw, 673px);
        height: auto;
    }

    /* Responsive adjustments for mobile devices */
    @media (max-width: 576px) {
      .arrival-info {
        padding: 15px;
        margin: 15px;
      }
      .arrival-info .station {
        font-size: 1.1rem;
      }
      .arrival-info .eta {
        font-size: 1.5rem;
      }
      .arrival-info p {
        font-size: 0.9rem;
      }

      .container {
        padding: 10px; /* Reduce container padding on mobile */
      }
    }

    .footer {
      text-align: center;
      padding: 10px;
      font-size: 14px;
    }

  </style>
</head>
<body>
  <!-- Header -->
  <div class="header">
    <img src="/HEADER.png" alt="Train illustration" class="img-fluid" />
  </div>

  <!-- Optional Train Image -->
  <div id="popupImage" style="display: none; position: fixed; top: 45%; left: 50%; transform: translate(-50%, -50%); z-index: 1000;">
    <img src="/BT_NOTIF.png" alt="Error Popup" />
  </div>

  <div class="container">
    <!-- Station Selections -->
    <div class="mb-3">
      <label for="stationSelect" class="form-label">Origin Station</label>
      <select class="form-select" id="stationSelect">
        <option value="1">Pureza</option>
        <option value="2">Legarda</option>
        <option value="3">Recto</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="destinationSelect" class="form-label">Destination Station</label>
      <select class="form-select" id="destinationSelect">
        <option value="1">Pureza</option>
        <option value="2" selected>Legarda</option>
        <option value="3">Recto</option>
      </select>
    </div>

    <!-- Arrival Info Card -->
    <div class="arrival-info">
      <p>Estimated Time of Arrival on Origin</p>
      <h2 class="station">
        <!-- Location Pin icon from Bootstrap Icons (optional) -->
        <i class="bi bi-geo-alt-fill me-1"></i>
        Arriving at <strong id="stationName">Legarda station</strong>
      </h2>
      <h3>
        <!-- Clock icon from Bootstrap Icons (optional) -->
        <i class="bi bi-clock-fill me-1"></i>
        <span class="info-subtitle">Approximately at</span>
        <br />
        <span class="eta" id="eta">Loading...</span>
      </h3>
    </div>

    <!-- Additional Info -->

    <div class="arrival-info">
      <p>Estimated Time of Arrival on Destination</p>
      <h3>
        <!-- Clock icon from Bootstrap Icons (optional) -->
        <i class="bi bi-clock-fill me-1"></i>
        <span class="info-subtitle">Approximately at</span>
        <br />
        <span class="eta" id="eta_destination">Loading...</span>
      </h3>
    </div>

  </div>

  <!-- Footer -->
  <div class="footer">
    <a href="#">Got a Problem? Click Here</a>
    <p>BedanTracks&copy;</p>
  </div>

  <!-- Bootstrap JS (Optional) -->
  <script
    src="js/bootstrap.bundle.min.js"
  ></script>
  <!-- jQuery (if needed) -->
  <script src="js/jquery-3.6.4.min.js"></script>

  <script>
$(document).ready(function() {
   function updateDestinationOptions() {
       var origin = $('#stationSelect').val();
       var destination = $('#destinationSelect').val();

       const stationNames = {
           '1': 'Pureza',
           '2': 'Legarda',
           '3': 'Recto'
       };
       $('#stationName').text(stationNames[origin]+ " station");

       $('#destinationSelect option').prop('disabled', false); // Enable all options first

       if (origin) {
           $('#destinationSelect option[value="' + origin + '"]').prop('disabled', true); // Disable selected origin

           // If the current destination is the same as the origin, change it to a different station
           if (origin === destination) {
               var newDestination = $('#destinationSelect option:not(:disabled)').first().val();
               $('#destinationSelect').val(newDestination);
           }
       }
   }

   // Run function when origin changes
   $('#stationSelect').change(function() {
       updateDestinationOptions();
   });

   // Run function when page loads to ensure correct state
   updateDestinationOptions();
});

</script>

<script>
$(document).ready(function() {



   // Travel time between stations in seconds
   var travelTimeBetweenStations = {
       '1': 8,  // Time to Station 1 (in seconds)
       '2': 8,  // Time to Station 2 (in seconds)
       '3': 8   // Time to Station 3 (in seconds)
   };

   // Waiting time at each station in seconds (if needed)
   var waitingTimeAtStation = 8; // seconds

   function fetchTrainStatus() {
       $.ajax({
           url: 'getCurrentStation.php',  // PHP file to fetch data from the database
           method: 'GET',
           dataType: 'json',
           success: function(data) {
               // Update the UI with the fetched data
               $('#currentStation').text(data.current_station);
               $('#direction').text(data.direction);
               $('#lastUpdateTime').text(data.last_update_time);

               // Calculate ETA based on selected station and current data
               var eta = calculateCountdown(data.last_update_time, data.current_station, data.direction);

               var selectedStation = parseInt($('#stationSelect').val(), 10);
               var destinationStation = parseInt($('#destinationSelect').val(), 10);
               
               var difference = Math.abs(selectedStation - destinationStation);

               if(eta == 'Problem occured'){
                   // popup the image
                   $('#popupImage').fadeIn();

               } else {
                   //hide the popup
                   $('#popupImage').hide();

                   $('#eta').text(eta);

                   if(eta !== 'Arrived' && eta !== 'Arriving' && eta !== 'Problem occured'){
                        // If eta is a string like "30 sec", parseInt will extract the numeric part.
                        var etaSeconds = typeof eta === 'string' ? parseInt(eta, 10) : eta;
                        eta_destination = etaSeconds + (difference * 10);

                        $('#eta_destination').text(eta_destination + " sec");
                    }  else {
                        $('#eta_destination').text("Loading");
                    }

                   
               }

            
           },
           error: function() {
               console.log('Error fetching data');
           }
       });
   }

   function calculateCountdown(lastUpdateTime, currentStation, direction) {
       var selectedStation = $('#stationSelect').val(); // The station the user is tracking
       var destinationStation = $('#destinationSelect').val(); // The final destination station
       var currentTime = new Date();
       var lastUpdate = new Date(lastUpdateTime);  

       // Prevent calculation if no station is selected
       if (!selectedStation) return "Select a Station";

       // Time passed since last update (in seconds)
       var timeDifferenceInSeconds = (currentTime - lastUpdate) / 1000;  

       console.log(timeDifferenceInSeconds);

       if(timeDifferenceInSeconds > 15){
           return "Problem occured";
       }


       var totalTravelTimeInSeconds = 0;


       if (direction === 'FORWARD') {
           if (currentStation == 1) {
               if (selectedStation == 2) {
                   if(destinationStation == 1){
                       totalTravelTimeInSeconds = travelTimeBetweenStations['2'] + travelTimeBetweenStations['3'] + travelTimeBetweenStations['2'];
                   } else {
                       totalTravelTimeInSeconds = travelTimeBetweenStations['1'];
                   }
               } else if (selectedStation == 3) {
                   totalTravelTimeInSeconds = travelTimeBetweenStations['1'] + travelTimeBetweenStations['2'];
               } else {
                   totalTravelTimeInSeconds = travelTimeBetweenStations['2'] + travelTimeBetweenStations['3'] + travelTimeBetweenStations['2'] + travelTimeBetweenStations['1'];
                   if(timeDifferenceInSeconds < 4){
                       return "Arrived";
                   }

               }
           } else if (currentStation == 2) {
               if (selectedStation == 1) {
                   totalTravelTimeInSeconds = travelTimeBetweenStations['3'] + travelTimeBetweenStations['2'] + travelTimeBetweenStations['1'];
               } else if (selectedStation == 3) {
                   totalTravelTimeInSeconds = travelTimeBetweenStations['2'];
               } else if (selectedStation == 2 && destinationStation == 3) {
                   totalTravelTimeInSeconds = travelTimeBetweenStations['3'] + travelTimeBetweenStations['2'] + travelTimeBetweenStations['1'] + travelTimeBetweenStations['2'];
                   
                   if(timeDifferenceInSeconds < 4){
                       return "Arrived";
                   }

               }  else if (selectedStation == 2 && destinationStation == 1) {
                   totalTravelTimeInSeconds = travelTimeBetweenStations['3'] + travelTimeBetweenStations['2'];

                   
               }
           }
       }

       // BACKWARD Direction: 1 → 2 → 3 → 2 → 1
       else if (direction === 'BACKWARD') {
           if (currentStation == 3) {
               if (selectedStation == 2 && destinationStation == 1) {
                   totalTravelTimeInSeconds = travelTimeBetweenStations['2'];
               } else if (selectedStation == 2 && destinationStation == 3) {
                   totalTravelTimeInSeconds = travelTimeBetweenStations['2'] + travelTimeBetweenStations['1'] + travelTimeBetweenStations['2'];
               }
               else if (selectedStation == 1) {
                   totalTravelTimeInSeconds = travelTimeBetweenStations['2'] + travelTimeBetweenStations['1'];
               } else {
                   totalTravelTimeInSeconds = travelTimeBetweenStations['2'] + travelTimeBetweenStations['1'] + travelTimeBetweenStations['2'] + travelTimeBetweenStations['3'];
                   if(timeDifferenceInSeconds < 4){
                       return "Arrived";
                   }
               }
           } else if (currentStation == 2) {
               if (selectedStation == 1) {
                   totalTravelTimeInSeconds = travelTimeBetweenStations['1'];
               } else if (selectedStation == 3) {
                   // Train must go to 1 first, then to 3
                   totalTravelTimeInSeconds = travelTimeBetweenStations['1'] + travelTimeBetweenStations['2'] + travelTimeBetweenStations['3'];
               } else if (selectedStation == 2 && destinationStation == 3) {
                   // Train must complete the route 2 → 1 → 2
                   totalTravelTimeInSeconds = travelTimeBetweenStations['1'] + travelTimeBetweenStations['2'];

               } else if (selectedStation == 2 && destinationStation == 1) {
                   // Train must complete the route 2 → 1 → 2
                   totalTravelTimeInSeconds = travelTimeBetweenStations['1'];
                   if(timeDifferenceInSeconds < 4){
                       return "Arrived";
                   }
               }
           }
       }

       var remainingTimeInSeconds = totalTravelTimeInSeconds - timeDifferenceInSeconds;

       var secondsLeft = Math.floor(remainingTimeInSeconds % 60);
       
       if((secondsLeft + 3) < 0){
           display = "Arriving";
       } else {
           return (secondsLeft + 3) + " sec";
       }

       return display;
       
   }

   // Fetch data every second
   setInterval(fetchTrainStatus, 1000);

   function getCurrentTime() {
       var now = new Date();
       var year = now.getFullYear();
       var month = (now.getMonth() + 1).toString().padStart(2, '0');
       var day = now.getDate().toString().padStart(2, '0');
       var hours = now.getHours().toString().padStart(2, '0');
       var minutes = now.getMinutes().toString().padStart(2, '0');
       var seconds = now.getSeconds().toString().padStart(2, '0');

       var formattedTime = year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds;
       return formattedTime;
   }

   function updateCurrentTime() {
       var currentTime = getCurrentTime();
       $('#currentTime').text(currentTime);
   }

   // Update current time every second
   setInterval(updateCurrentTime, 1000);
});



</script>
</body>
</html>
