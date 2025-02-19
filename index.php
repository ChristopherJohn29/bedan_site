<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Train Tracker</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css"
    rel="stylesheet"
  />
  <style>
    body {
      background-color: #f8f9fa;
      color: #4e0261;
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
    .arrival-info {
      background-color: #4e0261;
      color: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      text-align: center;
      padding: 20px;
      margin: 20px;
      border: 3px solid #fff;
    }
    .arrival-info p {
      margin: 0;
      font-size: 1rem;
    }
    .arrival-info h2 {
      font-size: 1.5rem;
      margin: 10px 0;
    }
    .arrival-info h3 {
      font-size: 2.5rem;
      margin: 10px 0;
      color: #f97316;
    }
    .arrival-info .clock-icon {
      color: #f97316;
      font-size: 36px;
    }
    .footer {
      text-align: center;
      padding: 10px;
      font-size: 14px;
    }
    /* Responsive adjustments for mobile devices */
    @media (max-width: 576px) {
      .arrival-info {
        padding: 10px;
        margin: 10px;
      }
      .arrival-info h2 {
        font-size: 1.2rem;
      }
      .arrival-info h3 {
        font-size: 2rem;
      }
      .header {
        padding: 5px;
      }
    }
  </style>
</head>
<body>
  <div class="header">
    <img src="/HEADER.png" alt="Train illustration" class="img-fluid" />
  </div>

  <div class="train-image">
    <!-- Optionally, add a train image here -->
  </div>

  <div class="container">
    <div class="mb-3">
      <label for="stationSelect" class="form-label">Origin Station</label>
      <select class="form-select" id="stationSelect">
        <option value="1">Legarda</option>
        <option value="2">Pureza</option>
        <option value="3">Recto</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="destinationSelect" class="form-label">Destination Station</label>
      <select class="form-select" id="destinationSelect">
        <option value="1">Legarda</option>
        <option value="2" selected>Pureza</option>
        <option value="3">Recto</option>
      </select>
    </div>

    <div class="arrival-info">
      <p>Here is the Train's Estimated Time of Arrival</p>
      <h2 style="front-style:italic; color:#f1916e;">Arriving at <strong id="stationName" style="front-style:italic; color:white">Legarda</strong></h2>
      <div class="d-flex justify-content-center align-items-center">
        <span class="clock-icon me-2">&#128337;</span>
        <label style="front-style:italic; color:#f1916e;">
          Approximately at <br>
          <strong id="eta" style="front-style:italic; color:##c83803;">Loading...</strong>
        </label>
      </div>
    </div>

    <p>
      <strong>Current Station:</strong>
      <span id="currentStation">Loading...</span>
    </p>
    <p>
      <strong>Direction:</strong>
      <span id="direction">Loading...</span>
    </p>
    <p>
      <strong>Last Update Time:</strong>
      <span id="lastUpdateTime">Loading...</span>
    </p>
    <p>
      Current Time: <span id="currentTime">Loading...</span>
    </p>
  </div>

  <div class="footer">
    <a href="#">Got a Problem? Click Here</a>
    <p>BedanTracks&copy;</p>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

  <script>
     $(document).ready(function() {
        function updateDestinationOptions() {
            var origin = $('#stationSelect').val();
            var destination = $('#destinationSelect').val();

            const stationNames = {
                '1': 'Legarda',
                '2': 'Pureza',
                '3': 'Recto'
            };
            $('#stationName').text(stationNames[origin]);

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
            '1': 10,  // Time to Station 1 (in seconds)
            '2': 10,  // Time to Station 2 (in seconds)
            '3': 10   // Time to Station 3 (in seconds)
        };

        // Waiting time at each station in seconds (if needed)
        var waitingTimeAtStation = 10; // seconds

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

                    if(calculateCountdown == 'Problem occured'){
                        // popup the image
                    } else {
                        //hide the popup
                        $('#eta').text(eta);
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
                        if(timeDifferenceInSeconds < 5){
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
                        
                        if(timeDifferenceInSeconds < 5){
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
                        if(timeDifferenceInSeconds < 5){
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
                        if(timeDifferenceInSeconds < 5){
                            return "Arrived";
                        }
                    }
                }
            }

            // (Optional) Add waiting time at each station if needed
            // totalTravelTimeInSeconds += waitingTimeAtStation * numberOfStops;

            // Subtract elapsed time
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
