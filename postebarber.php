
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Poste de Barbearia</title>
  <style>
    body {
      background: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

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
</head>
<body>

  <div class="barber-post">
    <div class="top"></div>
    <div class="glass">
      <div class="stripes"></div>
    </div>
    <div class="bottom"></div>
  </div>

</body>
</html>
