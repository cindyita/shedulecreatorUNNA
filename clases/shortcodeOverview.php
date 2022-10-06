<?php

require_once ABSPATH . WPINC . '/load.php';
if(!defined('WPINC')){
    define('WPINC', 'wp-includes');
}

// require_once(home_url() . "/wp-load.php");
// require_once($_SERVER['DOCUMENT_ROOT'] . "/_PROGRAMAS/_UNNA/unna-wordpress/wp-load.php");
    date_default_timezone_set('America/Mexico_City');

    class shortcodeOverview{

        public function getEvents(){
            global $wpdb;
            $tabla_shedule = "{$wpdb->prefix}shedule_event";

            $query = "SELECT * FROM $tabla_shedule ORDER BY fechahorainicio ASC";
            $data = $wpdb->get_results($query,ARRAY_A);

            if(empty($data)){
                $data = array();
            }
            return $data;
        }

        public function getInstructors(){
            global $wpdb;
            $tabla_instructor = "{$wpdb->prefix}shedule_instructor";

            $query = "SELECT * FROM $tabla_instructor";
            $data = $wpdb->get_results($query, ARRAY_A);

            if (empty($data)) {
                $data = array();
            }
            return $data;
        }



        public function converterWeek($datestart){

            $week = $datestart->format('N');

            switch ($week) {
                case 1:
                    $week = "Lunes";
                    break;
                case 2:
                    $week = "Martes";
                    break;
                case 3:
                    $week = "Miércoles";
                    break;
                case 4:
                    $week = "Jueves";
                    break;
                case 5:
                    $week = "Viernes";
                    break;
                case 6:
                    $week = "Sábado";
                    break;
                case 7:
                    $week = "Domingo";
                    break;
                default:
                    $week = "Algún día";
                    break;
            }

            return $week;


        }

        public function converterMonth($datestart){

            $month = $datestart->format('m');
        
            switch ($month) {
                case 1:
                    $month = "Enero";
                    break;
                case 2:
                    $month = "Febrero";
                    break;
                case 3:
                    $month = "Marzo";
                    break;
                case 4:
                    $month = "Abril";
                    break;
                case 5:
                    $month = "Mayo";
                    break;
                case 6:
                    $month = "Junio";
                    break;
                case 7:
                    $month = "Julio";
                    break;
                case 8:
                    $month = "Agosto";
                    break;
                case 9:
                    $month = "Septiembre";
                    break;
                case 10:
                    $month = "Octubre";
                    break;
                case 11:
                    $month = "Noviembre";
                    break;
                case 12:
                    $month = "Diciembre";
                    break;
                default:
                    $month = "Algún mes";
                    break;

                    
            }
            
            return $month;
        }

        public function converterDuration($duracion){

            $duraciondate = "";

            if ($duracion->y == 1) {
                $duraciondate .= $duracion->y . " año ";
            } else if ($duracion->y > 1) {
                $duraciondate .= $duracion->y . " años ";
            }

            if ($duracion->m == 1) {
                $duraciondate .= $duracion->m . " mes ";
            } else if ($duracion->m > 1) {
                $duraciondate .= $duracion->m . " meses ";
            }

            if ($duracion->d == 1) {
                $duraciondate .= $duracion->d . " día ";
            } else if ($duracion->d > 1) {
                $duraciondate .= $duracion->d . " dias ";
            }

            if ($duracion->h == 1) {
                $duraciondate .= $duracion->h . " hora ";
            } else if ($duracion->h > 1) {
                $duraciondate .= $duracion->h . " horas ";
            }

            if ($duracion->i >= 1) {
                $duraciondate .= $duracion->i . " min ";
            }

            if ($duracion->s >= 1 && $duraciondate == "") {
                $duraciondate .= $duracion->s . " s";
            }

            return $duraciondate;

        }

            public function eventRegistration($idEvent)
            {

                global $wpdb;
                $userId = get_current_user_id();
                $tabla_register = "{$wpdb->prefix}shedule_registrations";
                $format = NULL;

                if (isset($idEvent)) {
                    $data = array(
                        'registerid' => NULL,
                        'userid' => $userId,
                        'eventid' => $idEvent
                    );
                }

                try {

                    $wpdb->insert($tabla_register, $data, $format);
                } catch (Exception $e) {

                    echo '<script language="javascript">alert("ERROR: ' . $e->getMessage() . '");</script>';
                }


                echo '<script language="javascript">alert("Te has registrado con éxito");</script>';
            }

            public function searchRegister($eventid)
            {

                global $wpdb;
                $userid = get_current_user_id();
                $tabla_register = "{$wpdb->prefix}shedule_registrations";

                $query = "SELECT * FROM $tabla_register WHERE userid = $userid";
                $res = $wpdb->get_results($query, ARRAY_A);

                $return = 0;

                foreach ($res as $value) {
                    if ($value['eventid'] == $eventid) {
                        $return = 1;
                    }
                }
                return $return;
            }

        public function eventFromOpen($e,$i){
            global $wpdb;
            $userId = get_current_user_id();
            $current_user = wp_get_current_user()->id;

            $actualClass = new shortcodeOverview;


            /*POST INSCRIPCION*/
            if (isset($_POST['inscribirse'])) {

                $idins = $_POST['inscripcionid'];
                $url = $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];

                if($actualClass->searchRegister($idins) != 1){

                    $userid = get_current_user_id();
                    $tabla_register = "{$wpdb->prefix}shedule_registrations";
                    $format = NULL;

                    if (isset($idins)) {
                        $data = array(
                            'registerid' => NULL,
                            'userid' => $userid,
                            'eventid' => $idins,
                            'timestamp' => NULL
                        );
                    }

                    try {
                        $wpdb->insert($tabla_register, $data, $format);
                        echo '<script language="javascript">alert("Te has registrado con éxito");</script>';
                        sleep(5);
                        header("Location: $url");
            
                    } catch (Exception $e) {

                        echo '<script language="javascript">alert("ERROR: ' . $e->getMessage() . '");</script>';
                    }

                }else{
                    echo '<script language="javascript">alert("Ya te has inscrito a este evento");</script>';
                }

            }
        /*-----------------------------*/

            $html = "";

            if(!$e){
            $html .= "
                <div class='wrap W-100 d-flex justify-content-center align-items-center p-4' style='background-color:#f7f6f5;'>
                    <a>Por el momento no hay eventos activos</a>
                </div>
            ";

            }else{

                $html .= "
                <script src='https://kit.fontawesome.com/e0df5df9e9.js' crossorigin='anonymous'></script>
                <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC' crossorigin='anonymous'>
                <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js' integrity='sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM' crossorigin='anonymous'></script>

                <div class='w-100'>
                <div class='wrap' style='display:flex;padding:0 10px;'>

                    <div class='swiper swipersheduleoverview' style='width:100%;'>
                        <div class='swiper-wrapper px-5'>
                        
                ";

                foreach ($e as $key => $value) {

                    $id = $value['eventoid'];
                    $nombre = $value['nombre'];
                    $linkevent = $value['linkevent'];
                    $instructorIdAssign = $value['instructorIdAssign'];

                    $datestart = $value['fechahorainicio'];
                    $datestart = new DateTime($datestart);
                    $dateend = $value['fechahorafin'];
                    $dateend = new DateTime($dateend);
                    $duracion = $datestart->diff($dateend);

                    $day = $datestart->format('d');
                    $hour = $datestart->format('g:i a');
                    $date = $datestart->format('d/m/Y');

                    $month = $actualClass->converterMonth($datestart);
                    $week = $actualClass->converterWeek($datestart);
                    $duraciondate = $actualClass->converterDuration($duracion);

                    $checkRegister = $actualClass->searchRegister($id);

                    foreach ($i as $key => $valuei) {

                        $idInstructor = $valuei['instructorid'];

                        if($idInstructor == $instructorIdAssign){

                            $nameInstructor = $valuei['nombre'];
                            $imageInstructor = $valuei['imageLink'];

                        }
                        
                    }

                    $today = new DateTime();
                    $todayFormat = $today->format('d/m/Y');
                

                    if($date == $todayFormat){
                        $week = 'Hoy';
                    }
                    

                    if($datestart >= $today){

                        $html .= "
                                        
                        <div class='swiper-slide d-flex justify-content-center' style='width:90%;'>

                            <div style='padding:20px;margin:5px;box-shadow:0 0 6px 1px rgba(0,0,0,0.2);background-color:#F1F0EA;width:260px;height:450px;border-radius:10px;'>
                                <a style='position:relative;'>
                                    <h1 style='font-size:30px;'>$week</h1>
                                    ";

                                if ($week != 'Hoy') {
                                    $html .= "<p style='display:flex;color:#8A7E71;font-size:11px;position:absolute;top:25px;'>$day de $month</p>";
                                }

                        $html .= "
                                </a>
                                <h1 style='color:#8A7E71;font-size:21pt;margin-top:30px;'>$hour</h1>
                                <p style='font-size:13pt;cursor:pointer;line-height:14pt;height:60px;padding-top:5px;' data-bs-toggle='modal' data-bs-target='#modal$id'>$nombre</p>
                                ";
                        if($nameInstructor){
                            $html .="
                                    <a style='cursor:pointer;' data-bs-toggle='modal' data-bs-target='#modalInstructor$instructorIdAssign'>
                                    <p><img src='$imageInstructor' style='width:50px;height:50px;border-radius:50%;margin-right:5px;'> $nameInstructor</p>
                                    </a>
                            ";
                        }
                        $html .= "
                                <hr>
                                <div style='width:20%;height:2px;background-color:#8A7E71;'></div>
                                <p style='color:#8A7E71;font-size:14pt;'>$duraciondate</p>
                                    
                                    ";
                            
                        if($current_user != 0){

                                        if ($checkRegister == 1) {
                                            $html .= "
                                                        <a href='$linkevent' style='font-style: italic;font-size:15pt;font-family:athelas'>
                                                           Entrar a la sesión
                                                        </a>
                                                ";
                                        } else {

                                            

                                            $html .= "  <form method='post' action=''>
                                                            <input type='hidden' id='inscripcionid' name='inscripcionid' value='$id'>

                                                            <button class='btn' style='display:block;border-radius:23px;background-color:black;color:#EFEDE8;padding 0;border:0;font-size:12pt;' id='inscribirse$id' name='inscribirse' type='submit' onclick='loading($id)'>inscribirme</button>

                                                            <span id='loading$id' style='display:none;'><div class='spinner-border spinner-border-sm'></div>
                                                                Inscribiendo...
                                                            </span>
                                                        </form>

                                                        <script>
                                                            function loading(id) {
                                                                document.getElementById('inscribirse'+id).style.display = 'none';
                                                                document.getElementById('loading'+id).style.display = 'block';
                                                            }
                                                        </script>
                                                ";
                                        }
                                }elseif($current_user == 0){
                                    $html .= "
                                                <a href='../login'>
                                                    <button class='btn' style='display:block;border-radius:23px;background-color:black;color:#EFEDE8;padding 0;border:0;font-size:12pt;'>inscribirme</button>
                                                </a>
                                            
                                        ";
                                }

                        $html .= "
                            </div><br>
                                </div> <!----Fin slider---->

                        "; 
                    }      
                
                }

            $html .= "
                            </div>
                                <div class='swiper-button-next'></div>
                                <div class='swiper-button-prev'></div>
                            </div>
                ";


            foreach ($e as $value2) {
                $idmodal = $value2['eventoid'];
                $imageLinkModal = $value2['imageLink'];
                $nombreModal = $value2['nombre'];
                $dateModal =  new DateTime($value2['fechahorainicio']);
                $hourModal = date("g:s a", strtotime($value2['fechahorainicio']));
                $descripcionModal = $value2['descripcion'];
                $linkCalendarModal = $value2['linkcalendar'];
                $idInstructorModal = $value2['instructorIdAssign'];

                $day = $dateModal->format('d');
                $month = $actualClass->converterMonth($dateModal);
                $week = $actualClass->converterWeek($dateModal);

                $checkRegisterModal = $actualClass->searchRegister($idmodal);


            $html .= "
                            <div class='modal' id='modal$idmodal'>
                                <div class='modal-dialog modal-dialog-centered modal-lg'>
                                    <div class='modal-content' style='border-radius:0;'>

                                    <!-- Modal body -->
                                    <div class='modal-body' style='position:relative;padding:0;'>
                                    
                                    <button type='button'style='position:absolute;top:8px;right:6px;' class='btn-close' data-bs-dismiss='modal'></button>

                                        <div style='width:100%;height:280px;background-image:url($imageLinkModal);background-size:cover;background-position:center center;'>
                                        </div>

                                        <div style='padding:50px;'>
                                            <div class='d-flex flex-column'>
                                                <h1 style='font-size:25pt'>$nombreModal</h1>
                                                <p style='line-height:12pt;'>$week $day de $month</p>
                                                <p style='line-height:12pt;'>$hourModal</p>
                                            </div>
                                    ";

                                    foreach ($i as $valuein) {

                                        $idInstructor = $valuein['instructorid'];

                                        if ($idInstructor == $idInstructorModal) {

                                            $nameInstructorModal = $valuein['nombre'];
                                            $imageInstructorModal = $valuein['imageLink'];

                                    $html .= "

                                            <div style='display:flex;align-items:center;'>
                                                <img src='$imageInstructorModal' style='border-radius:50%;width:45px;height:45px;margin-right:10px;margin-bottom:18px;'>
                                                <p>$nameInstructorModal</p>
                                            </div>

                                    ";
                                        }
                                    }
                                    $html .= "

                                            <p>$descripcionModal</p>
                                            <br>
                                            <div>

                                                <div class='d-flex gap-1 align-items-center'>

                                        ";
                                        if ($current_user != 0) {
                                            if ($checkRegisterModal == 1) {
                                                $html .= "
                                                            <a href='$linkevent'>
                                                                Clase reservada
                                                            </a>
                                                    ";
                                            } else {

                                            $html .= "  <form method='post' action=''>
                                                            <input type='hidden' id='inscripcionid' name='inscripcionid' value='$idmodal'>

                                                            <button class='btn' style='display:block;border-radius:23px;background-color:black;color:#EFEDE8;padding 0;border:0;font-size:12pt;' id='inscribirse$idmodal' name='inscribirse' type='submit' onclick='loading($idmodal)'>inscribirme</button>

                                                            <span id='loading$idmodal' style='display:none;'><div class='spinner-border spinner-border-sm'></div>
                                                                Inscribiendo...
                                                            </span>
                                                        </form>

                                                        <script>
                                                            function loading(id) {
                                                                document.getElementById('inscribirse'+id).style.display = 'none';
                                                                document.getElementById('loading'+id).style.display = 'block';
                                                            }
                                                        </script>
                                                ";
                                        }
                                    } elseif ($current_user == 0) {
                                        $html .= "
                                                            <a href='register'>
                                                                <button class='btn w-75' style='border-radius:23px;background-color:black;color:#EFEDE8;padding 0;border:0;font-size:12pt;'>Iniciar sesión</button>
                                                            </a>
                                                                
                                                            ";
                                    }

                                        $html .= "

                                                    <a href='$linkCalendarModal' class='ms-2'>
                                                        <button class='btn' style='border-radius:23px;background-color:black;color:#EFEDE8;padding 0;border:0;font-size:12pt;'>agregar a calendario</button>
                                                    </a>
                                                </div>
                                            </div>
                                            <br>
                                        </div>
                                        
                                    </div>


                                    </div>
                                </div>
                            </div>
            ";
            }

                foreach ($i as $valueins) {

                    $idInsModal = $valueins['instructorid'];

                    $nameInsModal = $valueins['nombre'];
                    $imageInsModal = $valueins['imageLink'];
                    $descInsModal = $valueins['descripcion'];
                    $cargoInsModal = $valueins['cargo'];
                    $whatsInsModal = $valueins['whatsapp'];
                    $instaInsModal = $valueins['instagramLink'];
                    $linkcategoriaInsModal = $valueins['linkcategoria'];


            $html .= "
                            <div class='modal' id='modalInstructor$idInsModal'>
                                <div class='modal-dialog modal-dialog-centered modal-lg'>
                                    <div class='modal-content' style='border-radius:0;'>

                                    <!-- Modal body -->
                                    <div class='modal-body' style='position:relative;padding:0;'>
                                    <button type='button'style='position:absolute;top:8px;right:6px;' class='btn-close' data-bs-dismiss='modal'></button>

                                        <div style='width:100%;height:400px;background-image:url($imageInsModal);background-size:cover;background-position:center center;'>
                                        </div>

                                        <div style='padding:50px;'>
                                            <div class='d-flex flex-column'>
                                                <h1 style='font-size:25pt'>$nameInsModal</h1>
                                                <p style='line-height:12pt;'>$cargoInsModal</p>
                                            </div>

                                            <p>$descInsModal</p>
                                            <br>
                                            <div>
                                                <a href='$linkcategoriaInsModal'>
                                                    <button class='btn' style='border-radius:23px;background-color:black;color:#EFEDE8;padding 0;border:0;font-size:12pt;'>Ver clases</button>
                                                </a>
                                                <a href='$instaInsModal'>
                                                    <img src='https://upload.wikimedia.org/wikipedia/commons/thumb/e/e7/Instagram_logo_2016.svg/768px-Instagram_logo_2016.svg.png' style='width:35px;height:35px;'>
                                                </a>
                                            </div>
                                            <br>
                                        </div>
                                        
                                    </div>

                                    </div>
                                </div>
                            </div>
            ";
            }
        }

            return $html;
        }

        public function eventFromClose(){
            $html = "

            </div>
            </div>

            <script>
                var swiper = new Swiper('.swipersheduleoverview', {
                    slidesPerView: 1,
                    spaceBetween: 3,
                    breakpoints: {
                        640: {
                            slidesPerView: 1,
                            spaceBetween: 0,
                        },
                        768: {
                            slidesPerView: 2,
                            spaceBetween: 2,
                        },
                        1024: {
                            slidesPerView: 3,
                            spaceBetween: 2,
                        },
                        1400: {
                            slidesPerView: 5,
                            spaceBetween: 2,
                        },
                        1920: {
                            slidesPerView: 5,
                            spaceBetween: 2,
                        },
                    },
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    }
                });    

            </script>

            ";
            return $html;
        }

        function showOverview(){

            $e = $this->getEvents();
            $i = $this->getInstructors();

            $html = $this->eventFromOpen($e,$i);
            $html .= $this->eventFromClose();

            return $html;

        }


    }
