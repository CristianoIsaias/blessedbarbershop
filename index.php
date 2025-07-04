<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <link rel="stylesheet" href="css/styleportal.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&display=swap"
    rel="stylesheet">

  <title>Portal Barber Blessed</title>
</head>

<body>

<style>
   .barber-post {
      position: relative;
      width: 120px;
      height: 300px;
      background:rgb(55,50,50);
      border-radius: 20px;
      padding: 10px;
      box-shadow: 0 0 10px #000;
    }

    .top, .bottom {
      width: 100%;
      height: 30px;
      background: rgb(55, 50, 50);
      border-radius: 50% 50% 0 0;
      position: absolute;
      left: 0;
    }

    .top {
      top: -30px;
    }

    .bottom {
      bottom: -30px;
      border-radius: 0 0 50% 50%;
    }

    .glass {
      width: 100%;
      height: 100%;
      overflow: hidden;
      border-radius: 10px;
      background: #eee;
      position: relative;
    }

    .stripes {
      position: absolute;
      width: 200%;
      height: 100%;
      background: repeating-linear-gradient(
        45deg,
        red 0,
        red 20px,
        white 20px,
        white 40px,
        blue 40px,
        blue 60px,
        white 60px,
        white 80px
      );
      animation: rotate-stripes 1s linear infinite;
    }

    @keyframes rotate-stripes {
      0% {
        transform: translateX(0);
      }
      100% {
        transform: translateX(-40px);
      }
    }
  </style>



  <div id="container">

  <div id="alinharmenu">
    <nav>        
        <ul class="menu">
           <li><a href="login.php"> Entrar</a></li>
           <li><a href="cadastro.php">Faça o seu cadastro</a></li>              
         </ul>
      </nav>
    </div>  

    <div id="marca">
      <h6>Blessed Barber Shop</h6>      
      
    </div>



  </div>





  <script>
    document.getElementById("botaoEntrar").addEventListener("click", function () {
      window.location.href = 'login.php';
      // alert("Você clicou em Entrar!");
    });


    const img = document.querySelector('.zoom-image');

    let zoomed = false;

    img.addEventListener('click', () => {
      zoomed = !zoomed;
      img.style.transform = zoomed ? 'scale(1.5)' : 'scale(1)';
    });

  </script>
</body>

</html>