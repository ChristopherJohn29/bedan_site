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

    .gif-container {
      display: flex;
      justify-content: center;
      align-items: center;
    }

    img.tren {
      max-width: 100%;
      height: auto;
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
  <div class="gif-container">
    <img class="tren" src="/image.png" alt="Moving GIF" />
  </div>
  <div class="gif-container">
    <a href="/main.php"><img class="tren" src="/image2.png" alt="Moving GIF" /></a>
  </div>



  <!-- Footer -->
  <div class="footer">
   <p>BedanTracks&copy;</p>
  </div>



  <!-- Bootstrap JS (Optional) -->
  <script
    src="js/bootstrap.bundle.min.js"
  ></script>
  <!-- jQuery (if needed) -->
  <script src="js/jquery-3.6.4.min.js"></script>




</body>
</html>
