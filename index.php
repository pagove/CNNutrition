<?php
include_once("clases.php");
setcookie('PHPSESSID', 'value', time() - 1);
session_start();
?>

<doctype html>
  <html lang="en">

  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/estilos.css">
    <link rel="icon" href="<?= Imagenes::getFavIcon() ?>" type="image/x-icon">
    <title>CNutrition</title>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script>
      function cerrarSesion() {
        var datos = {
          function: "cerrarSesion"
        };
        jsonAjax("_server.php", datos, (r) => {
          if (r.ok) {
            window.location.replace("index.php");
          } else {
            alert(r.msg);
          }
        });
      }
    </script>
  </head>

  <body onload="Cargar('Inicio.php', 'cuerpo')">
    <header>
      <nav class="navbar  navbar-expand-lg navbar-dark bg-dark heightNavBar">
        <div class="container-fluid">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-5 mb-2 mb-lg-0">
              <li class="nav-item me-5 mb-2 mb-lg-0">
                <a class="nav-link active textoNavBar" aria-current="page" href="#" onclick="Cargar('Inicio.php', 'cuerpo')">Inicio</a>
              </li>
              <li class="nav-item me-5 mb-2 mb-lg-0">
                <a class="nav-link active textoNavBar" aria-current="page" href="#" onclick="Cargar('Tarifas.php', 'cuerpo')">Tarifas</a>
              </li>
              <li class="nav-item me-5 mb-2 mb-lg-0">
                <a class="nav-link active textoNavBar" aria-current="page" href="#" onclick="Cargar('SobreMi.php', 'cuerpo')">Sobre mi</a>
              </li>
              <li class="nav-item me-5 mb-2 mb-lg-0">
                <a class="nav-link active textoNavBar" aria-current="page" href="#" onclick="Cargar('Contacto.php', 'cuerpo')">Contacto</a>
              </li>
            </ul>
            <ul class="navbar-nav me-5 ms-auto mb-2 mb-lg-0 d-flex">
              <li class="nav-item me-5 mb-2 mb-lg-0">
                <a class="nav-link active textoNavBar" aria-current="page" href="#" id="loginButton" onclick="Cargar('Login.php', 'cuerpo')">Login</a>
              </li>
              <li>
                <a style="display: none !important;" class="nav-link active textoNavBar" aria-current="page" href="#" id="perfilButton" onclick="Cargar('Login.php', 'cuerpo')">Perfil</a>
              </li>
              <li>
                <a style="display: none !important;" class="nav-link active textoNavBar" aria-current="page" href="#" id="salirButton" onclick="cerrarSesion()">Salir</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>

    <div id="cuerpo" class="container-fluid">

    </div>

    <footer>
    </footer>


    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="JS/funcionalidad.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>

  </html>