
<?php

global $wpdb;

$tabla_shedule = "{$wpdb->prefix}shedule_event";
$tabla_instructor = "{$wpdb->prefix}shedule_instructor";


if (isset($_POST['addshedule'])) {

    $query = "SELECT eventoid FROM $tabla_shedule ORDER BY eventoid DESC limit 1";
    $res = $wpdb->get_results($query, ARRAY_A);
    $newid = $res[0]['eventoid'] + 1;

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

    $shortcode_g = "[SH_EVENT id='$newid']";

    $data = [
        'eventoid' => null,
        'nombre' => $name_g,
        'imageLink' => $imageurl_g,
        'fechahorainicio' => $fechahorainicio_g,
        'fechahorafin' => $fechahorafin_g,
        'instructorIdAssign' => $instructor_g,
        'descripcion' => $descripcion_g,
        'linkevent' => $linkevent_g,
        'shortcode' => $shortcode_g
    ];

    try {

        $wpdb->insert($tabla_shedule, $data);
    } catch (Exception $e) {

        echo '<div id="error-alert" class="alert alert-danger alert-dismissible me-4 mt-4">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <strong>ERROR</strong> ' . $e->getMessage() . '
        </div>';
    }

    echo '<div id="success-alert" class="alert alert-success alert-dismissible me-4 mt-4">
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    <strong>¡Éxito!</strong> Se ha agregado el evento
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

    $data2 = [
        'instructorid' => null,
        'nombre' => $name_i,
        'cargo' => $cargo_i,
        'imageLink' => $imageurl_i,
        'descripcion' => $descripcion2_i,
        'instagramLink' => $linkInstagram_i,
        'whatsapp' => $whatsapp_i,
        'linkcategoria' => $linkcategoria_i,
        'shortcode' => $shortcode_i
    ];

    try {
        $wpdb->insert($tabla_instructor, $data2);
    } catch (Exception $e) {

        echo '<div class="alert alert-danger alert-dismissible me-4 mt-4">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <strong>ERROR</strong> ' . $e->getMessage() . '
        </div>';
    }

    echo '<div class="alert alert-success alert-dismissible me-4 mt-4">
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    <strong>¡Éxito!</strong> Se ha agregado el instructor
    </div>';
}

$query = "SELECT * FROM $tabla_shedule";
$list_shedule = $wpdb->get_results($query, ARRAY_A);

$query2 = "SELECT * FROM $tabla_instructor";
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
                $timestamp = $value['timestamp'];

                $fechahorainicio = new DateTime($fechahorainicio);
                $fechahorafin = new DateTime($fechahorafin);

                $duracion = $fechahorainicio->diff($fechahorafin);
            ?>

                <tr>
                    <td>
                        <?php if (isset($imageLink) && $imageLink != '') { ?>
                            <img src='<?php echo $imageLink; ?>' width='50px' height='50px'>
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
                            echo $duracion->d . " días ";
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

                    <td>
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

            <?php } ?>

        </tbody>
    </table>

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
                            <img id='image-preview-event' src='<?php echo plugin_dir_url(__FILE__) . "img/fondocolores.jpg"; ?>' height='100px' width='100%' class="mb-2">
                            <input id="upload-button" type="button" class="button btn btn-primary" value="Cambiar imagen" />
                            <input id="image-url" type="hidden" name="image-url" value="<?php echo plugin_dir_url(__FILE__) . 'img/fondocolores.jpg'; ?>" />
                        </div>

                        <div class="mb-3 mt-3">
                            <label for="name" class="form-label">Nombre:</label>
                            <input type="text" class="form-control" id="eventname" placeholder="Nombre del evento" name="eventname">
                        </div>
                        <div class="mb-3">
                            <label for="fechahorainicio" class="form-label">Fecha y hora de inicio:</label>
                            <input type="datetime-local" id="fechahorainicio" name="fechahorainicio" value="2022-07-28T12:30">
                        </div>
                        <div class="mb-3">
                            <label for="fechahorafin" class="form-label">Fecha y hora de finalización:</label>
                            <input type="datetime-local" id="fechahorafin" name="fechahorafin" value="2022-07-28T13:00">
                        </div>
                        <div class="mb-3">
                            <label for="instructor" class="form-label">Instructor:</label>
                            <select class="form-select" id="instructor" name="instructor[]">
                                <?php
                                foreach ($list_instructor as $key => $value) { ?>

                                    <option value="<?php echo $value['instructorid']; ?>">
                                        <?php echo $value['nombre'] ?></option>

                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion">Descripción:</label>
                            <textarea class="form-control" rows="5" id="descripcion" name="descripcion" max="300"></textarea>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="linkevent" class="form-label">Link:</label>
                            <input type="text" class="form-control" id="linkevent" placeholder="Link del evento" name="linkevent">
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
                            <input id="image-url2" type="hidden" name="image-url2" value='<?php echo plugin_dir_url(__FILE__) . "img/character.webp"; ?>' />
                        </div>

                        <div class="mb-3 mt-3">
                            <label for="nameinstructor" class="form-label">Nombre:</label>
                            <input type="text" class="form-control" id="nameinstructor" placeholder="Nombre del instructor" name="nameinstructor">
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="cargo" class="form-label">Cargo:</label>
                            <input type="text" class="form-control" id="cargo" placeholder="Cargo" name="cargo">
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="linkInstagram" class="form-label">Link Instagram:</label>
                            <input type="text" class="form-control" id="linkInstagram" placeholder="Link instagram" name="linkInstagram">
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="whatsapp" class="form-label">Whatsapp:</label>
                            <input type="tel" class="form-control" id="whatsapp" placeholder="Whatsapp" name="whatsapp">
                        </div>
                        <div class="mb-3">
                            <label for="descripcion2">Descripción:</label>
                            <textarea class="form-control" rows="5" id="descripcion2" name="descripcion2" max="300"></textarea>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="linkcategoria" class="form-label">Link categoria:</label>
                            <input type="text" class="form-control" id="linkcategoria" placeholder="Link categoria" name="linkcategoria">
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