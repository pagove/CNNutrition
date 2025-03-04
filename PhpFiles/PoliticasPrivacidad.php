<?php
include_once("clases.php");

$params = array_key_exists("param", $_GET) ? $_GET["param"] : false;
$dts = $params ? json_decode(Utilidades::desencriptar($params)) : false;
if (!$dts) die("Error");
if ($dts) {
    $_u = Usuario::getDatosUsuario($dts->id);
    if (!$_u) die("<h2>No se ha encontrado el usuario</h2>.");
}

$email = DatosConexion::getDatosEmail()->usr;
$nombreClinica = "CNNutrition";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Política de Privacidad - <?= $nombreClinica ?></title>
    <script src="../JS/funcionalidad.js"></script>
    <script>
        function aceptarTerminosYCondiciones(id_usuario, ip_usuario) {
            var acceptPolicy = document.getElementById("acceptPolicy").checked;
            if (acceptPolicy) {
                var datos = {
                    function: 'aceptarTerminosYCondiciones',
                    id_usuario: id_usuario,
                    ip_usuario: ip_usuario
                };
                jsonAjax("../_server.php", datos, (r) => {
                    if (r.ok) {
                        /**TODO cambiar por alert y hacer que habra un callback */
                        alert("Se han aceptado las politicas de privacidad correctamente", () => {
                            window.location.reload();
                        });
                    } else {
                        alert(r.msg);
                    }
                });
            }
        }

        function disableSubmitBtn() {
            var disabled = !document.getElementById("acceptPolicy").checked;
            document.getElementById("submitBtn").disabled = disabled;
        }
    </script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        }

        h1,
        h2 {
            color: #2C3E50;
        }

        p,
        li {
            color: #34495E;
            line-height: 1.6;
        }

        ul {
            margin: 10px 0;
        }

        a {
            color: #2980B9;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #34495E;
        }

        input[type="text"],
        input[type="tel"],
        input[type="checkbox"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        input[type="checkbox"] {
            width: auto;
            margin-right: 10px;
        }

        .btn {
            width: 100%;
            padding: 10px;
            background-color: #2980B9;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn:disabled {
            background-color: #ccc;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Política de Privacidad</h1>
        <!-- <p><strong>Última actualización:</strong> [Fecha]</p> -->
        <p>En <strong><?= $nombreClinica ?></strong>, estamos comprometidos con la protección de la privacidad y la seguridad de los datos personales de nuestros usuarios, pacientes y empleados. Esta Política de Privacidad describe cómo recopilamos, utilizamos y protegemos la información personal que nos proporcionas al interactuar con nosotros.</p>

        <h2>1. Responsable del Tratamiento de los Datos</h2>
        <p>El responsable del tratamiento de tus datos personales es:</p>
        <ul>
            <li><strong>Nombre de la Clínica:</strong> CNNutrition</li>
            <li><strong>Dirección:</strong> C. Pintor Sorolla, 19, 46790 Jeresa, Valencia</li>
            <li><strong>Correo electrónico:</strong> <?= $email ?></li>
            <li><strong>Teléfono:</strong> 633088655</li>
        </ul>

        <h2>2. Información Recopilada</h2>
        <p>Durante tu interacción con nuestros servicios, podemos recopilar los siguientes datos personales:</p>
        <ul>
            <li><strong>Datos identificativos:</strong> nombre, apellidos, fecha de nacimiento, número de identificación.</li>
            <li><strong>Datos de contacto:</strong> dirección, correo electrónico, número de teléfono.</li>
            <li><strong>Datos de salud:</strong> historial médico, datos nutricionales, condiciones médicas relevantes.</li>
            <li><strong>Datos de pago:</strong> información relacionada con los pagos de servicios (solo si corresponde).</li>
        </ul>

        <h2>3. Finalidades del Tratamiento</h2>
        <p>La Clínica recopila y procesa tus datos personales para los siguientes fines:</p>
        <ul>
            <li><strong>Provisión de servicios de nutrición y salud:</strong> Utilizamos tus datos para gestionar tus citas, preparar tus planes nutricionales y realizar un seguimiento de tu progreso.</li>
            <li><strong>Comunicaciones:</strong> Para contactarte en relación con tus citas, recordatorios, y enviar información sobre nuestros servicios.</li>
            <li><strong>Cumplimiento de obligaciones legales:</strong> Tratamos tus datos personales para cumplir con obligaciones legales que nos son aplicables, como el mantenimiento de historiales médicos y fiscales.</li>
            <li><strong>Marketing:</strong> Si has dado tu consentimiento, podremos enviarte información sobre promociones o novedades relacionadas con nuestros servicios.</li>
        </ul>

        <h2>4. Base Legal para el Tratamiento de los Datos</h2>
        <p>Dependiendo del tipo de datos y del uso que hagamos de ellos, la base legal para su tratamiento puede ser:</p>
        <ul>
            <li><strong>Consentimiento explícito del usuario:</strong> Para tratar datos sensibles relacionados con tu salud (por ejemplo, historial médico, datos nutricionales), necesitamos tu consentimiento explícito. Este consentimiento se obtiene mediante la firma de un formulario de consentimiento informado, previo a la prestación de nuestros servicios.</li>
            <li><strong>Ejecución de un contrato:</strong> Tratamos tus datos personales cuando es necesario para la ejecución de un contrato contigo. Esto incluye los datos necesarios para prestarte nuestros servicios nutricionales, como la elaboración de un plan alimenticio personalizado o la gestión de citas.</li>
            <li><strong>Cumplimiento de obligaciones legales:</strong> En algunos casos, el tratamiento de tus datos es necesario para cumplir con obligaciones legales, tales como la conservación de historiales médicos según la normativa sanitaria vigente, o el cumplimiento de normativas fiscales.</li>
            <li><strong>Interés legítimo:</strong> Podemos procesar tus datos basándonos en nuestro interés legítimo para mejorar nuestros servicios, siempre que no prevalezcan tus derechos y libertades. Por ejemplo, podríamos realizar estudios estadísticos internos para mejorar la eficacia de nuestros tratamientos nutricionales, utilizando datos anonimizados.</li>
        </ul>
        <p>Es importante destacar que puedes retirar tu consentimiento en cualquier momento para aquellos tratamientos de datos que se basen en él, sin que esto afecte la legalidad del tratamiento realizado con anterioridad a la retirada del consentimiento.</p>

        <h2>5. Compartición de Datos con Terceros</h2>
        <p>No compartimos tus datos personales con terceros, excepto en los siguientes casos:</p>
        <ul>
            <li><strong>Proveedores de servicios:</strong> Podemos compartir datos con terceros que nos ayudan a prestar nuestros servicios, como plataformas de gestión de citas o proveedores de almacenamiento de datos, siempre bajo estrictas garantías de confidencialidad.</li>
            <li><strong>Obligaciones legales:</strong> Cuando sea requerido por ley, podemos compartir datos con autoridades regulatorias o gubernamentales.</li>
            <li><strong>Profesionales sanitarios:</strong> Si es necesario para tu tratamiento, podemos compartir tus datos con otros profesionales médicos con tu previo consentimiento.</li>
        </ul>

        <h2>6. Conservación de los Datos</h2>
        <p>Conservaremos tus datos personales solo durante el tiempo necesario para cumplir con los fines para los cuales fueron recopilados, o durante el tiempo que exija la ley. En el caso de los historiales médicos, podríamos estar obligados a almacenarlos durante períodos más largos según la normativa sanitaria vigente.</p>

        <h2>7. Derechos de los Usuarios</h2>
        <p>Tienes derecho a:</p>
        <ul>
            <li><strong>Acceder</strong> a tus datos personales y solicitar una copia de los mismos.</li>
            <li><strong>Rectificar</strong> cualquier dato incorrecto o incompleto.</li>
            <li><strong>Solicitar la eliminación</strong> de tus datos cuando ya no sean necesarios para los fines para los cuales fueron recopilados, excepto cuando la ley nos obligue a conservarlos.</li>
            <li><strong>Limitar</strong> el tratamiento de tus datos en ciertas circunstancias.</li>
            <li><strong>Oponerte</strong> al tratamiento de tus datos por motivos relacionados con tu situación particular.</li>
            <li><strong>Solicitar la portabilidad</strong> de tus datos a otro proveedor de servicios, cuando sea técnicamente posible.</li>
            <li><strong>Retirar el consentimiento</strong> en cualquier momento, cuando el tratamiento se base en tu consentimiento previo.</li>
        </ul>
        <p>Para ejercer cualquiera de estos derechos, puedes contactarnos en <strong><?= $email ?></strong>.</p>

        <h2>8. Seguridad de los Datos</h2>
        <p>Implementamos medidas técnicas y organizativas para proteger tus datos personales contra pérdida, acceso no autorizado, alteración o divulgación. Nuestro personal está capacitado y comprometido con la confidencialidad y seguridad de los datos.</p>

        <h2>9. Transferencias Internacionales de Datos</h2>
        <p>En caso de que transfiramos tus datos fuera del Espacio Económico Europeo (EEE) o de tu país de residencia, nos aseguraremos de que tus datos personales reciban un nivel de protección adecuado mediante la implementación de garantías adecuadas, como contratos basados en las cláusulas contractuales tipo de la Comisión Europea.</p>

        <h2>10. Modificaciones a esta Política de Privacidad</h2>
        <p>Nos reservamos el derecho de modificar esta Política de Privacidad en cualquier momento. Cualquier cambio será publicado en nuestro sitio web con una fecha de revisión actualizada. Te recomendamos que revises esta página periódicamente.</p>

        <h2>11. Contacto</h2>
        <p>Si tienes alguna duda o inquietud sobre nuestra Política de Privacidad o sobre cómo tratamos tus datos personales, no dudes en contactarnos en:</p>
        <ul>
            <li><strong>Correo electrónico:</strong> <?= $email ?></li>
            <li><strong>Teléfono:</strong> 633088655</li>
            <li><strong>Dirección física:</strong> C. Pintor Sorolla, 19, 46790 Jeresa, Valencia</li>
        </ul>

        <h2>Consentimiento del Usuario</h2>
        <p>Al utilizar nuestros servicios, declaras que has leído y entendido esta Política de Privacidad, y consientes el tratamiento de tus datos de acuerdo con los términos aquí expuestos.</p>

        <?php
        if ($params) {
            $dt1 = new DateTime($dts->fecha_envio);
            $time_diff = $dt1->diff(new DateTime());
            $mins = ($time_diff->days * 24 * 60) + ($time_diff->h * 60) + $time_diff->i;
            if ($mins < 9240 && !Usuario::getPrivacidad($dts->id)->acepta_rgpd) {
        ?>
                <div class="form-group">
                    <label>
                        <input type="checkbox" onchange="disableSubmitBtn()" id="acceptPolicy" name="acceptPolicy">
                        He leído y acepto la <a href="#">Política de Privacidad</a>.
                    </label>
                    <div id="error-message" class="error" style="display:none;">Debes aceptar las políticas de privacidad para continuar.</div>
                </div>
                <button type="button" id="submitBtn" disabled onclick="aceptarTerminosYCondiciones('<?= $dts->id ?>','<?= $_SERVER['REMOTE_ADDR']; ?>')" class="btn">Aceptar y continuar</button>
        <?php
            }
        }
        ?>
    </div>

</body>

</html>