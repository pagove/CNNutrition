<?php
include_once("clases.php");
session_start();

if (isset($_SESSION["id_usuario"])) {
    $id_usuario = $_SESSION["id_usuario"];
?>
    <script>
        Cargar('InformacionCliente.php?id_usuario=' + <?php echo $id_usuario ?>, 'cuerpo')
    </script>
<?php
}
?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width-scale=1">
    <link rel="stylesheet" href="CSS/estilos.css">
    <title>&nbsp;</title>
    <script>
        function compruebaLogin() {
            var dts = {
                function: "compruebaLogin",
                email: document.getElementById("email").value,
                passwd: document.getElementById("passwd").value
            };
            jsonAjax("_server.php?", dts, (r) => {
                if (r.ok) {
                    if (r.rol != 0) {
                        Cargar('InicioCliente.php?id_usuario=' + r.id, 'cuerpo');
                    } else {
                        document.getElementById("perfilButton").style.display = "";
                        Cargar('InicioLogin.php?id_usuario=' + r.id, 'cuerpo');
                    }
                    localStorage.setItem("CNNutrition_email", document.getElementById("email").value);
                    document.getElementById("loginButton").style.display = "none";
                    document.getElementById("salirButton").style.display = "";

                } else {
                    alert(r.msg);
                }
            });
        }
    </script>
</head>

<body>
    <div class="row justify-content-center marginTop30">
        <div class="container tamSTD">
            <div>
                <h1 class="centrarTexto">Acceso a área personal </h1>
            </div>
            <hr class="hrPer">
            <div class="container centrarTexto tamLogin">
                <form>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Dirección de email</label>
                        <input id="email" type="email" class="form-control" aria-describedby="emailHelp">

                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Contraseña</label>
                        <input id="passwd" type="password" class="form-control">
                    </div>
                    <button type="button" class="btn btn-dark" onclick="compruebaLogin()">Entrar</button>
                </form>
            </div>

        </div>
    </div>
</body>
<script>
    if (localStorage.getItem("CNNutrition_email")) document.getElementById("email").value = localStorage.getItem("CNNutrition_email");
</script>

</html>