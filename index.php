<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Vigilante Ambiental</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Aplicación Multiplataforma para denunciar problemas que afectan al medioambiente." />
    <meta name="author" content="TIC - MI RIEGO" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/fancybox/jquery.fancybox.css">
    <link rel="stylesheet" href="css/style.css"/>
    <link rel="icon" type="image/png" href="/img/favicon.png">
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>
<div id="wrapper">
    <header>
        <div class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/"><img src="img/logo_vigilante_ambiental.png" alt="logo" style="width: 220px;"/></a>
                </div>
                <div class="navbar-collapse collapse ">
                    <ul class="nav navbar-nav">
                        <li><a href="/"><i class="fa fa-2x fa-home"></i> Inicio</a></li>
                        <li class="active"><a href="vigilante_ambiental_v.0.0.1.apk"><i class="fa fa-2x fa-download"></i> Descarga la APP <i class="fa fa-2x fa-android"></i></a></li>
                        <li><a href="#"><i class="fa fa-2x fa-phone"></i> L&iacute;nea Gratuita <b style="font-size: 150%">800-10-AGUA</b></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <?php
    if (!empty($_POST)){
        $cnx = pg_connect('host=localhost dbname=bd_vigilante_ambiental user=administrador password=123456');
        $recurso = pg_query($cnx, "INSERT INTO denuncia (id_tipo_denuncia, id_estado_denuncia, numero_documento_persona, nombre_persona, contenido, ruta_multimedia, latitud, longitud, fecha_hora_enviado, fecha_hora_pendiente, fecha_hora_rechazado, fecha_hora_solucionado, estado) VALUES ('" . $_POST['id_tipo_denuncia'] . "', '" . $_POST['id_estado_denuncia'] . "', '" . $_POST['numero_documento_persona'] . "', '" . $_POST['nombre_persona'] . "', '" . $_POST['contenido'] . "', '', '" . $_POST['latitud'] . "', '" . $_POST['longitud'] . "', '" . date('Y-m-d H:i:s') . "', NULL, NULL, NULL, '" . $_POST['estado'] . "')");
        $errores = pg_last_error();
        $id = pg_last_oid($recurso);
        $extension = substr($_FILES['ruta_multimedia']['name'], -4);
        $nombre_archivo = '/archivos/' . date('Ymd_His_') . $id . $extension;
        move_uploaded_file($_FILES['ruta_multimedia']['tmp_name'], $nombre_archivo);
        $recurso = pg_query($cnx, "UPDATE denuncia SET ruta_multimedia = '" . $nombre_archivo . "' WHERE id_denuncia = " . $id);
        ?>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="well">
                        <h4>SE HA REGISTRADO CORRECTAMENTE SU DENUNCIA</h4>
                        <h1>TR&Aacute;MITE: MMAYA-VIG-AMB-<?php echo $id; ?></h1>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }else {
        ?>
        <section id="inner-headline">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="pageTitle">POR FAVOR, SELECCIONE SU TIPO DE DENUNCIA:</h1>
                        <form method="POST" enctype="multipart/form-data" id="contact-form" class="form-horizontal"
                              action="."
                              onSubmit="return(confirm('Va a enviar una denuncia al MMAyA. ¿Está seguro de continuar?'))">
                            <div class="col-lg-12 text-center" id="botones">
                                <button type="button" id="b1" class="btn btn-primary">AGUA</button>
                                <button type="button" id="b2" class="btn btn-info">AIRE</button>
                                <button type="button" id="b3" class="btn btn-danger">BASURA</button>
                                <button type="button" id="b4" class="btn btn-warning">RUIDO</button>
                                <button type="button" id="b5" class="btn btn-success">BOSQUE</button>
                                <select name="id_tipo_denuncia" id="id_tipo_denuncia" style="display: none;">
                                    <option value="" selected="selected">-Seleccionar-</option>
                                    <option value="1">AGUA</option>
                                    <option value="2">AIRE</option>
                                    <option value="3">RESIDUOS</option>
                                    <option value="4">RUIDO</option>
                                    <option value="5">BOSQUES</option>
                                </select>
                                <input name="id_estado_denuncia" type="hidden" value="1"/>
                                <div id="p1" class="panel panel-primary">
                                    <div class="panel-heading"><i class="fa fa-info-circle"></i> Denuncias de Mal uso
                                        del Agua, Fugas de ca&ntilde;er&iacute;as, Problemas con Acantarillado.
                                    </div>
                                </div>
                                <div id="p2" class="panel panel-info">
                                    <div class="panel-heading"><i class="fa fa-info-circle"></i> Denuncias de
                                        Contaminacion Vehicular, Quemas de llantas y/o goma.
                                    </div>
                                </div>
                                <div id="p3" class="panel panel-danger">
                                    <div class="panel-heading"><i class="fa fa-info-circle"></i> Denuncias de Basura
                                        acumulada, Depositos sin atender, mal estado de los contenedores.
                                    </div>
                                </div>
                                <div id="p4" class="panel panel-warning">
                                    <div class="panel-heading"><i class="fa fa-info-circle"></i> Denuncias de locales
                                        que emiten demasiado ruido.
                                    </div>
                                </div>
                                <div id="p5" class="panel panel-success">
                                    <div class="panel-heading"><i class="fa fa-info-circle"></i> Denuncias de Quema de
                                        hojas, chaqueos y bosques.
                                    </div>
                                </div>
                            </div>
                            <div id="denuncia" class="col-md-12" style="display: block;">
                                <div class="alert alert-danger text-center"><i class="fa fa-warning"></i> Por favor,
                                    llene el formulario con informaci&oacute;n correcta. Recuerde que su denuncia se
                                    remitir&aacute; con un informe a la entidad correspondiente para su soluci&oacute;n.
                                </div>
                                <div class="alert alert-success hidden" id="contactSuccess">
                                    <strong>Bien!</strong> Su denuncia ha sido enviada con exito.
                                </div>
                                <div class="alert alert-error hidden" id="contactError">
                                    <strong>Error!</strong> Aun no se puede enviar su denuncia.
                                </div>
                                <div class="contact-form">
                                    <div class="col-sm-4">
                                        <div class="well">
                                            <div class="form-group">
                                                <input type="text" name="nombre_persona" id="nombre_persona"
                                                       class="form-control wow fadeInUp" placeholder="Nombre Completo"
                                                       required autocomplete="off"/>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="numero_documento_persona"
                                                       id="numero_documento_persona" class="form-control wow fadeInUp"
                                                       placeholder="Cédula de Identidad" required autocomplete="off"/>
                                            </div>
                                            <div class="form-group">
                                                <textarea name="contenido" rows="12" cols="20" id="contenido"
                                                          class="form-control input-message wow fadeInUp"
                                                          placeholder="Describa su denuncia, por favor."
                                                          required aria-autocomplete="none"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="well">
                                            <div class="form-group">
                                                <label>Tome una FOTOGRAF&Iacute;A</label>
                                                <div id="camara"></div>
                                                <label>O puede CARGAR ARCHIVOS</label>
                                                <input type="file" name="ruta_multimedia"/>
                                                <p class="help-block">Puede cargar una imagen de hasta 2MB.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="well">
                                            <div class="form-group">
                                                <label>¿En que lugar se encuentra el PROBLEMA?</label>
                                                <div id="mapa"></div>
                                                <script>
                                                    function initMap() {
                                                        var map = new google.maps.Map(document.getElementById('mapa'), {
                                                            center: {lat: -16.5042915, lng: -68.1340691},
                                                            zoom: 16
                                                        });
                                                        var infoWindow = new google.maps.InfoWindow({map: map});
                                                        google.maps.event.addListener(map, 'click', function(event) {
                                                            addMarker(event.latLng, map);
                                                        });

                                                        // Try HTML5 geolocation.
                                                        if (navigator.geolocation) {
                                                            navigator.geolocation.getCurrentPosition(function(position) {
                                                                var pos = {
                                                                    lat: position.coords.latitude,
                                                                    lng: position.coords.longitude
                                                                };

                                                                infoWindow.setPosition(pos);
                                                                infoWindow.setContent('Location found.');
                                                                map.setCenter(pos);
                                                            }, function() {
                                                                handleLocationError(true, infoWindow, map.getCenter());
                                                            });
                                                        } else {
                                                            // Browser doesn't support Geolocation
                                                            handleLocationError(false, infoWindow, map.getCenter());
                                                        }
                                                    }

                                                    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
                                                        infoWindow.setPosition(pos);
                                                        infoWindow.setContent(browserHasGeolocation ?
                                                            'Error: The Geolocation service failed.' :
                                                            'Error: Your browser doesn\'t support geolocation.');
                                                    }
                                                    function addMarker(location, map) {
                                                        // Add the marker at the clicked location, and add the next-available label
                                                        // from the array of alphabetical characters.
                                                        var marker = new google.maps.Marker({
                                                            position: location,
                                                            label: labels[labelIndex++ % labels.length],
                                                            map: map
                                                        });
                                                    }

                                                </script>
                                                <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAvGU9Tt-udW6zrr7WoKtMwqbhKUa17nQI&signed_in=true&callback=initMap"
                                                        async defer>
                                                </script>
                                                <input type="hidden" name="latitud" value="0"/>
                                                <input type="hidden" name="longitud" value="0"/>
                                                <p class="help-block">Seleccione la ubicación, haciendo click en el
                                                    mapa.</p>
                                                <label>Cuando haya terminado, presione el bot&oacute;n:</label>
                                                <input type="hidden" name="estado" value="AC">
                                                <input type="submit" value="ENVIAR LA DENUNCIA"
                                                       class="btn btn-success wow fadeInUp"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
    ?>
    <footer>
        <div id="sub-footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="copyright">
                            <p>
                                <span>&copy; TIC-MI RIEGO 2016 Todos los Derechos Reservados.<br/>Desarrollado para el </span><a href="http://www.mimadretierra.bo" target="_blank">Hachathon 2016 Mi Madre Tierra</a>
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <ul class="social-network">
                            <li><a href="https://facebook.com/vigilanteambiental/" target="_blank" title="Danos Like"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="https://google.com/plus/vigilanteambiental" target="_blank" title="Danos +1"><i class="fa fa-google-plus"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>
<a href="#" class="scrollup"><i class="fa fa-angle-up active"></i></a>
<script src="js/jquery.js"></script>
<script src="js/jquery.easing.1.3.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.fancybox.pack.js"></script>
<script src="js/jquery.fancybox-media.js"></script>
<script src="js/portfolio/jquery.quicksand.js"></script>
<script src="js/portfolio/setting.js"></script>
<script src="js/jquery.flexslider.js"></script>
<script src="js/webcam/webcam.js"></script>
<script src="js/sweetalert/dist/sweetalert2.min.js"></script>
<script src="js/animate.js"></script>
<script src="js/custom.js"></script>
<script src="js/validate.js"></script>
<script src="js/tipo.js"></script>
</body>
</html>