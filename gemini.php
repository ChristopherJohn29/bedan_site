<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Train Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
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
    </style>
</head>
<body>
    <div class="header">
        <h1>BedanTracks</h1>
        <div class="d-flex justify-content-between align-items-center">
            <button class="btn btn-light btn-sm">&#8592;</button>
            <button class="btn btn-light btn-sm">&#8594;</button>
        </div>
    </div>

    <div class="train-image">
        <p><strong></strong></p>
        <img src="https://via.placeholder.com/150x50" alt="Train illustration">
    </div>

    <div class="container">
        <div class="mb-3">
            <label for="stationSelect" class="form-label">Station Selected</label>
            <select class="form-select" id="stationSelect">
                <option value="1">Station 1</option>
                <option value="2">Station 2</option>
                <option value="3">Station 3</option>
            </select>
        </div>

        <div class="arrival-info">
            <p>Here is the Train's Estimated Time of Arrival</p>
            <h2>Arriving at <strong id="stationName">Station 1</strong></h2>
            <div class="d-flex justify-content-center align-items-center">
                <span class="clock-icon me-2">&#128337;</span>
                <h3>Approximately <strong id="eta">Loading...</strong></h3>
            </div>
        </div>

        <p><strong>Current Station:</strong> <span id="currentStation">Loading...</span></p>
        <p><strong>Direction:</strong> <span id="direction">Loading...</span></p>
        <p><strong>Last Update Time:</strong> <span id="lastUpdateTime">Loading...</span></p>
        <p><strong>Time Passed since Last Update:</strong> <span id="timePassed">Loading...</span></p>
        <p>Current Time: <span id="currentTime">Loading...</span></p>
    </div>

    <div class="footer">
        <a href="#">Got a Problem? Click Here</a>
        <p>BedanTracks&copy;</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#stationSelect').change(function() {
                var selectedStation = $(this).val();
                var stationNames = {
                    '1': 'Station 1',
                    '2': 'Station 2',
                    '3': 'Station 3'
                };
                $('#stationName').text(stationNames[selectedStation]);
            });
        });


    </script>

    <script>
      $(document).ready(function() {
    $('#stationSelect').change(function() {
        const selectedStation = $(this).val();
        const stationNames = {
            '1': 'Station 1',
            '2': 'Station 2',
            '3': 'Station 3'
        };
        $('#stationName').text(stationNames[selectedStation]);
        fetchTrainStatus();
    });

    const travelTimeBetweenStations = {
        '1-2': 120, '2-3': 120, '3-1': 120,
        '2-1': 120, '3-2': 120, '1-3': 120
    };
    const waitingTimeAtStation = 10;

    const trainNetwork = {  // ***CRITICAL: Populate this!***
        1: { FORWARD: [2], BACKWARD: [3] },
        2: { FORWARD: [3], BACKWARD: [1] },
        3: { FORWARD: [1], BACKWARD: [2] }
        // ... Add all your stations and connections here!
    };

    function fetchTrainStatus() {
        $.ajax({
            url: 'getCurrentStation.php', // Path to your PHP file
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                if (!data || typeof data !== 'object' || !data.current_station || !data.direction || !data.last_update_time) {
                    console.error("Invalid data from server:", data);
                    $('#eta').text("Error: Invalid data");
                    return;
                }
                $('#currentStation').text(data.current_station);
                $('#direction').text(data.direction);
                $('#lastUpdateTime').text(data.last_update_time);

                const eta = calculateCountdown(data.last_update_time, data.current_station, data.direction);
                $('#eta').text(eta);
            },
            error: function(xhr, status, error) {
                console.error("AJAX error:", status, error);
                $('#eta').text("Error: Could not fetch data");
            }
        });
    }

    function calculateCountdown(lastUpdateTime, currentStation, direction) {
        const selectedStation = parseInt($('#stationSelect').val());
        const currentStationInt = parseInt(currentStation);
        const currentTime = new Date();
        const lastUpdate = new Date(lastUpdateTime);
        const timeDifferenceInMinutes = (currentTime - lastUpdate) / (1000 * 60);

        if (timeDifferenceInMinutes < 0) {
            timeDifferenceInMinutes = 0;
        }

        if (currentStationInt === selectedStation) {
            return "Arrived!";
        }

        const route = findRoute(currentStationInt, selectedStation, direction);

        if (!route || route.length === 0) {
            return "Error: No route found!";
        }

        let totalTravelTime = 0;
        for (let i = 0; i < route.length - 1; i++) {
            const leg = `${route[i]}-${route[i + 1]}`;
            totalTravelTime += travelTimeBetweenStations[leg] || 0;
        }

        totalTravelTime += waitingTimeAtStation;
        let remainingTime = totalTravelTime - timeDifferenceInMinutes;

        if (remainingTime < 0) {
            remainingTime = 0;
        }

        if (remainingTime <= 10) {
            return "Arrived!";
        }

        const hours = Math.floor(remainingTime / 60);
        const minutes = Math.floor(remainingTime % 60);
        const seconds = Math.round((remainingTime * 60) % 60);
        return `${hours} hrs ${minutes} min ${seconds} sec`;
    }

    function findRoute(start, end, direction) {
        const queue = [[start]];
        const visited = new Set();
        visited.add(start);

        while (queue.length > 0) {
            const path = queue.shift();
            const currentStation = path[path.length - 1];

            if (currentStation === end) {
                return path;
            }

            const neighbors = trainNetwork[currentStation][direction];
            if (neighbors) {
                for (const neighbor of neighbors) {
                    if (!visited.has(neighbor)) {
                        visited.add(neighbor);
                        queue.push(path.concat(neighbor));
                    }
                }
            }
        }
        return null;
    }

    function getCurrentTime() {
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');

        return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
    }

    function updateCurrentTime() {
        const currentTime = getCurrentTime();
        $('#currentTime').text(currentTime);
    }

    setInterval(fetchTrainStatus, 1000);
    setInterval(updateCurrentTime, 1000);

    fetchTrainStatus(); // Initial fetch
    updateCurrentTime(); // Initial update

});

    </script>
</body>
</html>
