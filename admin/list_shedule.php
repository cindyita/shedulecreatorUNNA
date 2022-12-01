<?php
global $wpdb;

$tabla_shedule = "{$wpdb->prefix}shedule_event";
$tabla_instructor = "{$wpdb->prefix}shedule_instructor";
$tabla_register = "{$wpdb->prefix}shedule_registrations";
$format = NULL;

?>

<script src="https://kit.fontawesome.com/e0df5df9e9.js" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<?php

global $actualIdEdit;
$actualIdEdit = 0;

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


    if ($fechahorainicio_g <= $fechahorafin_g) {

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
    } else {

        echo '<div id="error-alert" class="alert alert-danger alert-dismissible me-4 mt-4">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <strong>ERROR</strong> La fecha final no puede ser menor a la fecha de inicio
        </div>';
    }
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

if (isset($_POST['exportdata'])) {

    $registers = $wpdb->get_results(" SELECT * FROM $tabla_register", ARRAY_A);
    $events = $wpdb->get_results(" SELECT * FROM $tabla_shedule", ARRAY_A);
    $instructors = $wpdb->get_results(" SELECT * FROM $tabla_instructor", ARRAY_A);

    foreach ($registers as $key => $register) {


        $nombreevento = '';
        $fechaevento = '';
        $instructorid = '';
        $instructor = '';
        $eventid = $register['eventid'];

        foreach ($events as $event) {
            if ($eventid == $event['eventoid']) {
                $nombreevento = $event['nombre'];
                $fechaevento = $event['fechahorainicio'];
                $instructorid = $event['instructorIdAssign'];
            }
        }

        foreach ($instructors as $instructor) {
            if ($instructorid == $instructor['instructorid']) {
                $instructor = $instructor['nombre'];
            }
        }

        $registers[$key]['nombrevento'] = $nombreevento;
        $registers[$key]['fechaevento'] = $fechaevento;
        $registers[$key]['instructorid'] = $instructorid;
        $registers[$key]['instructor'] = $instructor;

        $user = new WP_User($register['userid']);
        $registers[$key]['nombreinscrito'] = $user->user_login;
        $registers[$key]['emailinscrito'] = $user->user_email;
    }

    if (isset($registers)) {

        /*--------------------------*/

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="SH_REGISTER_' . date('Y-m-d') . '.csv"');

        ob_end_clean();

        $fp = fopen('php://output', 'w');

        $header_row = array(
            'Id registro', 'Id evento', 'Nombre del evento', 'Fecha del evento', 'Id instructor', 'Nombre del instructor', 'Id usuario', 'Nombre del inscrito', 'Email del inscrito', 'Fecha de registro'
        );

        fputcsv($fp, $header_row);

        if (!empty($registers)) {
            foreach ($registers as $row) {
                $OutputRecord = array(
                    $row['registerid'],
                    $row['eventid'],
                    $row['nombrevento'],
                    $row['fechaevento'],
                    $row['instructorid'],
                    $row['instructor'],
                    $row['userid'],
                    $row['nombreinscrito'],
                    $row['emailinscrito'],
                    $row['timestamp']
                );
                fputcsv($fp, $OutputRecord);
            }
        }

        fclose($fp);
        exit;
    }

    echo '<div id="success-alert" class="alert alert-success alert-dismissible me-4 mt-4">
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    <strong>éxito!</strong> Se han exportado los datos</div>';
}

if (isset($_POST['sendEventEmail'])) {
        $destinatarioEvent = $_POST['destinatarioEvent'];
        $asunto = $_POST['asunto'];
        $content = $_POST['content'];

        $destinatario = "";

        $query3 = "SELECT * FROM $tabla_register";
        global $list_register;
        $list_register = $wpdb->get_results($query3, ARRAY_A);
        if (empty($list_register)) {
            $list_register = array();
        }

        foreach ($list_register as $registers) {

            if ($registers['eventid'] == $destinatarioEvent) {

                $user = new WP_User($registers['userid']);
                $useremail = $user->user_email;

                if($destinatario != ""){
                    $destinatario .= ','.$useremail;
                }else{
                    $destinatario .= $useremail;
                }
            }

        }

        $to = $destinatario;
        $headers = array('Content-Type: text/html; charset=UTF-8');
        $subject = $asunto;
        $message =  $content;

        try{
            wp_mail( $to, $subject, $message, $headers );
            
        } catch (Exception $e) {

            echo '<div id="error-alert" class="alert alert-danger alert-dismissible me-4 mt-4">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <strong>ERROR</strong> ' . $e->getMessage() . '
            </div>';
        }

        echo '<div id="success-alert" class="alert alert-success alert-dismissible me-4 mt-4">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <strong>éxito!</strong> Se ha enviado el correo
        </div>';
    }

$query = "SELECT * FROM $tabla_shedule";
global $list_shedule;
$list_shedule = $wpdb->get_results($query, ARRAY_A);

$query2 = "SELECT * FROM $tabla_instructor";
global $list_instructor;
$list_instructor = $wpdb->get_results($query2, ARRAY_A);

$query3 = "SELECT * FROM $tabla_register";
global $list_register;
$list_register = $wpdb->get_results($query3, ARRAY_A);

if (empty($list_shedule)) {
    $list_shedule = array();
}
if (empty($list_instructor)) {
    $list_instructor = array();
}
if (empty($list_register)) {
    $list_register = array();
}

?>
<div class="wrap">

    <h1><?php echo get_admin_page_title(); ?></h1>
    <hr>

    <br>

    <!-------LISTA DE EVENTOS ACTIVOS--------->
    <div class="d-flex justify-content-between">
        <div>
            <h1 class="wp-heading-inline">Lista de eventos</h1>
            <a type="button" data-bs-toggle="modal" data-bs-target="#addEvent" class="page-title-action">Añadir nuevo evento</a>
        </div>
        <div class="d-flex align-items-end">
            <div>
                <a name="editevent" data-bs-toggle="modal" data-bs-target="#editEvent" class='page-title-action' onclick="changeSelectedEventEdit();">Editar un evento</a>
            </div>
            <form method="post" action="" enctype="multipart/form-data">
                <button id="exportdata" name="exportdata" type="submit" class="page-title-action">
                    Exportar inscritos
                    <i class="fa-solid fa-file-export"></i>
                </button>
            </form>
        </div>
    </div>


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

                $nameinstructor = '';
                foreach ($list_instructor as $values) {
                    if ($values['instructorid'] == $instructorIdAssign) {
                        $nameinstructor = $values['nombre'];
                    }
                }


                $count = 0;
                foreach ($list_register as $registers) {
                    if ($registers['eventid'] == $eventoid) {
                        $count = $count + 1;
                    }
                }

                $duracion = $fechahorainicio->diff($fechahorafin);

                if ($fechahorafin >= $today) {
            ?>

                    <tr>
                        <td>
                            <?php if (isset($imageLink) && $imageLink != '') { ?>
                                <img src='<?php echo $imageLink; ?>' width='80px' height='50px'>
                            <?php } ?>
                        </td>
                        <td><?php echo $nombre; ?></td>
                        <td><?php echo $fechahorainicio->format('d/m/Y h:i'); ?></td>
                        <td>
                            <?php

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

                        <td>
                            <?php echo $eventoid; ?>
                        </td>

                        <td>
                            <?php echo $nameinstructor; ?>
                        </td>

                        <td>
                            <a data-bs-toggle="modal" data-bs-target="#registersEvent<?php echo $eventoid; ?>"><?php echo $count; ?></a>
                        </td>

                        <td class="d-flex">
                            <a data-bs-toggle="modal" data-bs-target="#viewEvent<?php echo $eventoid; ?>" class='page-title-action'>Ver</a>
                            <!---
                            <a name="sendeditevent" data-bs-toggle="modal" data-bs-target="#editEvent" class='page-title-action'>Editar</a>-->
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
                                    ¿Segur@ que quieres eliminar este evento?<br><br><br>
                                    <a id="deleteshedule" data-idshedule='<?php echo $eventoid; ?>' class="btn btn-danger" class='page-title-action'>ELIMINAR</a><br>
                                    <br> Puede tardar un rato.
                                </div>

                            </div>
                        </div>
                    </div>
                    <!----------->
                    <!---MODAL VIEW EVENT--->
                    <div class="modal fade" id="viewEvent<?php echo $eventoid; ?>">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h4 class="modal-title"><?php echo $nombre; ?></h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">

                                    <div class="w-100 d-flex justify-content-start">
                                        <img src='<?php echo $imageLink; ?>' height='270px' width='67%' class="mb-2">
                                    </div>

                                    <label class="my-2">
                                        <strong>Inscritos: </strong><?php echo $count; ?>
                                        <button data-bs-toggle="modal" data-bs-target="#registersEvent<?php echo $eventoid; ?>" class='page-title-action mx-1'>Ver inscritos </button>
                                    </label>
                                    <br>

                                    <label class="my-2">
                                        <strong>Evento id: </strong>
                                        <?php echo $eventoid; ?>
                                    </label>
                                    <br>
                                    <label class="my-2">
                                        <strong>Descripción: </strong><br>
                                        <?php echo $descripcion; ?>
                                    </label>
                                    <br>
                                    <label class="my-2">
                                        <strong>Fecha y hora de inicio: </strong>
                                        <?php echo $fechahorainicio->format('d/m/Y h:i');; ?>
                                    </label>
                                    <br>
                                    <label class="my-2">
                                        <strong>Fecha y hora de finalización: </strong>
                                        <?php echo $fechahorafin->format('d/m/Y h:i');; ?>
                                    </label>
                                    <br>
                                    <label class="my-2">
                                        <strong>Duración: </strong>
                                        <?php

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
                                    </label>
                                    <br>
                                    <label class="my-2">
                                        <strong>Instructor: </strong>
                                        <?php echo $nameinstructor; ?>
                                    </label>
                                    <br>
                                    <label class="my-2">
                                        <strong>Link event: </strong>
                                        <?php echo $linkevent; ?>
                                    </label>
                                    <br>
                                    <label class="my-2">
                                        <strong>Link calendario: </strong>
                                        <?php echo $linkcalendar; ?>
                                    </label>
                                    <br>
                                    <label class="my-2">
                                        <strong>Shortcode: </strong>
                                        <?php echo $shortcode; ?>
                                    </label>
                                    <br>
                                    <label class="my-2">
                                        <strong>Fecha de creación: </strong>
                                        <?php echo $timestamp; ?>
                                    </label>

                                </div>

                            </div>
                        </div>
                    </div>
                    <!-------------->
                    <!---MODAL VIEW REGISTRATIONS--->
                    <div class="modal fade" id="registersEvent<?php echo $eventoid; ?>">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h4 class="modal-title">Registros para: <br><?php echo $nombre; ?> [ID: <?php echo $eventoid; ?>]</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <label class="mb-3">Total de registros: <?php echo $count; ?></label>
                                    <?php
                                    if (!$count <= 0) {
                                    ?>
                                        <div class="d-flex flex-column">
                                            <div class="row text-bold" style="border-bottom:1px solid lightgrey;border-top:1px solid lightgrey;">
                                                <div class="col-sm-2 p-3"><strong>Id reg</strong></div>
                                                <div class="col-sm-2 p-3"><strong>Id usuario</strong></div>
                                                <div class="col-sm-2 p-3"><strong>Usuario</strong></div>
                                                <div class="col-sm-3 p-3"><strong>Email</strong></div>
                                                <div class="col-sm-3 p-3"><strong>Fecha registro</strong></div>
                                            </div>

                                            <?php

                                            foreach ($list_register as $registers) {

                                                if ($registers['eventid'] == $eventoid) {
                                                    $user = new WP_User($registers['userid']);
                                                    /*  $user_phone = get_user_meta($registers['userid'], 'dbem_phone', true); */

                                            ?>
                                                    <div class="row" style="border-bottom:1px solid lightgrey;">
                                                        <div class="col-sm-2 p-3"><?php echo $registers['registerid']; ?></div>
                                                        <div class="col-sm-2 p-3"><?php echo $registers['userid']; ?></div>
                                                        <div class="col-sm-2 p-3"><?php echo $user->user_nicename; ?></div>
                                                        <div class="col-sm-3 p-3"><?php echo $user->user_email; ?></div>
                                                        <div class="col-sm-3 p-3"><?php echo $registers['timestamp']; ?></div>
                                                    </div>
                                            <?php
                                                }
                                            }
                                            ?>

                                        </div>
                                    <?php
                                    } /* fin IF */
                                    ?>

                                </div>

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

                $count = 0;

                foreach ($list_register as $registers) {
                    if ($registers['eventid'] == $eventoid) {
                        $count = $count + 1;
                    }
                }

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

                        <td>
                            <a data-bs-toggle="modal" data-bs-target="#registersEvent<?php echo $eventoid; ?>"><?php echo $count; ?></a>
                        </td>

                        <td>
                            <a data-bs-toggle="modal" data-bs-target="#viewEvent<?php echo $eventoid; ?>" class='page-title-action'>Ver</a>
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
                    <!---MODAL VIEW EVENT--->
                    <div class="modal fade" id="viewEvent<?php echo $eventoid; ?>">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h4 class="modal-title"><?php echo $nombre; ?></h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">

                                    <div class="w-100 d-flex justify-content-start">
                                        <img src='<?php echo $imageLink; ?>' height='270px' width='67%' class="mb-2">
                                    </div>

                                    <label class="my-2">
                                        <strong>Inscritos: </strong><?php echo $count; ?>
                                        <button data-bs-toggle="modal" data-bs-target="#registersEvent<?php echo $eventoid; ?>" class='page-title-action mx-1'>Ver inscritos </button>
                                    </label>
                                    <br>

                                    <label class="my-2">
                                        <strong>Evento id: </strong>
                                        <?php echo $eventoid; ?>
                                    </label>
                                    <br>
                                    <label class="my-2">
                                        <strong>Descripción: </strong><br>
                                        <?php echo $descripcion; ?>
                                    </label>
                                    <br>
                                    <label class="my-2">
                                        <strong>Fecha y hora de inicio: </strong>
                                        <?php echo $fechahorainicio->format('d/m/Y h:i');; ?>
                                    </label>
                                    <br>
                                    <label class="my-2">
                                        <strong>Fecha y hora de finalización: </strong>
                                        <?php echo $fechahorafin->format('d/m/Y h:i');; ?>
                                    </label>
                                    <br>
                                    <label class="my-2">
                                        <strong>Duración: </strong>
                                        <?php

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
                                    </label>
                                    <br>
                                    <label class="my-2">
                                        <strong>Instructor: </strong>
                                        <?php echo $nameinstructor; ?>
                                    </label>
                                    <br>
                                    <label class="my-2">
                                        <strong>Link event: </strong>
                                        <?php echo $linkevent; ?>
                                    </label>
                                    <br>
                                    <label class="my-2">
                                        <strong>Link calendario: </strong>
                                        <?php echo $linkcalendar; ?>
                                    </label>
                                    <br>
                                    <label class="my-2">
                                        <strong>Shortcode: </strong>
                                        <?php echo $shortcode; ?>
                                    </label>
                                    <br>
                                    <label class="my-2">
                                        <strong>Fecha de creación: </strong>
                                        <?php echo $timestamp; ?>
                                    </label>

                                </div>

                            </div>
                        </div>
                    </div>
                    <!-------------->
                    <!---MODAL VIEW REGISTRATIONS--->
                    <div class="modal fade" id="registersEvent<?php echo $eventoid; ?>">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h4 class="modal-title">Registros para: <br><?php echo $nombre; ?> [ID: <?php echo $eventoid; ?>]</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <label class="mb-3">Total de registros: <?php echo $count; ?></label>
                                    <?php
                                    if (!$count <= 0) {
                                    ?>
                                        <div class="d-flex flex-column">
                                            <div class="row text-bold" style="border-bottom:1px solid lightgrey;border-top:1px solid lightgrey;">
                                                <div class="col-sm-2 p-3"><strong>Id reg</strong></div>
                                                <div class="col-sm-2 p-3"><strong>Id usuario</strong></div>
                                                <div class="col-sm-2 p-3"><strong>Usuario</strong></div>
                                                <div class="col-sm-3 p-3"><strong>Email</strong></div>
                                                <div class="col-sm-3 p-3"><strong>Fecha registro</strong></div>
                                            </div>

                                            <?php

                                            foreach ($list_register as $registers) {

                                                if ($registers['eventid'] == $eventoid) {
                                                    $user = new WP_User($registers['userid']);
                                                    /*  $user_phone = get_user_meta($registers['userid'], 'dbem_phone', true); */

                                            ?>
                                                    <div class="row" style="border-bottom:1px solid lightgrey;">
                                                        <div class="col-sm-2 p-3"><?php echo $registers['registerid']; ?></div>
                                                        <div class="col-sm-2 p-3"><?php echo $registers['userid']; ?></div>
                                                        <div class="col-sm-2 p-3"><?php echo $user->user_nicename; ?></div>
                                                        <div class="col-sm-3 p-3"><?php echo $user->user_email; ?></div>
                                                        <div class="col-sm-3 p-3"><?php echo $registers['timestamp']; ?></div>
                                                    </div>
                                            <?php
                                                }
                                            }
                                            ?>

                                        </div>
                                    <?php
                                    } /* fin IF */
                                    ?>

                                </div>

                            </div>
                        </div>
                    </div>
                    <!-------------->


            <?php }
            } ?>


        </tbody>
    </table>
    <!-------------INSTRUCTORES----------------->

    <br><br>
    <hr><br>

    <div class="d-flex justify-content-between">
        <div>
            <h1 class="wp-heading-inline">Instructores</h1>
            <a type="button" data-bs-toggle="modal" data-bs-target="#addInstructor" class="page-title-action">Añadir nuevo insctructor</a>
        </div>
        <div class="d-flex align-items-end">
            <a data-bs-toggle="modal" data-bs-target="#editinstructormodal<?php echo $instructorid; ?>" class='page-title-action' onclick="changeSelectedInstructorEdit()">Editar un instructor</a>
        </div>
    </div>

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
                        <a data-bs-toggle="modal" data-bs-target="#viewInstructor<?php echo $instructorid; ?>" class='page-title-action'>Ver</a>
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
                                ¿Segur@ que quieres eliminar este instructor?<br>
                                Si borras un instructor que está ligado a un evento activo, podría generar errores.
                                <a id="deleteinstructor" data-idinstructor='<?php echo $instructorid; ?>' class="btn btn-danger" class='page-title-action'>ELIMINAR</a>
                                <br> Puede tardar un rato.
                            </div>

                        </div>
                    </div>
                </div>
                <!----------->
                <!---MODAL VIEW INSTRUCTOR--->
                <div class="modal fade" id="viewInstructor<?php echo $instructorid; ?>">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h4 class="modal-title"><?php echo $nombre; ?></h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">

                                <div class="w-100 d-flex justify-content-start">
                                    <img src='<?php echo $imageLink; ?>' height='270px' width='270px' class="mb-2">
                                </div>

                                <label class="my-2">
                                    <strong>Instructor id: </strong>
                                    <?php echo $instructorid; ?>
                                </label>
                                <br>
                                <label class="my-2">
                                    <strong>Cargo: </strong>
                                    <?php echo $cargo; ?>
                                </label>
                                <br>
                                <label class="my-2">
                                    <strong>Descripción: </strong><br>
                                    <?php echo $descripcion; ?>
                                </label>
                                <br>
                                <label class="my-2">
                                    <strong>Instagram link: </strong>
                                    <a href="<?php echo $instagramLink; ?>">
                                        <?php echo $instagramLink; ?></a>
                                </label>
                                <br>
                                <label class="my-2">
                                    <strong>Link categoría: </strong>
                                    <a href="<?php echo $linkcategoria; ?>">
                                        <?php echo $linkcategoria; ?>
                                    </a>
                                </label>
                                <br>
                                <label class="my-2">
                                    <strong>Whatsapp: </strong>
                                    <?php echo $whatsapp; ?>
                                </label>
                                <br>
                                <label class="my-2">
                                    <strong>Shortcode: </strong>
                                    <?php echo $shortcode; ?>
                                </label>
                                <br>
                                <label class="my-2">
                                    <strong>Fecha de creación: </strong>
                                    <?php echo $timestamp; ?>
                                </label>

                            </div>

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
                            <input type="text" class="form-control" id="eventname" placeholder="Nombre del evento" name="eventname" maxlength='150' required>
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
                            <textarea class="form-control" rows="5" id="descripcion" name="descripcion" maxlength="800"></textarea>
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

    <!---MODAL EDIT EVENT--->

    <div class="modal fade" id="editEvent">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Editar evento</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="p-3">
                    <label>Escoge que evento quieres editar:</label>
                    <select class="form-select" name="chooseEventEdit" id="chooseEventEdit" onChange="changeSelectedEventEdit();">
                        <?php
                        foreach ($list_shedule as $key => $option) {
                        ?>
                            <option value="<?php echo $option['eventoid']; ?>"><?php echo $option['eventoid']; ?> -
                                <?php echo $option['nombre']; ?></option>
                        <?php } ?>

                    </select>
                </div>
                <hr>
                <script>
                    function changeSelectedEventEdit() {

                        Array.from(document.querySelector("#chooseEventEdit").options).forEach(function(option_element) {
                            let option_text = option_element.text;
                            let option_value = option_element.value;
                            let is_option_selected = option_element.selected;
                            if (!is_option_selected) {
                                document.getElementById("formedit" + option_value).style.display = "none";
                            } else {
                                document.getElementById("formedit" + option_value).style.display = "block";
                            }
                        });


                    }
                    /*upload image EDIT EVENT*/

                    jQuery(document).ready(function($) {

                        Array.from(document.querySelector("#chooseEventEdit").options).forEach(function(option_element) {
                            let option_value = option_element.value;
                            let mediaUploader;

                            $('#uploadButtonEdit' + option_value).click(function(e) {
                                e.preventDefault();

                                if (mediaUploader) {
                                    mediaUploader.open();
                                    return;
                                }

                                mediaUploader = wp.media.frames.file_frame = wp.media({
                                    title: 'Escoger imagen',
                                    button: {
                                        text: 'Escoger imagen'
                                    },
                                    multiple: false
                                });

                                mediaUploader.on('select', function() {
                                    attachment = mediaUploader.state().get('selection').first().toJSON();
                                    $('#imageUrlEdit' + option_value).val(attachment.url);
                                    document.getElementById("image-preview-event-edit" + option_value).src = attachment.url;
                                });

                                mediaUploader.open();
                            });

                        });

                    });
                </script>

                <?php
                foreach ($list_shedule as $key => $es_value) {

                    $es_eventoid = $es_value['eventoid'];
                    $es_nombre = $es_value['nombre'];
                    $es_imageLink = $es_value['imageLink'];
                    $es_fechahorainicio = $es_value['fechahorainicio'];
                    $es_fechahorafin = $es_value['fechahorafin'];
                    $es_instructorIdAssign = $es_value['instructorIdAssign'];
                    $es_descripcion = $es_value['descripcion'];
                    $es_shortcode = $es_value['shortcode'];
                    $es_linkevent = $es_value['linkevent'];
                    $es_linkcalendar = $es_value['linkcalendar'];
                    $es_timestamp = $es_value['timestamp'];

                    $es_fechahorainicio = new DateTime($es_fechahorainicio);
                    $es_fechahorafin = new DateTime($es_fechahorafin);

                    $es_nameinstructor = '';
                    foreach ($list_instructor as $es_values) {
                        if ($es_values['instructorid'] == $es_instructorIdAssign) {
                            $es_nameinstructor = $es_values['nombre'];
                        }
                    }

                    $es_duracion = $es_fechahorainicio->diff($es_fechahorafin);
                ?>

                    <form method="post" id="formedit<?php echo $es_eventoid; ?>">

                        <div class="modal-body">

                            <div class="w-100">
                                <img id='image-preview-event-edit<?php echo $es_eventoid; ?>' src='<?php echo $es_imageLink; ?>' height='250px' width='80%' class="mb-2"><br>
                                <input id="uploadButtonEdit<?php echo $es_eventoid; ?>" type="button" class="button btn btn-primary" value="Cambiar imagen" />
                                <input id="imageUrlEdit<?php echo $es_eventoid; ?>" type="hidden" name="image-url3" value="<?php echo $es_imageLink; ?>" maxlength="250" />
                            </div>

                            <input id="eventid-edit" type="hidden" name="eventid-edit" value="<?php echo $es_eventoid; ?>" />

                            <div class="mb-3 mt-3">
                                <label for="eventname-edit" class="form-label">Nombre del evento:</label>
                                <input type="text" class="form-control" id="eventname-edit" value="<?php echo $es_nombre; ?>" name="eventname-edit" maxlength='150' required>
                            </div>
                            <div class="mb-3">
                                <label for="fechahorainicio-edit" class="form-label">Fecha y hora de inicio:</label>
                                <input type="datetime-local" id="fechahorainicio-edit" name="fechahorainicio-edit" value="<?php echo $es_fechahorainicio->format('Y-m-d H:i'); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="fechahorafin-edit" class="form-label">Fecha y hora de finalización:</label>
                                <input type="datetime-local" id="fechahorafin-edit" name="fechahorafin-edit" value="<?php echo $es_fechahorafin->format('Y-m-d H:i'); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="instructor-edit" class="form-label">Instructor:</label>
                                <select class="form-select" id="instructor-edit" name="instructor-edit[]" required>
                                    <?php
                                    foreach ($list_instructor as $key => $es_value) {
                                        if ($es_instructorIdAssign == $es_value['instructorid']) {
                                    ?>

                                            <option value="<?php echo $es_value['instructorid']; ?>" selected>
                                                <?php echo $es_value['nombre']; ?></option>

                                        <?php } else { ?>

                                            <option value="<?php echo $es_value['instructorid']; ?>">
                                                <?php echo $es_value['nombre']; ?></option>

                                    <?php }
                                    } ?>

                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="descripcion-edit">Descripción:</label>
                                <textarea class="form-control" rows="5" id="descripcion-edit" name="descripcion-edit" maxlength="800"><?php echo $es_descripcion; ?></textarea>
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="linkevent-edit" class="form-label">Link del evento:</label>
                                <input type="text" class="form-control" id="linkevent-edit" value="<?php echo $es_linkevent; ?>" name="linkevent-edit" maxlength='250'>
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="linkcalendar-edit" class="form-label">Link del calendario:</label>
                                <input type="text" class="form-control" id="linkcalendar-edit" value="<?php echo $es_linkcalendar; ?>" name="linkcalendar-edit" maxlength='250'>
                            </div>
                            <br>
                            <div class="w-100 text-center">
                                <button id="editshedule" name="editshedule" type="submit" class="btn btn-primary">Editar</button>
                            </div>
                            <br>

                        </div>

                    </form>
                <?php } ?>

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
                            <textarea class="form-control" rows="5" id="descripcion2" name="descripcion2" maxlength="800"></textarea>
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
    <!---MODAL EDIT INSTRUCTOR--->
    <div class="modal fade" id="editinstructormodal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Editar instructor</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>


                <div class="p-3">
                    <label>Escoge que instructor quieres editar:</label>
                    <select class="form-select" name="chooseInstructorEdit" id="chooseInstructorEdit" onChange="changeSelectedInstructorEdit();">
                        <?php
                        foreach ($list_instructor as $key => $option) {
                        ?>
                            <option value="<?php echo $option['instructorid']; ?>"><?php echo $option['instructorid']; ?> -
                                <?php echo $option['nombre']; ?></option>
                        <?php } ?>

                    </select>
                </div>
                <hr>
                <script>
                    function changeSelectedInstructorEdit() {

                        Array.from(document.querySelector("#chooseInstructorEdit").options).forEach(function(option_element) {
                            let option_text_i = option_element.text;
                            let option_value_i = option_element.value;
                            let is_option_selected_i = option_element.selected;
                            if (!is_option_selected_i) {
                                document.getElementById("formediti" + option_value_i).style.display = "none";
                            } else {
                                document.getElementById("formediti" + option_value_i).style.display = "block";
                            }
                        });


                    }
                    /*upload image EDIT EVENT*/

                    jQuery(document).ready(function($) {

                        Array.from(document.querySelector("#chooseInstructorEdit").options).forEach(function(option_element) {
                            let option_value_i = option_element.value;
                            let mediaUploader;

                            $('#uploadButtonEditi' + option_value_i).click(function(e) {
                                e.preventDefault();

                                if (mediaUploader) {
                                    mediaUploader.open();
                                    return;
                                }

                                mediaUploader = wp.media.frames.file_frame = wp.media({
                                    title: 'Escoger imagen',
                                    button: {
                                        text: 'Escoger imagen'
                                    },
                                    multiple: false
                                });

                                mediaUploader.on('select', function() {
                                    attachment = mediaUploader.state().get('selection').first().toJSON();
                                    $('#imageUrlEditi' + option_value_i).val(attachment.url);
                                    document.getElementById("image-preview-instructor-edit" + option_value_i).src = attachment.url;
                                });

                                mediaUploader.open();
                            });

                        });

                    });
                </script>
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

                    <form method="post" id="formediti<?php echo $instructorid; ?>">

                        <div class="modal-body">
                            <div class="w-50">
                                <img id='image-preview-instructor-edit<?php echo $instructorid; ?>' src='<?php echo $imageLink; ?>' height='200px' width='200px'>
                                <input id="uploadButtonEditi<?php echo $instructorid; ?>" type="button" class="button btn btn-primary mt-2" value="Cambiar imagen" />
                                <input id="imageUrlEditi<?php echo $instructorid; ?>" type="hidden" name="image-url4" value='<?php echo $imageLink; ?>' />
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
                                <textarea class="form-control" rows="5" id="descripcion3" name="descripcion3" maxlength="800"><?php echo $descripcion; ?></textarea>
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
                <?php } ?>

            </div>
        </div>
    </div>
    <!-------------->

    <br><br><br>

    <h1 class="wp-heading-inline">Shortcodes</h1>
    <table class="wp-list-table widefat fixed striped pages">
        <thead>
            <th>
                Descripción
            </th>
            <th>
                Shortcode
            </th>

        </thead>
        <tbody id="the-list">
            <tr>
                <td>
                    Evento individual
                </td>
                <td>
                    [SH_EVENT id='{ID FROM EVENT}'] Example: [SH_EVENT id='5']
                </td>
            </tr>
            <tr>
                <td>
                    Instructor individual
                </td>
                <td>
                    [SH_INSTRUCTOR id='{ID FROM INSTRUCTOR}'] Example: [SH_INSTRUCTOR id='2']
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
                    Overview de todos los eventos
                </td>
                <td>
                    [SH_ALL_EVENTS]
                </td>
            </tr>
            <tr>
                <td>
                    Overview de todos los eventos versión móviles
                </td>
                <td>
                    [SH_ALL_EVENTS_MOBILE]
                </td>
            </tr>
            <tr>
                <td>
                    Eventos al que está inscrito el usuario
                </td>
                <td>
                    [SH_MY_EVENTS]
                </td>
            </tr>
            <tr>
                <td>
                    Eventos e inscritos de un instructor
                </td>
                <td>
                    [SH_INSTRUCTOR_EVENTS id='{ID FROM INSTRUCTOR}'] Example: [SH_INSTRUCTOR_EVENTS id='2']
                </td>
            </tr>
        </tbody>
    </table>
    <br><br><br>
    <!-------------EMAILS------------->
    <?php 


    ?>

    <h1 class="wp-heading-inline">Enviador de emails</h1><hr>
    <div class="emailsSender row">
        <div class="col-12 col-lg-6">
            <form method="post"><!---
                <div class="my-3">
                    <label for="destinatarioSelect" class="form-label">Tipo de destinatario:</label>
                    <select class="form-select" id="destinatarioSelect" name="destinatarioSelect">
                        <option>Todos los inscritos de un evento</option>
                        
                        <option>Todos los inscritos de los eventos de un instructor</option>
                        <option>Todos los inscritos de todos los eventos</option>
                    </select>
                </div>-->
                <div class="my-3">
                    <label for="destinatarioEvent" class="form-label">Enviar a los inscritos del evento:</label>
                    <select class="form-select" id="destinatarioEvent" name="destinatarioEvent">
                    <?php 
                    
                    foreach ($list_shedule as $key => $value) {

                        $eventoid = $value['eventoid'];
                        $nombre = $value['nombre'];
                        $fechahorafin = $value['fechahorafin'];
                        $fechahorafin = new DateTime($fechahorafin);

                        if ($fechahorafin >= $today){
                    ?>
                        <option value="<?php echo $eventoid; ?>"><?php echo $nombre; ?></option>
                        <?php }else{ ?>
                        <option value="<?php echo $eventoid; ?>"><?php echo $nombre; ?> [Caducado]</option>

                        <?php } } ?>
                    </select>
                </div>
                <!---
                <div class="mb-3 mt-3">
                    <label for="remitenteName" class="form-label">Remitente nombre:</label>
                    <input type="text" class="form-control" id="remitenteName" placeholder="Ingresa el nombre del remitente" name="remitenteName">
                </div>
                <div class="mb-3 mt-3">
                    <label for="remitenteEmail" class="form-label">Remitente email:</label>
                    <input type="email" class="form-control" id="remitenteEmail" placeholder="Ingresa el correo del remitente" name="remitenteEmail">
                </div>
                <div class="mb-3 mt-3">
                    <label for="copia" class="form-label">CC email:</label>
                    <input type="email" class="form-control" id="copia" placeholder="Ingresa el correo para enviar copia" name="copia">
                </div>
                --->
                <div class="mb-3 mt-3">
                    <label for="asunto" class="form-label">Asunto:</label>
                    <input type="text" class="form-control" id="asunto" placeholder="Ingresa el asunto" name="asunto">
                </div>
                <div class="mb-3 mt-3">
                    <label for="content">Contenido del mensaje: (HTML)</label>
                    <textarea class="form-control" rows="5" id="content" name="content"></textarea>
                </div>
                <div class="mb-3 mt-3">
                    <button class="btn btn-primary" id="sendEventEmail" name="sendEventEmail">Enviar</button>
                </div>
            </form>
        </div>
    </div>
    <br><hr>
    

    <!--------------------------------->

    <br><br><br>
    <div class="text-muted">
        <h1 class="wp-heading-inline">Créditos</h1>
        <p>Plugin creado por <a href="https://larestudiocreativo.com" style="text-decoration:none;">Lar Estudio Creativo</a> para <a href="https://somosunna.com" style="text-decoration:none;">somos UNNA</a></p>
    </div>
</div>
<?php
