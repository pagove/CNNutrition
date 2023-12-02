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
                if(r.ok){
                    Cargar('InformacionCliente.php?id_usuario=' + r.id, 'cuerpo')
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
                <h1 class="centrarTexto">Acceso a área de administración</h1>
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
                    <button type="button" class="btn btn-dark" onclick="Cargar('InicioCliente.html', 'cuerpo')">Prueba</button>
                </form>
            </div>

        </div>
    </div>
</body>
</html>