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
    <div class="container marginTop60">
        <div class="centrarTexto">
            <h2>Tarifas</h2>
        </div>
        <hr id="hrPerTarifa">
        <div class="row align-items-center">
            <?php
            $tarifas = Tarifa::getTarifas();
            foreach ($tarifas as $t) {
            ?>
                <div class="col">
                    <div class="centrarTexto marginTop20 bordeRedondoFin alturaTarifa" style="width: 16rem;">
                        <img src='<?= Imagenes::getImgTarifas($t->img) ?>' class="card-img-top tamCardImg marginTop10" alt="imagen">
                        <div class="card-body centrarTexto">
                            <h5 class="card-title"> <?= $t->titulo ?></h5>
                            <p class="card-text tamCardText"> <?= $t->descripcion ?></p>
                            <b class="centrarTexto"> <?= $t->precio ?></b>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</body>

</html>