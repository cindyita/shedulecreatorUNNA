<?php 

    class shortcodeMyEvents{

    public function converterWeek($datestart)
    {

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

    public function converterMonth($datestart)
    {

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

    public function converterDuration($duracion)
    {

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

        public function getEvents(){
            global $wpdb;
            $tabla_shedule = "{$wpdb->prefix}shedule_event";

            $query = "SELECT * FROM $tabla_shedule";
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
        public function getRegisters($userid) {

            global $wpdb;
            $tabla_instructor = "{$wpdb->prefix}shedule_registrations";

            $query = "SELECT * FROM $tabla_instructor WHERE userid = '$userid'";
            $data = $wpdb->get_results($query, ARRAY_A);

            if (empty($data)) {
                $data = array();
            }
            return $data;

        }

        public function eventFromOpen($e,$i,$r){

            global $wpdb;
            $actualClass = new shortcodeEvent;
            $userId = get_current_user_id();

            $nombreEvento = null;
            $imageLinkevento = null;
            $fechahorainicio = null;
            $fechahorafin = null;
            $descripcion = null;
            $linkevent = null;
            $linkcalendar = null;
            $instructorid = null;

            $today = new DateTime();

            $url = $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];

            /*POST BORRAR INSCRIPCION*/
            if (isset($_POST['deleteinscripcion'])) {
                $id = $_POST['eventid'];
                $registerid = 0;

                foreach ($r as $register) {
                    if($register['userid'] == $userId && $register['eventid'] == $id){
                        $registerid = $register['registerid'];
                    }
                }

                $tabla_registrations = "{$wpdb->prefix}shedule_registrations";
                $wpdb->delete($tabla_registrations, array('registerid' => $registerid));
                header("Location: $url");
            }

            $html = "
                <script src='https://kit.fontawesome.com/e0df5df9e9.js' crossorigin='anonymous'></script>
                <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC' crossorigin='anonymous'>
                <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js' integrity='sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM' crossorigin='anonymous'></script>
            ";

            $html .= "<div>";

            if(!$e){

            $html .= "
                    <div class='w-100 p-4 d-flex justify-content-center'>
                        <a>Aún no te inscribes a ningún evento</a>
                    </div>
            ";

            }else{

                foreach ($r as $register) {
                    
                        foreach ($e as $events) {
                            if($events['eventoid'] == $register['eventid']){
                                $eventid = $events['eventoid'];
                                $nombreEvento = $events['nombre'];
                                $imageLinkevento = $events['imageLink'];
                                $fechahorainicio = $events['fechahorainicio'];
                                $fechahorafin = $events['fechahorafin'];
                                $duracion = 0;
                                $descripcion = $events['descripcion'];
                                $linkevent = $events['linkevent'];
                                $linkcalendar = $events['linkcalendar'];
                                $instructorid = $events['instructorIdAssign'];      

                                $datestart =  new DateTime($fechahorainicio);
                                $dateend =  new DateTime($fechahorafin);
                                $hour = date("g:s a", strtotime($fechahorainicio));
                                $day = $datestart->format('d');
                                $month = $actualClass->converterMonth($datestart);
                                $week = $actualClass->converterWeek($datestart);
                                $duracion = $datestart->diff($dateend);
                                $duracion = $actualClass->converterDuration($duracion);

                        if ($dateend >= $today) {
                            

                    $html .= "
                            <div class='cardClase card m-3 d-none d-lg-block' style='border-radius:10px;'>

                                <div class='card-body p-4' style='position:relative;'>
                                    <a data-bs-toggle='modal' data-bs-target='#modal$eventid' style='cursor:pointer;'>
                                        <div style='position:absolute;left:0;top:0;width:25%;height:100%;border-radius:10px 0 0 10px;'>
                                            <img src='$imageLinkevento' style='width:100%;height:100%;object-fit:cover;border-radius:10px 0 0 10px;'>
                                        </div>
                                        
                                    </a>
                                    <div class='d-flex justify-content-between align-items-center' style='margin-left:26%;'>
                                        <div class='d-flex flex-column'>
                                            <a data-bs-toggle='modal' data-bs-target='#modal$eventid'>
                                                <label style='cursor:pointer;'>$nombreEvento</label>
                                            </a>
                                            <span class='text-muted small'>$week $day de $month a las $hour <span style='font-size:9pt;color:grey;'>(hora CDMX)</span> | $duracion</span>
                                        </div>
                                        <div class='d-flex gap-2 align-items-center'>
                                            <a href='$linkevent'>
                                                <button class='btn' style='border-radius:23px;background-color:black;color:#EFEDE8;padding 0;border:0;font-size:12pt;'>Entrar</button>
                                            </a>                                    
                                            <a data-bs-toggle='modal' data-bs-target='#eliminarEventoLista$eventid' class='eliminarClase text-danger mt-2'>
                                                <i style='font-size:18pt;' class='fa-solid fa-circle-xmark'></i>
                                            </a>
                                        </diV>
                                    </div>
                                </div>

                            </div>
                            <style>
                                .cardClase .eliminarClase { display:none;cursor:pointer; }
                                .cardClase:hover .eliminarClase { display:block; }
                            </style>

                            <div class='cardClaseM card m-3 d-block d-lg-none'>

                                <div class='card-body p-4' style='position:relative;'>
                                    <a data-bs-toggle='modal' data-bs-target='#modal$eventid' style='cursor:pointer;'>
                                        <img src='$imageLinkevento' style='position:absolute;left:0;top:0;width:100%;'>
                                    </a>
                                    <div class='d-flex flex-column justify-content-center align-items-center' style='margin-top:70%;'>
                                        <div class='d-flex flex-column justify-content-center align-items-center mb-2'>
                                            <a data-bs-toggle='modal' data-bs-target='#modal$eventid'>
                                                <label style='cursor:pointer;' class='text-center'>$nombreEvento</label>
                                            </a>
                                            <span class='text-muted text-center small'>$week $day de $month a las $hour | $duracion</span>
                                        </div>
                                        <div class='d-flex gap-2 align-items-center'>
                                            <a href='$imageLinkevento'>
                                                <button class='btn' style='border-radius:23px;background-color:black;color:#EFEDE8;padding 0;border:0;font-size:12pt;'>Entrar</button>
                                            </a>
                                            <a data-bs-toggle='modal' data-bs-target='#eliminarEventoLista$eventid' class='eliminarClaseM text-danger'>
                                                <i class='fa-solid fa-circle-xmark'></i>
                                            </a>
                                        </diV>
                                    </div>
                                </div>

                            </div>
                    ";

                $html .= "
                            <div class='modal' id='modal$eventid'>
                                <div class='modal-dialog modal-dialog-centered modal-lg'>
                                    <div class='modal-content' style='border-radius:0;'>

                                    <!-- Modal body -->
                                    <div class='modal-body' style='position:relative;padding:0;'>
                                    
                                    <button type='button'style='position:absolute;top:8px;right:6px;' class='btn-close' data-bs-dismiss='modal'></button>

                                        <div style='width:100%;height:280px;background-image:url($imageLinkevento);background-size:cover;background-position:center center;'>
                                        </div>

                                        <div style='padding:50px;'>
                                            <div class='d-flex flex-column'>
                                                <h1 style='font-size:25pt'>$nombreEvento</h1>
                                                <p style='line-height:12pt;'>$week $day de $month</p>
                                                <p style='line-height:12pt;'>$hour</p>
                                            </div>
                                    ";

                foreach ($i as $valuein) {

                    $idInstructor = $valuein['instructorid'];

                    if ($idInstructor == $instructorid) {

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

                                            <p>$descripcion</p>
                                            <br>
                                            <div>
                                                <a href='$linkevent'>
                                                    <button class='btn' style='border-radius:23px;background-color:black;color:#EFEDE8;padding 0;border:0;font-size:12pt;'>Entrar</button>
                                                </a>
                                                <a href='$linkcalendar' class='ms-2'>
                                                    <button class='btn' style='border-radius:23px;background-color:black;color:#EFEDE8;padding 0;border:0;font-size:12pt;'>agregar a calendario</button>
                                                </a>
                                            </div>
                                            <br>
                                        </div>
                                        
                                    </div>


                                    </div>
                                </div>
                            </div>
            ";
            /*modal eliminar*/ 
            $html .= "
                <div class='modal' id='eliminarEventoLista$eventid'>
                    <div class='modal-dialog'>
                        <div class='modal-content'>

                        <!-- Modal Header -->
                        <div class='modal-header'>
                            <h4 class='modal-title'>Eliminar inscripción</h4>
                            <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                        </div>

                        <!-- Modal body -->
                        <div class='modal-body'>
                            <div class='d-flex flex-column w-100 align-items-center'>
                                <span>
                                    ¿Te gustaría eliminar tu inscripción al evento <span class='text-danger'>$nombreEvento</span>?
                                </span>
                                <br>
                                <form method='post'>
                                    <input type='hidden' id='eventid' name='eventid' value='$eventid'>
                                    <button type='submit' id='deleteinscripcion' name='deleteinscripcion' class='btn btn-danger'>eliminar</button>
                                    <span class='text-muted'> *Puede tardar un rato</span>
                                </form>
                            </div> 
                        </div>

                        </div>
                    </div>
                </div>
            ";

                            } /* fin IF date*/
                        } /* fin IF event = register */
                    } /*fin FOR events*/
                } /*fin FOR registers*/
            }
                
            return $html;
        }


        public function eventFromClose(){
            $html = "  
                </div>
            ";
            return $html;
        }

        function showMyEvents(){

            $userid = get_current_user_id();

            $e = $this->getEvents();
            $i = $this->getInstructors();
            $r = $this->getRegisters($userid);

            $html = $this->eventFromOpen($e,$i,$r);
            $html .= $this->eventFromClose();

            return $html;

        }


    }
