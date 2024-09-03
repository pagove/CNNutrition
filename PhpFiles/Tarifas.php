<?php
//require("/volume1/web/phpBD/baseDatos.php");
include_once("../clases.php");
?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width-scale=1">
    <link rel="stylesheet" href="css/estilos.css">
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
            $tarifas = recuperarTarifas();
            while ($fila = mysqli_fetch_row($tarifas)) {

                $imagen = "web_images/imgTarifas/" . $fila[4];
                $titulo = $fila[1];
                $descripcion = $fila[2];
                $precio = $fila[3] . " €";
            ?>
                <div class="col">
                    <div class="centrarTexto marginTop20 bordeRedondoFin alturaTarifa" style="width: 16rem;">
                        <img src='<?php echo $imagen ?>' class="card-img-top tamCardImg marginTop10" alt="imagen">
                        <div class="card-body centrarTexto">
                            <h5 class="card-title"> <?php echo $titulo ?></h5>
                            <p class="card-text tamCardText"> <?php echo $descripcion ?></p>
                            <b class="centrarTexto"> <?php echo $precio ?></b>
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