<?php
include_once("clases.php");

?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width-scale=1">
    <link rel="stylesheet" href="CSS/estilos.css">
    <title>&nbsp;</title>
</head>

<body>
    <div class="row justify-content-center marginTop30">
        <div id="carouselExampleIndicators" class="carousel slide tamSTD" data-bs-ride="carousel">
            <h1>Información general</h1>
            <hr class="hrPer">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner ">
                <div class="carousel-item active">
                    <img src="web_images/poster.jpeg" class="img-fluid tamImagenCarousel" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="web_images/vestidor.jpeg" class="d-block tamImagenCarousel" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="web_images/productos.jpeg" class="d-block tamImagenCarousel" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <div class="tamSTD">
            <p class="textoUnderCarousel">No es lo mismo comer que alimentarse, y por eso, desde CN nutrición trabajamos para mejorar la vida de nuestros clientes, ofreciéndoles las herramientas necesarias para que adopten hábitos saludables y consigan mejorar su alimentación.
                Te acompañamos durante el proceso, te motivamos y te ayudamos; realizamos un seguimiento semanal y estamos a tu disposición diariamente. Y todo, para que TÚ consigas el objetivo que te propongas.</p>
            <br>
        </div>
    </div>
</body>

</html>