<?php
  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verificar si los datos han sido enviados
    $userId = filter_var($_POST['userId'], FILTER_SANITIZE_NUMBER_INT);
    $purchaseNumber = filter_var($_POST['purchaseNumber'], FILTER_SANITIZE_NUMBER_INT);
    $name = filter_var($_POST['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastName = filter_var($_POST['lastName'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $telephone = filter_var($_POST['telephone'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $bank = filter_var($_POST['bank'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Verificar si alguno de los campos está vacío
    if (empty($userId) || empty($purchaseNumber) || empty($name) || empty($lastName) || empty($email) || empty($telephone) || empty($bank)) {
      // redireccionar a error
      header("Location: error.php");
      exit();
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sorteo Tienda Perfumes</title>
    <link rel="icon" href="./resources/img/background-modal.png">
    <link rel="stylesheet" href="./resources/style/view-style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Akshar:wght@300..700&display=swap" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/casino" rel="stylesheet">
                
<body>
    <section class="background-modal" id="background-modal">
    <div id="welcome-modal" class="modal">
      <div class="main-modal-box">
      <div class="header-modal">
        <h1>
            Bienvenido!
        </h1>  
        <button class="close-modal-btn" onclick="closeModal('background-modal')">
        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
        <g clip-path="url(#clip0_21_1432)">
        <path d="M9.29183 9.292C9.38473 9.19888 9.49508 9.12499 9.61657 9.07458C9.73806 9.02416 9.8683 8.99821 9.99983 8.99821C10.1314 8.99821 10.2616 9.02416 10.3831 9.07458C10.5046 9.12499 10.6149 9.19888 10.7078 9.292L15.9998 14.586L21.2918 9.292C21.3848 9.19903 21.4952 9.12527 21.6167 9.07495C21.7381 9.02464 21.8683 8.99874 21.9998 8.99874C22.1313 8.99874 22.2615 9.02464 22.383 9.07495C22.5045 9.12527 22.6149 9.19903 22.7078 9.292C22.8008 9.38498 22.8746 9.49536 22.9249 9.61683C22.9752 9.73831 23.0011 9.86851 23.0011 10C23.0011 10.1315 22.9752 10.2617 22.9249 10.3832C22.8746 10.5046 22.8008 10.615 22.7078 10.708L17.4138 16L22.7078 21.292C22.8008 21.385 22.8746 21.4954 22.9249 21.6168C22.9752 21.7383 23.0011 21.8685 23.0011 22C23.0011 22.1315 22.9752 22.2617 22.9249 22.3832C22.8746 22.5046 22.8008 22.615 22.7078 22.708C22.6149 22.801 22.5045 22.8747 22.383 22.925C22.2615 22.9754 22.1313 23.0013 21.9998 23.0013C21.8683 23.0013 21.7381 22.9754 21.6167 22.925C21.4952 22.8747 21.3848 22.801 21.2918 22.708L15.9998 17.414L10.7078 22.708C10.6149 22.801 10.5045 22.8747 10.383 22.925C10.2615 22.9754 10.1313 23.0013 9.99983 23.0013C9.86835 23.0013 9.73815 22.9754 9.61667 22.925C9.49519 22.8747 9.38481 22.801 9.29183 22.708C9.19886 22.615 9.12511 22.5046 9.07479 22.3832C9.02447 22.2617 8.99857 22.1315 8.99857 22C8.99857 21.8685 9.02447 21.7383 9.07479 21.6168C9.12511 21.4954 9.19886 21.385 9.29183 21.292L14.5858 16L9.29183 10.708C9.19871 10.6151 9.12482 10.5048 9.07441 10.3833C9.024 10.2618 8.99805 10.1315 8.99805 10C8.99805 9.86847 9.024 9.73822 9.07441 9.61673C9.12482 9.49524 9.19871 9.38489 9.29183 9.292Z" fill="#7A7A7A"/>
        <rect width="32" height="32" fill="#D9D9D9" fill-opacity="0.15"/>
        </g>
        <defs>
        <clipPath id="clip0_21_1432">
        <rect width="32" height="32" fill="white"/>
        </clipPath>
        </defs>
        </svg>

        </button>
      </div>
      
        <p class="text-modal">
            ¡Hola, <span class="dynamic-text"><?php echo ($name); ?></span>! 
        </p>
     
      <p class="text-modal">
        Gracias por tu compra en Tienda de perfumes! 🎉 Ahora estás participando en nuestra Slots Machine 🎰. <span class="dynamic-text">Gira y gana premios espectaculares como:</span> 
      </p>
     
      <ul class="text-modal">
        <li><span class="dynamic-text">💰 Vouchers de dinero </span>en efectivo</li>
        <li><span class="dynamic-text"> ✈️ Viajes </span> a destinos de ensueño</li>
        <li><span class="dynamic-text">🚗 ¡Un AUTO CERO KM</span>, el mejor de todos!</li>
      </ul>
      </div>
      <br>
    </div>
    </section>

<!-- Winner modal -->
<section style="display:none" class="background-modal" id="background-modal-winner">
    <div id="winner-modal" class="modal">
      <div class="main-modal-box">
      <div class="header-modal">
        <h1>
          Felicidades!
        </h1>  
        <button class="close-modal-btn" onclick="closeModal('background-modal-winner')">
        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
        <g clip-path="url(#clip0_21_1432)">
        <path d="M9.29183 9.292C9.38473 9.19888 9.49508 9.12499 9.61657 9.07458C9.73806 9.02416 9.8683 8.99821 9.99983 8.99821C10.1314 8.99821 10.2616 9.02416 10.3831 9.07458C10.5046 9.12499 10.6149 9.19888 10.7078 9.292L15.9998 14.586L21.2918 9.292C21.3848 9.19903 21.4952 9.12527 21.6167 9.07495C21.7381 9.02464 21.8683 8.99874 21.9998 8.99874C22.1313 8.99874 22.2615 9.02464 22.383 9.07495C22.5045 9.12527 22.6149 9.19903 22.7078 9.292C22.8008 9.38498 22.8746 9.49536 22.9249 9.61683C22.9752 9.73831 23.0011 9.86851 23.0011 10C23.0011 10.1315 22.9752 10.2617 22.9249 10.3832C22.8746 10.5046 22.8008 10.615 22.7078 10.708L17.4138 16L22.7078 21.292C22.8008 21.385 22.8746 21.4954 22.9249 21.6168C22.9752 21.7383 23.0011 21.8685 23.0011 22C23.0011 22.1315 22.9752 22.2617 22.9249 22.3832C22.8746 22.5046 22.8008 22.615 22.7078 22.708C22.6149 22.801 22.5045 22.8747 22.383 22.925C22.2615 22.9754 22.1313 23.0013 21.9998 23.0013C21.8683 23.0013 21.7381 22.9754 21.6167 22.925C21.4952 22.8747 21.3848 22.801 21.2918 22.708L15.9998 17.414L10.7078 22.708C10.6149 22.801 10.5045 22.8747 10.383 22.925C10.2615 22.9754 10.1313 23.0013 9.99983 23.0013C9.86835 23.0013 9.73815 22.9754 9.61667 22.925C9.49519 22.8747 9.38481 22.801 9.29183 22.708C9.19886 22.615 9.12511 22.5046 9.07479 22.3832C9.02447 22.2617 8.99857 22.1315 8.99857 22C8.99857 21.8685 9.02447 21.7383 9.07479 21.6168C9.12511 21.4954 9.19886 21.385 9.29183 21.292L14.5858 16L9.29183 10.708C9.19871 10.6151 9.12482 10.5048 9.07441 10.3833C9.024 10.2618 8.99805 10.1315 8.99805 10C8.99805 9.86847 9.024 9.73822 9.07441 9.61673C9.12482 9.49524 9.19871 9.38489 9.29183 9.292Z" fill="#7A7A7A"/>
        <rect width="32" height="32" fill="#D9D9D9" fill-opacity="0.15"/>
        </g>
        <defs>
        <clipPath id="clip0_21_1432">
        <rect width="32" height="32" fill="white"/>
        </clipPath>
        </defs>
        </svg>

        </button>
      </div>
     
        <p id="winner-name" class="text-modal dynamic-text">

        </p>
      
      <p class="text-modal">
        Has ganado un <span id="winner-data" class="dynamic-text"></span>. Revisa tu correo <span id="winner-email" class="dynamic-text"></span> te hemos enviado un mensaje.
      </p>
     
      </div>
    </div>
    </section>

    <div class="main_box">
        <h1>
        ¡Tira de la palanca y prueba tu suerte!
        </h1>
        <div id="app">
            <div id="slot-machine-video-btn"
                  data-user-id="<?php echo ($userId); ?>" 
                  data-purchase-number="<?php echo ($purchaseNumber); ?>" 
                  data-name="<?php echo ($name); ?>" 
                  data-last-name="<?php echo ($lastName); ?>" 
                  data-email="<?php echo ($email); ?>" 
                  data-telephone="<?php echo ($telephone); ?>" 
                  data-bank="<?php echo ($bank); ?>" 
            ></div>
            <div class="doors">
              <div class="door">
                  <div class="boxes">
                  </div>
              </div>

              <div class="door">
                  <div class="boxes">
                  </div>
              </div>

              <div class="door">
                  <div class="boxes">
                  </div>
              </div>
            </div>
            <video id="slot-machine-video-loser" src="./resources/video/loser.mp4"></video>
            <video style="display:none" id="slot-machine-video-winner" src="./resources/video/winner.mp4"></video>
            
        </div>
      
    </div>
    
</body>
</html>
<script>
  
</script>
<script  src="./resources/js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@tsparticles/confetti@3.0.3/tsparticles.confetti.bundle.min.js"></script>
