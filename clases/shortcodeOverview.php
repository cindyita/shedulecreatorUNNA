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
                    $week = "lunes";
                    break;
                case 2:
                    $week = "martes";
                    break;
                case 3:
                    $week = "miércoles";
                    break;
                case 4:
                    $week = "jueves";
                    break;
                case 5:
                    $week = "viernes";
                    break;
                case 6:
                    $week = "sábado";
                    break;
                case 7:
                    $week = "domingo";
                    break;
                default:
                    $week = "algún día";
                    break;
            }

            return $week;


        }

        public function converterMonth($datestart){

            $month = $datestart->format('m');
        
            switch ($month) {
                case 1:
                    $month = "enero";
                    break;
                case 2:
                    $month = "febrero";
                    break;
                case 3:
                    $month = "marzo";
                    break;
                case 4:
                    $month = "abril";
                    break;
                case 5:
                    $month = "mayo";
                    break;
                case 6:
                    $month = "junio";
                    break;
                case 7:
                    $month = "julio";
                    break;
                case 8:
                    $month = "agosto";
                    break;
                case 9:
                    $month = "septiembre";
                    break;
                case 10:
                    $month = "octubre";
                    break;
                case 11:
                    $month = "noviembre";
                    break;
                case 12:
                    $month = "diciembre";
                    break;
                default:
                    $month = "algún mes";
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


                echo '<script language="javascript">alert("te has registrado con éxito");</script>';
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
            $url = $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
            $redirect = 0;

            $actualClass = new shortcodeOverview;

            if(isset($_GET['msg']) && $_GET['msg'] == 'success'){
                echo "
                <div class='modal' id='registroexitoso'>
                    <div class='modal-dialog'>
                        <div class='modal-content'>

                        <div class='modal-header'>
                            <h4 class='ms-5 ps-4 pt-2'>se ha reservado tu clase</h4>
                            <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                        </div>

                        <div class='modal-body text-center'>
                            Puedes ver tus clases reservadas y el link de acceso en la página de <a href='https://somosunna.com/mi-perfil-unna-studio/' style='font-weight:bold;color:#8d7e6f;'>mi perfil</a>
                        </div>

                        </div>
                    </div>
                </div>
                <script language='javascript'>
                    var modalShowSuccess = new bootstrap.Modal(document.getElementById('registroexitoso'), {});
                    document.onreadystatechange = function () {
                        modalShowSuccess.show();
                    };
                </script>";
            }


            /*POST INSCRIPCION*/
            if (isset($_POST['inscribirse'])) {

                $idins = $_POST['inscripcionid'];

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
                        
                        echo '<script language="javascript">location.href ="'.$url.'?msg=success";</script>';  

            
                    } catch (Exception $e) {

                        echo '<script language="javascript">alert("ERROR: ' . $e->getMessage() . '");</script>';
                    }

                }else{
                    echo '<script language="javascript">alert("Ya te has inscrito a este evento");</script>';
                }

                /*header("Location: $url");*/

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

                <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css'/>

                <div class='w-100'>
                <div class='wrap px-0 px-lg-2'>

                    <div class='swiper swipersheduleoverview' style='width:100%;'>
                        <div class='swiper-wrapper px-2 px-lg-5'>
                        
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
                    

                    if($dateend >= $today){

                        $html .= "
                                        
                        <div class='swiper-slide d-flex justify-content-center' style='width:90%;'>

                            <div style='padding:20px;margin:5px;box-shadow:0 0 6px 1px rgba(0,0,0,0.2);background-color:#F1F0EA;width:260px;height:450px;border-radius:10px;'>
                                <a sytle='line-height:19px;'>
                                    <h1 style='font-size:30px;line-height:19px;'>$week</h1>
                                    ";

                                if ($week != 'hoy') {
                                    $html .= "<p style='display:flex;color:#8A7E71;font-size:11px;line-height:0;'>$day de $month</p>";
                                }

                        $html .= "
                                </a>
                                <h1 style='color:#8A7E71;font-size:21pt;margin-top:30px;'>$hour</h1>
                                <p style='font-size:13pt;cursor:pointer;line-height:14pt;height:60px;padding-top:5px;' data-bs-toggle='modal' data-bs-target='#modalEVENT$id'>$nombre <span style='color:lightgrey;font-size:10pt;'><i class='fa-solid fa-arrow-up-right-from-square'></i></span></p>
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
                                
                                <div class='d-flex flex-column flex-lg-row'>
                                    ";
                            
                        if($current_user != 0){

                                        if ($checkRegister == 1) {
                                            $html .= "
                                                        <a href='$linkevent' style='font-style: italic;font-size:15pt;font-family:athelas;color:#8A7E71;'>
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
                                                <a href='https://somosunna.com/unna-studio/#pricing'>
                                                    <button class='btn' style='display:block;border-radius:23px;background-color:black;color:#EFEDE8;padding 0;border:0;font-size:12pt;'>inscribirme</button>
                                                </a>
                                            
                                        ";
                                }

                        $html .= "
                                </div>

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
                            <div class='modal' id='modalEVENT$idmodal'>
                                <div class='modal-dialog modal-dialog-centered modal-xl'>
                                    <div class='modal-content' style='border-radius:0;'>

                                    <!-- Modal body -->
                                    <div class='modal-body' style='position:relative;padding:0;'>
                                    
                                    <button type='button'style='position:absolute;top:8px;right:6px;' class='btn-close' data-bs-dismiss='modal'></button>

                                        <div style='width:100%;height:280px;background-image:url($imageLinkModal);background-size:cover;background-position:center center;'>
                                        </div>

                                        <div class='p-2 p-lg-4'>
                                            <div class='d-flex flex-column'>
                                                <h1 style='font-size:25pt'>$nombreModal</h1>
                                                <p style='line-height:12pt;'>$week $day de $month</p>
                                                <p style='line-height:12pt;'>$hourModal <span style='font-size:9pt;color:grey;'>(hora CDMX)</span></p>
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
                                                                Entrar a la sesión
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
                                                                <button class='btn' style='border-radius:23px;background-color:black;color:#EFEDE8;padding 0;border:0;font-size:12pt;'>Iniciar sesión</button>
                                                            </a>
                                                                
                                                            ";
                                    }
                                        /*-----------BOTON AGREGAR A CALENDARIO------------
                                        $html .= "

                                                    <a href='$linkCalendarModal' class='ms-2'>
                                                        <button class='btn' style='border-radius:23px;background-color:black;color:#EFEDE8;padding 0;border:0;font-size:12pt;'>agregar a calendario</button>
                                                    </a>
                                        ";
                                        -------------------------------*/
                                        $html .= "  
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

                                        <div class='p-2 p-lg-4'>
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
