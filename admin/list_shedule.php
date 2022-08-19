<?php

global $wpdb;

$tabla_shedule = "{$wpdb->prefix}shedule_event";
$tabla_instructor = "{$wpdb->prefix}shedule_instructor";
$format = NULL;

?>

<script src="https://kit.fontawesome.com/e0df5df9e9.js" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<?php

if (isset($_POST['addshedule'])) {

    $querys = "SELECT eventoid FROM $tabla_shedule ORDER BY eventoid DESC limit 1";
    $ress = $wpdb->get_results($querys, ARRAY_A);
    $newid = $ress[0]['eventoid'] + 1;

    $name_g = $_POST['eventname'];

    if ($_POST['image-url']) {
        $imageurl_g = $_POST['image-url'] . '';
    } else {
        $imageurl_g = '';
    }

    $fechahorainicio_g = $_POST['fechahorainicio'];
    $fechahorafin_g = $_POST['fechahorafin'];

    $instructor_g = $_POST['instructor'][0];

    $descripcion_g = $_POST['descripcion'];
    $linkevent_g = $_POST['linkevent'];
    $linkcalendar_g = $_POST['linkcalendar'];

    $shortcode_g = "[SH_EVENT id='$newid']";

    $data = array(
        'eventoid' => null,
        'nombre' => $name_g,
        'imageLink' => $imageurl_g,
        'fechahorainicio' => $fechahorainicio_g,
        'fechahorafin' => $fechahorafin_g,
        'instructorIdAssign' => $instructor_g,
        'descripcion' => $descripcion_g,
        'linkevent' => $linkevent_g,
        'linkcalendar' => $linkcalendar_g,
        'shortcode' => $shortcode_g
    );

    try {

        $wpdb->insert($tabla_shedule, $data, $format);
        /*
        $my_id = $wpdb->insert_id;
        print_r('tabla: ' . $tabla_shedule . '| id: ' . $my_id . '<br>');
        print_r($data);
        print_r('<br>');
        print_r($wpdb->show_errors());
        print_r('<br>');
        print_r($wpdb->last_query);
*/
    } catch (Exception $e) {

        echo '<div id="error-alert" class="alert alert-danger alert-dismissible me-4 mt-4">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <strong>ERROR</strong> ' . $e->getMessage() . '
        </div>';
    }

    echo '<div id="success-alert" class="alert alert-success alert-dismissible me-4 mt-4">
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    <strong>éxito!</strong> Se ha agregado el evento
    </div>';
}

if (isset($_POST['addinstructor'])) {

    $query2 = "SELECT instructorid FROM $tabla_instructor ORDER BY instructorid DESC limit 1";
    $res2 = $wpdb->get_results($query2, ARRAY_A);
    $newid2 = $res2[0]['instructorid'] + 1;

    $name_i = $_POST['nameinstructor'];

    if ($_POST['image-url2']) {
        $imageurl_i = $_POST['image-url2'] . '';
    } else {
        $imageurl_i = '';
    }

    $cargo_i = $_POST['cargo'];
    $linkInstagram_i = $_POST['linkInstagram'];

    $whatsapp_i = $_POST['whatsapp'];

    $descripcion2_i = $_POST['descripcion2'];
    $linkcategoria_i = $_POST['linkcategoria'];

    $shortcode_i = "[SH_INSTRUCTOR id='$newid2']";

    $data2 = array(
        'instructorid' => null,
        'nombre' => $name_i,
        'cargo' => $cargo_i,
        'imageLink' => $imageurl_i,
        'descripcion' => $descripcion2_i,
        'instagramLink' => $linkInstagram_i,
        'whatsapp' => $whatsapp_i,
        'linkcategoria' => $linkcategoria_i,
        'shortcode' => $shortcode_i
    );

    try {

        $wpdb->insert($tabla_instructor, $data2, $format);
        /*
    $my_id2 = $wpdb->insert_id;
    print_r('tabla: ' . $tabla_instructor . ' | id: ' . $my_id2 . '<br>');
    print_r($data2);
    print_r('<br>');
    print_r($wpdb->show_errors());
    print_r('<br>');
    print_r($wpdb->last_query);
*/
    } catch (Exception $e) {

        echo '<div id="error-alert" class="alert alert-danger alert-dismissible me-4 mt-4">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <strong>ERROR</strong> ' . $e->getMessage() . '
        </div>';
    }

    echo '<div id="success-alert" class="alert alert-success alert-dismissible me-4 mt-4">
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    <strong>éxito!</strong> Se ha agregado el instructor
    </div>';
}

if (isset($_POST['editshedule'])) {

    $eventidedit = $_POST['eventid-edit'];

    $name_e = $_POST['eventname-edit'];

    if ($_POST['image-url3']) {
        $imageurl_e = $_POST['image-url3'] . '';
    } else {
        $imageurl_e = '';
    }

    $fechahorainicio_e = $_POST['fechahorainicio-edit'];
    $fechahorafin_e = $_POST['fechahorafin-edit'];

    $instructor_e = $_POST['instructor-edit'][0];

    $descripcion_e = $_POST['descripcion-edit'];
    $linkevent_e = $_POST['linkevent-edit'];
    $linkcalendar_e = $_POST['linkcalendar-edit'];

    $dataedit = array(
        'nombre' => $name_e,
        'imageLink' => $imageurl_e,
        'fechahorainicio' => $fechahorainicio_e,
        'fechahorafin' => $fechahorafin_e,
        'instructorIdAssign' => $instructor_e,
        'descripcion' => $descripcion_e,
        'linkevent' => $linkevent_e,
        'linkcalendar' => $linkcalendar_e
    );

    try {

        $wpdb->update($tabla_shedule, $dataedit, array('eventoid' => $eventidedit));
    } catch (Exception $e) {

        echo '<div id="error-alert" class="alert alert-danger alert-dismissible me-4 mt-4">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <strong>ERROR</strong> ' . $e->getMessage() . '
        </div>';
    }

    echo '<div id="success-alert" class="alert alert-success alert-dismissible me-4 mt-4">
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    <strong>éxito!</strong> Se ha editado el evento
    </div>';
}

if (isset($_POST['editinstructor'])) {

    $instructorid_ie = $_POST['instructorid'];
    $name_ie = $_POST['nameinstructor-edit'];

    if ($_POST['image-url4']) {
        $imageurl_ie = $_POST['image-url4'] . '';
    } else {
        $imageurl_ie = '';
    }

    $cargo_ie = $_POST['cargo-edit'];
    $linkInstagram_ie = $_POST['linkInstagram-edit'];

    $whatsapp_ie = $_POST['whatsapp-edit'];

    $descripcion2_ie = $_POST['descripcion3'];
    $linkcategoria_ie = $_POST['linkcategoria-edit'];


    $dataedit2 = array(
        'nombre' => $name_ie,
        'cargo' => $cargo_ie,
        'imageLink' => $imageurl_ie,
        'descripcion' => $descripcion2_ie,
        'instagramLink' => $linkInstagram_ie,
        'whatsapp' => $whatsapp_ie,
        'linkcategoria' => $linkcategoria_ie,
    );

    try {

        $wpdb->update($tabla_instructor, $dataedit2, array('instructorid' => $instructorid_ie));
    } catch (Exception $e) {

        echo '<div id="error-alert" class="alert alert-danger alert-dismissible me-4 mt-4">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <strong>ERROR</strong> ' . $e->getMessage() . '
        </div>';
    }

    echo '<div id="success-alert" class="alert alert-success alert-dismissible me-4 mt-4">
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    <strong>éxito!</strong> Se ha editado el instructor
    </div>';
}

$query = "SELECT * FROM $tabla_shedule";
global $list_shedule;
$list_shedule = $wpdb->get_results($query, ARRAY_A);

$query2 = "SELECT * FROM $tabla_instructor";
global $list_instructor;
$list_instructor = $wpdb->get_results($query2, ARRAY_A);

if (empty($list_shedule)) {
    $list_shedule = array();
}
if (empty($list_instructor)) {
    $list_instructor = array();
}


?>
<div class="wrap">

    <h1><?php echo get_admin_page_title(); ?></h1>

    <br><br>
    <!-------LISTA DE EVENTOS ACTIVOS--------->
    <h1 class="wp-heading-inline">Lista de eventos</h1>
    <a type="button" data-bs-toggle="modal" data-bs-target="#addEvent" class="page-title-action">Añadir nuevo evento</a>

    <table class="wp-list-table widefat fixed striped pages">
        <thead>
            <th>Imagen</th>
            <th>Nombre del evento</th>
            <th>Fecha y hora</th>
            <th>Duración</th>
            <th>Evento Id</th>
            <th>Instructor</th>
            <th>Inscripciones</th>
            <th>Acciones</th>
        </thead>
        <tbody id="the-list">

            <?php
            $today = new DateTime();
            foreach ($list_shedule as $key => $value) {

                $eventoid = $value['eventoid'];
                $nombre = $value['nombre'];
                $imageLink = $value['imageLink'];
                $fechahorainicio = $value['fechahorainicio'];
                $fechahorafin = $value['fechahorafin'];
                $instructorIdAssign = $value['instructorIdAssign'];
                $descripcion = $value['descripcion'];
                $shortcode = $value['shortcode'];
                $linkevent = $value['linkevent'];
                $linkcalendar = $value['linkcalendar'];
                $timestamp = $value['timestamp'];

                $fechahorainicio = new DateTime($fechahorainicio);
                $fechahorafin = new DateTime($fechahorafin);

                $duracion = $fechahorainicio->diff($fechahorafin);
                if ($fechahorainicio >= $today) {
            ?>

                    <tr>
                        <td>
                            <?php if (isset($imageLink) && $imageLink != '') { ?>
                                <img src='<?php echo $imageLink; ?>' width='80px' height='50px'>
                            <?php } ?>
                        </td>
                        <td><?php echo $nombre; ?></td>
                        <td><?php echo $fechahorainicio->format('d/m/Y h:i'); ?></td>
                        <td><?php

                            if ($duracion->y == 1) {
                                echo $duracion->y . " año ";
                            } else if ($duracion->y > 1) {
                                echo $duracion->y . " años ";
                            }

                            if ($duracion->m == 1) {
                                echo $duracion->m . " mes ";
                            } else if ($duracion->m > 1) {
                                echo $duracion->m . " meses ";
                            }

                            if ($duracion->d == 1) {
                                echo $duracion->d . " día ";
                            } else if ($duracion->d > 1) {
                                echo $duracion->d . " dias ";
                            }

                            if ($duracion->h == 1) {
                                echo $duracion->h . " hora ";
                            } else if ($duracion->h > 1) {
                                echo $duracion->h . " horas ";
                            }

                            if ($duracion->i == 1) {
                                echo $duracion->i . " minuto ";
                            } else if ($duracion->i > 1) {
                                echo $duracion->i . " minutos ";
                            }


                            ?>
                        </td>
                        <td><?php echo $eventoid; ?></td>

                        <td>
                            <?php foreach ($list_instructor as $key => $value) { ?>

                                <?php if ($value['instructorid'] == $instructorIdAssign) {
                                    echo $value['nombre'];
                                } ?>

                            <?php } ?>
                        </td>

                        <td><?php echo "2"; ?></td>

                        <td>
                            <a data-bs-toggle="modal" data-bs-target="#viewEvent<?php echo $eventoid; ?>" class='page-title-action'>Ver</a>
                            <a data-bs-toggle="modal" data-bs-target="#editEvent<?php echo $eventoid; ?>" class='page-title-action'>Editar</a>
                            <a data-bs-toggle="modal" data-bs-target="#deleteshedulemodal<?php echo $eventoid; ?>" class='page-title-action'>Borrar</a>
                        </td>
                    </tr>

                    <!-- Modal delete shedule -->
                    <div class="modal" id="deleteshedulemodal<?php echo $eventoid; ?>">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Evento: <?php echo $nombre; ?></h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <!-- Modal body -->
                                <div class="modal-body">
                                    ¿Segur@ que quieres eliminar este evento?
                                    <a id="deleteshedule" data-idshedule='<?php echo $eventoid; ?>' class="btn btn-danger" class='page-title-action'>ELIMINAR</a>
                                    <br> Puede tardar un rato.
                                </div>

                            </div>
                        </div>
                    </div>
                    <!----------->

                    <!---MODAL EDIT EVENT--->
                    <div class="modal fade" id="editEvent<?php echo $eventoid; ?>">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h4 class="modal-title">Editar evento</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <form method="post">

                                    <div class="modal-body">
                                        <div class="w-100">
                                            <img id='image-preview-event-edit' src='<?php echo $imageLink; ?>' height='100px' width='100%' class="mb-2">
                                            <input id="upload-button3" type="button" class="button btn btn-primary" value="Cambiar imagen" />
                                            <input id="image-url3" type="hidden" name="image-url3" value="<?php echo $imageLink; ?>" maxlength="250" />
                                        </div>

                                        <input id="eventid-edit" type="hidden" name="eventid-edit" value="<?php echo $eventoid; ?>" />

                                        <div class="mb-3 mt-3">
                                            <label for="eventname-edit" class="form-label">Nombre del evento:</label>
                                            <input type="text" class="form-control" id="eventname-edit" value="<?php echo $nombre; ?>" name="eventname-edit" maxlength='45' required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="fechahorainicio-edit" class="form-label">Fecha y hora de inicio:</label>
                                            <input type="datetime-local" id="fechahorainicio-edit" name="fechahorainicio-edit" value="<?php echo $fechahorainicio->format('Y-m-d H:i'); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="fechahorafin-edit" class="form-label">Fecha y hora de finalización:</label>
                                            <input type="datetime-local" id="fechahorafin-edit" name="fechahorafin-edit" value="<?php echo $fechahorafin->format('Y-m-d H:i'); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="instructor-edit" class="form-label">Instructor:</label>
                                            <select class="form-select" id="instructor-edit" name="instructor-edit[]" required>
                                                <?php
                                                foreach ($list_instructor as $key => $value) {
                                                    if ($instructorIdAssign == $value['instructorid']) {
                                                ?>

                                                        <option value="<?php echo $value['instructorid']; ?>" selected>
                                                            <?php echo $value['nombre']; ?></option>

                                                    <?php } else { ?>

                                                        <option value="<?php echo $value['instructorid']; ?>">
                                                            <?php echo $value['nombre']; ?></option>

                                                <?php }
                                                } ?>

                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="descripcion-edit">Descripción:</label>
                                            <textarea class="form-control" rows="5" id="descripcion-edit" name="descripcion-edit" maxlength="500"><?php echo $descripcion; ?></textarea>
                                        </div>
                                        <div class="mb-3 mt-3">
                                            <label for="linkevent-edit" class="form-label">Link del evento:</label>
                                            <input type="text" class="form-control" id="linkevent-edit" value="<?php echo $linkevent; ?>" name="linkevent-edit" maxlength='250'>
                                        </div>
                                        <div class="mb-3 mt-3">
                                            <label for="linkcalendar-edit" class="form-label">Link del calendario:</label>
                                            <input type="text" class="form-control" id="linkcalendar-edit" value="<?php echo $linkcalendar; ?>" name="linkcalendar-edit" maxlength='250'>
                                        </div>
                                        <br>
                                        <div class="w-100 text-center">
                                            <button id="editshedule" name="editshedule" type="submit" class="btn btn-primary">Editar</button>
                                        </div>
                                        <br>

                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                    <!-------------->


            <?php }
            } ?>


        </tbody>
    </table>
    <!------------------------------>

    <!-------LISTA DE EVENTOS EXPIRADOS--------->
    <h1 class="wp-heading-inline">Eventos expirados</h1>

    <table class="wp-list-table widefat fixed striped pages">
        <thead>
            <th>Imagen</th>
            <th>Nombre del evento</th>
            <th>Fecha y hora</th>
            <th>Duración</th>
            <th>Evento Id</th>
            <th>Instructor</th>
            <th>Inscripciones</th>
            <th>Acciones</th>
        </thead>
        <tbody id="the-list">

            <?php
            foreach ($list_shedule as $key => $value) {

                $eventoid = $value['eventoid'];
                $nombre = $value['nombre'];
                $imageLink = $value['imageLink'];
                $fechahorainicio = $value['fechahorainicio'];
                $fechahorafin = $value['fechahorafin'];
                $instructorIdAssign = $value['instructorIdAssign'];
                $descripcion = $value['descripcion'];
                $shortcode = $value['shortcode'];
                $linkevent = $value['linkevent'];
                $linkcalendar = $value['linkcalendar'];
                $timestamp = $value['timestamp'];

                $fechahorainicio = new DateTime($fechahorainicio);
                $fechahorafin = new DateTime($fechahorafin);

                $duracion = $fechahorainicio->diff($fechahorafin);
                if ($fechahorainicio < $today) {
            ?>

                    <tr>
                        <td>
                            <?php if (isset($imageLink) && $imageLink != '') { ?>
                                <img src='<?php echo $imageLink; ?>' width='80px' height='50px'>
                            <?php } ?>
                        </td>
                        <td><?php echo $nombre; ?></td>
                        <td><?php echo $fechahorainicio->format('d/m/Y h:i'); ?></td>
                        <td><?php

                            if ($duracion->y == 1) {
                                echo $duracion->y . " año ";
                            } else if ($duracion->y > 1) {
                                echo $duracion->y . " años ";
                            }

                            if ($duracion->m == 1) {
                                echo $duracion->m . " mes ";
                            } else if ($duracion->m > 1) {
                                echo $duracion->m . " meses ";
                            }

                            if ($duracion->d == 1) {
                                echo $duracion->d . " día ";
                            } else if ($duracion->d > 1) {
                                echo $duracion->d . " dias ";
                            }

                            if ($duracion->h == 1) {
                                echo $duracion->h . " hora ";
                            } else if ($duracion->h > 1) {
                                echo $duracion->h . " horas ";
                            }

                            if ($duracion->i == 1) {
                                echo $duracion->i . " minuto ";
                            } else if ($duracion->i > 1) {
                                echo $duracion->i . " minutos ";
                            }


                            ?>
                        </td>
                        <td><?php echo $eventoid; ?></td>

                        <td>
                            <?php foreach ($list_instructor as $key => $value) { ?>

                                <?php if ($value['instructorid'] == $instructorIdAssign) {
                                    echo $value['nombre'];
                                } ?>

                            <?php } ?>
                        </td>

                        <td><?php echo "2"; ?></td>

                        <td>
                            <a data-bs-toggle="modal" data-bs-target="#viewEvent<?php echo $eventoid; ?>" class='page-title-action'>Ver</a>
                            <a data-bs-toggle="modal" data-bs-target="#editEvent<?php echo $eventoid; ?>" class='page-title-action'>Editar</a>
                            <a data-bs-toggle="modal" data-bs-target="#deleteshedulemodal<?php echo $eventoid; ?>" class='page-title-action'>Borrar</a>
                        </td>
                    </tr>

                    <!-- Modal delete shedule -->
                    <div class="modal" id="deleteshedulemodal<?php echo $eventoid; ?>">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Evento: <?php echo $nombre; ?></h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <!-- Modal body -->
                                <div class="modal-body">
                                    ¿Segur@ que quieres eliminar este evento?
                                    <a id="deleteshedule" data-idshedule='<?php echo $eventoid; ?>' class="btn btn-danger" class='page-title-action'>ELIMINAR</a>
                                    <br> Puede tardar un rato.
                                </div>

                            </div>
                        </div>
                    </div>
                    <!----------->

                    <!---MODAL EDIT EVENT--->
                    <div class="modal fade" id="editEvent<?php echo $eventoid; ?>">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h4 class="modal-title">Editar evento</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <form method="post">

                                    <div class="modal-body">
                                        <div class="w-100">
                                            <img id='image-preview-event-edit' src='<?php echo $imageLink; ?>' height='100px' width='100%' class="mb-2">
                                            <input id="upload-button3" type="button" class="button btn btn-primary" value="Cambiar imagen" />
                                            <input id="image-url3" type="hidden" name="image-url3" value="<?php echo $imageLink; ?>" maxlength="250" />
                                        </div>

                                        <input id="eventid-edit" type="hidden" name="eventid-edit" value="<?php echo $eventoid; ?>" />

                                        <div class="mb-3 mt-3">
                                            <label for="eventname-edit" class="form-label">Nombre del evento:</label>
                                            <input type="text" class="form-control" id="eventname-edit" value="<?php echo $nombre; ?>" name="eventname-edit" maxlength='45' required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="fechahorainicio-edit" class="form-label">Fecha y hora de inicio:</label>
                                            <input type="datetime-local" id="fechahorainicio-edit" name="fechahorainicio-edit" value="<?php echo $fechahorainicio->format('Y-m-d H:i'); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="fechahorafin-edit" class="form-label">Fecha y hora de finalización:</label>
                                            <input type="datetime-local" id="fechahorafin-edit" name="fechahorafin-edit" value="<?php echo $fechahorafin->format('Y-m-d H:i'); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="instructor-edit" class="form-label">Instructor:</label>
                                            <select class="form-select" id="instructor-edit" name="instructor-edit[]" required>
                                                <?php
                                                foreach ($list_instructor as $key => $value) {
                                                    if ($instructorIdAssign == $value['instructorid']) {
                                                ?>

                                                        <option value="<?php echo $value['instructorid']; ?>" selected>
                                                            <?php echo $value['nombre']; ?></option>

                                                    <?php } else { ?>

                                                        <option value="<?php echo $value['instructorid']; ?>">
                                                            <?php echo $value['nombre']; ?></option>

                                                <?php }
                                                } ?>

                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="descripcion-edit">Descripción:</label>
                                            <textarea class="form-control" rows="5" id="descripcion-edit" name="descripcion-edit" maxlength="500"><?php echo $descripcion; ?></textarea>
                                        </div>
                                        <div class="mb-3 mt-3">
                                            <label for="linkevent-edit" class="form-label">Link del evento:</label>
                                            <input type="text" class="form-control" id="linkevent-edit" value="<?php echo $linkevent; ?>" name="linkevent-edit" maxlength='250'>
                                        </div>
                                        <div class="mb-3 mt-3">
                                            <label for="linkcalendar-edit" class="form-label">Link del calendario:</label>
                                            <input type="text" class="form-control" id="linkcalendar-edit" value="<?php echo $linkcalendar; ?>" name="linkcalendar-edit" maxlength='250'>
                                        </div>
                                        <br>
                                        <div class="w-100 text-center">
                                            <button id="editshedule" name="editshedule" type="submit" class="btn btn-primary">Editar</button>
                                        </div>
                                        <br>

                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                    <!-------------->


            <?php }
            } ?>


        </tbody>
    </table>
    <!------------------------------>

    <br><br>

    <hr>
    <br>

    <h1 class="wp-heading-inline">Instructores</h1>
    <a type="button" data-bs-toggle="modal" data-bs-target="#addInstructor" class="page-title-action">Añadir nuevo insctructor</a>
    <table class="wp-list-table widefat fixed striped pages">
        <thead>
            <th>Imagen</th>
            <th>Nombre</th>
            <th>Cargo</th>
            <th>Instructor Id</th>
            <th>Acciones</th>
        </thead>
        <tbody id="the-list">
            <?php

            foreach ($list_instructor as $key => $value) {

                $instructorid = $value['instructorid'];
                $nombre = $value['nombre'];
                $cargo = $value['cargo'];
                $imageLink = $value['imageLink'];
                $descripcion = $value['descripcion'];
                $instagramLink = $value['instagramLink'];
                $linkcategoria = $value['linkcategoria'];
                $whatsapp = $value['whatsapp'];
                $shortcode = $value['shortcode'];
                $timestamp = $value['timestamp'];

            ?>
                <tr>
                    <td>
                        <?php if (isset($imageLink) && $imageLink != '') { ?>
                            <img src='<?php echo $imageLink; ?>' width='50px' height='50px'>
                        <?php } ?>
                    </td>
                    <td><?php echo $nombre; ?></td>
                    <td><?php echo $cargo; ?></td>
                    <td><?php echo $instructorid; ?></td>
                    <td>
                        <a data-bs-toggle="modal" data-bs-target="#editinstructormodal<?php echo $instructorid; ?>" class='page-title-action'>Editar</a>
                        <a data-bs-toggle="modal" data-bs-target="#deleteinstructormodal<?php echo $instructorid; ?>" class='page-title-action'>Borrar</a>
                    </td>
                </tr>

                <!-- Modal delete shedule -->
                <div class="modal" id="deleteinstructormodal<?php echo $instructorid; ?>">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Instructor: <?php echo $nombre; ?></h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                                ¿Segur@ que quieres eliminar este instructor?
                                <a id="deleteinstructor" data-idinstructor='<?php echo $instructorid; ?>' class="btn btn-danger" class='page-title-action'>ELIMINAR</a>
                                <br> Puede tardar un rato.
                            </div>

                        </div>
                    </div>
                </div>
                <!----------->

                <!---MODAL EDIT INSTRUCTOR--->
                <div class="modal fade" id="editinstructormodal<?php echo $instructorid; ?>">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h4 class="modal-title">Editar instructor <?php echo $instructorid; ?></h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <form method="post">

                                <div class="modal-body">
                                    <div class="w-50">
                                        <img id='image-preview-instructor-edit' src='<?php echo $imageLink; ?>' height='200px' width='200px'>
                                        <input id="upload-button4" type="button" class="button btn btn-primary mt-2" value="Cambiar imagen" />
                                        <input id="image-url4" type="hidden" name="image-url4" value='<?php echo $imageLink; ?>' />
                                    </div>

                                    <input id="instructorid" type="hidden" name="instructorid" value='<?php echo $instructorid; ?>' />

                                    <div class="mb-3 mt-3">
                                        <label for="nameinstructor-edit" class="form-label">Nombre:</label>
                                        <input type="text" class="form-control" id="nameinstructor-edit" value="<?php echo $nombre; ?>" name="nameinstructor-edit" maxlength="45">
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="cargo-edit" class="form-label">Cargo:</label>
                                        <input type="text" class="form-control" id="cargo-edit" value="<?php echo $cargo; ?>" name="cargo-edit" maxlength="45">
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="linkInstagram-edit" class="form-label">Link Instagram:</label>
                                        <input type="text" class="form-control" id="linkInstagram-edit" value="<?php echo $instagramLink; ?>" name="linkInstagram-edit" maxlength="250">
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="whatsapp-edit" class="form-label">Whatsapp:</label>
                                        <input type="tel" class="form-control" id="whatsapp-edit" value="<?php echo $whatsapp; ?>" name="whatsapp-edit" maxlength="45">
                                    </div>
                                    <div class="mb-3">
                                        <label for="descripcion3">Descripción:</label>
                                        <textarea class="form-control" rows="5" id="descripcion3" name="descripcion3" maxlength="500">
                                            <?php echo $descripcion; ?>
                                        </textarea>
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="linkcategoria-edit" class="form-label">Link categoria:</label>
                                        <input type="text" class="form-control" id="linkcategoria-edit" value="<?php echo $linkcategoria; ?>" name="linkcategoria-edit" maxlength="250">
                                    </div>
                                    <br>
                                    <div class="w-100 text-center">
                                        <button id="editinstructor" name="editinstructor" type="submit" class="btn btn-primary">Editar</button>
                                    </div>
                                    <br>

                                </div>

                            </form>

                        </div>
                    </div>
                </div>
                <!-------------->

            <?php
            }
            ?>

        </tbody>
    </table>

    <!---MODAL ADD EVENT--->
    <div class="modal fade" id="addEvent">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Agregar nuevo evento</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form method="post">

                    <div class="modal-body">
                        <div class="w-100">
                            <img id='image-preview-event' src='<?php echo plugin_dir_url(__FILE__) . "img/fondocolores.jpg"; ?>' height='270px' width='100%' class="mb-2">
                            <input id="upload-button" type="button" class="button btn btn-primary" value="Cambiar imagen" />
                            <input id="image-url" type="hidden" name="image-url" value="<?php echo plugin_dir_url(__FILE__) . 'img/fondocolores.jpg'; ?>" maxlength="250" />
                        </div>

                        <div class="mb-3 mt-3">
                            <label for="eventname" class="form-label">Nombre del evento:</label>
                            <input type="text" class="form-control" id="eventname" placeholder="Nombre del evento" name="eventname" maxlength='45' required>
                        </div>
                        <div class="mb-3">
                            <label for="fechahorainicio" class="form-label">Fecha y hora de inicio:</label>
                            <input type="datetime-local" id="fechahorainicio" name="fechahorainicio" value="<?php echo date('Y-m-d h:i'); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="fechahorafin" class="form-label">Fecha y hora de finalización:</label>
                            <input type="datetime-local" id="fechahorafin" name="fechahorafin" value="<?php echo date('Y-m-d h:i'); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="instructor" class="form-label">Instructor:</label>
                            <select class="form-select" id="instructor" name="instructor[]" required>
                                <?php
                                foreach ($list_instructor as $key => $value) { ?>

                                    <option value="<?php echo $value['instructorid']; ?>">
                                        <?php echo $value['nombre'] ?></option>

                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion">Descripción:</label>
                            <textarea class="form-control" rows="5" id="descripcion" name="descripcion" maxlength="500"></textarea>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="linkevent" class="form-label">Link del evento:</label>
                            <input type="text" class="form-control" id="linkevent" placeholder="Link del evento" name="linkevent" maxlength='250'>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="linkcalendar" class="form-label">Link del calendario:</label>
                            <input type="text" class="form-control" id="linkcalendar" placeholder="Link del calendaro" name="linkcalendar" maxlength='250'>
                        </div>
                        <br>
                        <div class="w-100 text-center">
                            <button id="addshedule" name="addshedule" type="submit" class="btn btn-primary">Agregar</button>
                        </div>
                        <br>

                    </div>

                </form>

            </div>
        </div>
    </div>
    <!-------------->
    <!---MODAL ADD INSTRUCTOR--->
    <div class="modal fade" id="addInstructor">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Agregar nuevo instructor</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form method="post">

                    <div class="modal-body">
                        <div class="w-50">
                            <img id='image-preview-instructor' src='<?php echo plugin_dir_url(__FILE__) . "img/character.webp"; ?>' height='200px' width='200px'>
                            <input id="upload-button2" type="button" class="button btn btn-primary mt-2" value="Cambiar imagen" />
                            <input id="image-url2" type="hidden" name="image-url2" value='<?php echo plugin_dir_url(__FILE__) . "img/character.webp"; ?>' maxlength="250" />
                        </div>

                        <div class="mb-3 mt-3">
                            <label for="nameinstructor" class="form-label">Nombre:</label>
                            <input type="text" class="form-control" id="nameinstructor" placeholder="Nombre del instructor" name="nameinstructor" maxlength="45">
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="cargo" class="form-label">Cargo:</label>
                            <input type="text" class="form-control" id="cargo" placeholder="Cargo" name="cargo" maxlength="45">
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="linkInstagram" class="form-label">Link Instagram:</label>
                            <input type="text" class="form-control" id="linkInstagram" placeholder="Link instagram" name="linkInstagram" maxlength="250">
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="whatsapp" class="form-label">Whatsapp:</label>
                            <input type="tel" class="form-control" id="whatsapp" placeholder="Whatsapp" name="whatsapp" maxlength="45">
                        </div>
                        <div class="mb-3">
                            <label for="descripcion2">Descripción:</label>
                            <textarea class="form-control" rows="5" id="descripcion2" name="descripcion2" maxlength="500"></textarea>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="linkcategoria" class="form-label">Link categoria:</label>
                            <input type="text" class="form-control" id="linkcategoria" placeholder="Link categoria" name="linkcategoria" maxlength="250">
                        </div>
                        <br>
                        <div class="w-100 text-center">
                            <button id="addinstructor" name="addinstructor" type="submit" class="btn btn-primary">Agregar</button>
                        </div>
                        <br>

                    </div>

                </form>

            </div>
        </div>
    </div>
    <!-------------->

    <br><br><br>

    <h1 class="wp-heading-inline">Shortcodes</h1>
    <table class="wp-list-table widefat fixed striped pages">
        <thead>
            <th>
                Nombre
            </th>
            <th>
                Shortcode
            </th>

        </thead>
        <tbody id="the-list">
            <tr>
                <td>
                    Evento
                </td>
                <td>
                    [SH_EVENT id='{ID FROM EVENT}'] Example: [SH_EVENT id='14']
                </td>
            </tr>
            <tr>
                <td>
                    Instructor
                </td>
                <td>
                    [SH_INSTRUCTOR id='{ID FROM INSTRUCTOR}'] Example: [SH_INSTRUCTOR id='5']
                </td>
            </tr>
            <tr>
                <td>
                    Evento más reciente
                </td>
                <td>
                    [SH_RECENT_EVENT]
                </td>
            </tr>
            <tr>
                <td>
                    Overview todos los eventos
                </td>
                <td>
                    [SH_ALL_EVENTS]
                </td>
            </tr>
        </tbody>
    </table>

    <br><br><br>
</div>