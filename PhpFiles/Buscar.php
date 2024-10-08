<?php
include_once("clases.php");
session_start();
?>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width-scale=1">
    <link rel="stylesheet" href="/css/estilos.css">
    <title>&nbsp;</title>
    <script>
        function enviarMailRGPD(email, id, nombre, ap1, ap2) { // se llama desde la función listarUsuarios.
            debugger;
            var dts = {
                function: "enviarMailRGPD",
                email: email,
                id_usuario: id,
                nombre: nombre,
                ap1: ap1,
                ap2: ap2
            };

            jsonAjax("_server.php", dts, (r) => {
                if (r.ok) {
                    alert("Se ha enviado el correo correctamente");
                } else {
                    alert(r.msg);
                }
            });

        }

        function listarUsuarios() {
            document.getElementById("tabla_usuarios").style.display = "none";
            document.getElementById("sin_resultado").style.display = "none";
            var dts = {
                function: "listarUsuarios",
                nombre: document.getElementById("nombre").value,
                ap1: document.getElementById("ap1").value,
                ap2: document.getElementById("ap2").value,
                email: document.getElementById("email").value,
                tel: document.getElementById("tel").value
            };
            jsonAjax("_server.php?", dts, (r) => {
                if (r.length > 0) {
                    document.getElementById("tabla_usuarios").style.display = "";
                    document.getElementById("sin_resultado").style.display = "none";
                    var tbody = "";
                    r.forEach((u) => {
                        tbody += "<tr>";
                        tbody += "<th scope='row'>" + u.nombre + " " + u.apellido1 + " " + u.apellido2 + "</th>";
                        tbody += "<td>" + u.movil + "</td>";
                        tbody += "<td>" + u.email + "</td>";
                        tbody += "<td>";
                        if (u.acepta_rgpd) {
                            tbody += "<button type='button' disabled class='btn btn-outline-dark'>Envia RGPD</button>";
                        } else {
                            tbody += "<button type='button' onclick='enviarMailRGPD(\"" + u.email + "\", \"" + u.id + "\", \"" + u.nombre + "\", \"" + u.apellido1 + "\", \"" + u.apellido2 + "\")' class='btn btn-outline-dark'>Envia RGPD</button>";
                        }
                        tbody += "</td><td>";
                        if (u.acepta_rgpd) {
                            tbody += "<button type='button' onclick='verPerfilUsuario(" + u.id + ")' class='btn btn-outline-dark'>Ver</button>";
                        } else {
                            tbody += "<button type='button' disabled class='btn btn-outline-dark'>Ver</button>";
                        }
                        tbody += "</td>";

                    });
                    document.getElementById("lista").innerHTML = tbody;
                } else {
                    document.getElementById("tabla_usuarios").style.display = "none";
                    document.getElementById("sin_resultado").style.display = "";
                }

            });
        }

        function verPerfilUsuario(idUsuario) {
            console.log(idUsuario);
            Cargar('InformacionCliente.php?id_usuario=' + idUsuario, 'cuerpoLogin')
        }
    </script>
</head>

<body>
    <div class="container marginTop30">
        <div class="alert alert-info" role="alert">
            Introduce alguno de los campos para buscar al cliente deseado.
        </div>
        <br>
        <div class="row">
            <div class="col-md-4">
                <label for="validationCustom01" class="form-label">Nombre</label>
                <input type="text" id="nombre" class="form-control" id="validationCustom01" name="nombre" placeholder="Mark">
            </div>
            <div class="col-md-4">
                <label for="validationCustom02" class="form-label">Primer Apellido</label>
                <input type="text" id="ap1" class="form-control" id="validationCustom02" name="ap1" placeholder="Otto">
            </div>
            <div class="col-md-4">
                <label for="validationCustom02" class="form-label">Segundo Apellido</label>
                <input type="text" id="ap2" class="form-control" id="validationCustom02" name="ap2" placeholder="Obama">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <label for="validationDefaultUsername" class="form-label">Correo electrónico</label>
                <div class="input-group">
                    <input type="email" id="email" class="form-control" id="validationDefaultUsername" name="email" aria-describedby="inputGroupPrepend2" placeholder="example@gmail.com">
                </div>
            </div>
            <div class="col-md-4">
                <label for="validationCustom03" class="form-label">Móvil</label>
                <input type="number" id="tel" class="form-control" name="tel" id="validationCustom03" placeholder="xxxxxxxxx">
            </div>
        </div>
        <div class="row marginTop10">
            <div class="col-12">
                <button type="button" onclick="listarUsuarios()" class="btn btn-outline-dark marginLeft20"> Buscar </button>
            </div>
        </div>

        <table id="tabla_usuarios" class="table table-striped marginTop20" style="display: none;">
            <thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Móvil</th>
                    <th scope="col">Correo</th>
                    <th scope="col">RGPD</th>
                    <th scope="col">Ver perfil</th>
                </tr>
            </thead>
            <tbody id="lista" class="overflow-auto">
            </tbody>
        </table>
        <div style="display: none;" id="sin_resultado" class="alert alert-danger marginTop20" role="alert">
            No se han encontrado resultados.
        </div>
    </div>
</body>

</html>