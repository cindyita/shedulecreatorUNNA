<?php 

    class shortcodeInstructorEvents{

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

        public function getInstructor($id){
            global $wpdb;
            $tabla_instructor = "{$wpdb->prefix}shedule_instructor";

            $query = "SELECT * FROM $tabla_instructor WHERE instructorid = '$id'";
            $data = $wpdb->get_results($query, ARRAY_A);

            if (empty($data)) {
                $data = array();
                return $data;
            } else {
                return $data[0];
            }
        }

        public function getEventsInstructor($instructorid)
        {
            global $wpdb;
            $tabla_shedule = "{$wpdb->prefix}shedule_event";

            $query = "SELECT * FROM $tabla_shedule WHERE instructorIdAssign = $instructorid ORDER BY fechahorafin desc";
            $data = $wpdb->get_results($query, ARRAY_A);

            if (empty($data)) {
                $data = array();
            }
            
            return $data;
            
        }

        public function getRegistersEvent($eventoid)
        {
            global $wpdb;
            $tabla_instructor = "{$wpdb->prefix}shedule_registrations";

            $query = "SELECT * FROM $tabla_instructor WHERE eventid = $eventoid";
            $data = $wpdb->get_results($query, ARRAY_A);

            if (empty($data)) {
                $data = array();
            }
            return $data;
            
        }

        public function fromOpen($i,$e){

        global $wpdb;
        $actualClass = new shortcodeInstructorEvents;
        $instructorId = $i['instructorid'];
        $instructorNombre = $i['nombre'];
        $imageInstructor = $i['imageLink'];

        $nombreEvento = null;
        $imageLinkevento = null;
        $fechahorainicio = null;
        $fechahorafin = null;
        $descripcion = null;
        $linkevent = null;
        $linkcalendar = null;

        $today = new DateTime();

        $url = $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];

        /*POST BORRAR EVENTO*/
        if (isset($_POST['deleteEventByInstructor'])) {
            $id = $_POST['eventid'];

            $tabla_events = "{$wpdb->prefix}shedule_event";
            $wpdb->delete($tabla_events, array('eventoid' => $id));
            header("Location: $url");
        }

        $html = "
                <script src='https://kit.fontawesome.com/e0df5df9e9.js' crossorigin='anonymous'></script>
                <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC' crossorigin='anonymous'>
                <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js' integrity='sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM' crossorigin='anonymous'></script>
            ";

        $html .= "<div>
        <div class='d-flex w-100 justify-content-center align-items-center'>
            <img src='$imageInstructor' style='border-radius:50%;width:45px;height:45px;margin-right:15px;margin-bottom:18px;'>
            <h4 class='mb-3'>eventos de $instructorNombre <span class='text-muted' style='font-size:11pt;'>(id: $instructorId)</span></h4>
        </div><br>
        <hr style='border-bottom:1px solid black;'><br>
        ";

        $count = 0;

        if (!$e) {

            $html .= "
                    <div class='w-100 p-4 d-flex justify-content-center'>
                        <a>Aún no tienes ningún evento asociado</a>
                    </div>
            ";
        } else {

                foreach ($e as $events) {
                  
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
                        
                        $count++;

                        /*if ($dateend >= $today) {*/
                            
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
                                            ";
                                    if ($dateend >= $today) {
                                            $html .= "
                                                <span class='text-muted small'>$week $day de $month a las $hour <span style='font-size:9pt;color:grey;'>(hora CDMX)</span> | $duracion</span> ";
                                    } else {
                                        $html .= "
                                                <span class='text-danger small'>$week $day de $month a las $hour <span style='font-size:9pt;'>(hora CDMX)</span> | <strong>Caducado</strong></span> ";
                                        }
                                        $html .= "

                                        </div>
                                        <div class='d-flex gap-2 align-items-center'>
                                            <a data-bs-toggle='modal' data-bs-target='#viewRegistersEvent$eventid'>
                                                <button class='btn' style='border-radius:23px;background-color:black;color:#EFEDE8;padding 0;border:0;font-size:12pt;'>Ver inscripciones</button>
                                            </a> 
                                            <a data-bs-toggle='modal' data-bs-target='#eliminarEventoByInstructor$eventid' class='eliminarClase text-danger mt-2'>
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
                                            ";
                                            if ($dateend >= $today) {
                                                $html .= "
                                                <span class='text-muted text-center small'>$week $day de $month a las $hour | $duracion</span>
                                                } ";
                                            }else{
                                                $html .= "
                                                <span class='text-danger text-center small'>$week $day de $month a las $hour | <strong>Caducado</strong></span>
                                                } ";
                                            }
                                            $html .= "
                                        </div>
                                        <div class='d-flex gap-2 align-items-center'>
                                            <a data-bs-toggle='modal' data-bs-target='#viewRegistersEvent$eventid'>
                                                <button class='btn' style='border-radius:23px;background-color:black;color:#EFEDE8;padding 0;border:0;font-size:12pt;'>Ver inscripciones</button>
                                            </a>
                                            <a data-bs-toggle='modal' data-bs-target='#eliminarEventoByInstructor$eventid' class='eliminarClase text-danger mt-2'>
                                                <i style='font-size:18pt;' class='fa-solid fa-circle-xmark'></i>
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
                                                ";
                                                if ($dateend >= $today) {
                                                    $html .= "
                                                    <p style='line-height:12pt;'>$week $day de $month</p>
                                                    ";
                                                }else{
                                                    $html .= "
                                                    <p style='line-height:12pt;color:red;'>$week $day de $month</p>
                                                    ";
                                                }
                                                $html .= "
                                                <p style='line-height:12pt;'>$hour <span style='font-size:9pt;color:grey;'>(hora CDMX)</span></p>
                                                <p style='line-height:12pt;'>$duracion <span style='font-size:9pt;color:grey;'>(hora CDMX)</span></p>
                                            </div>
                                    ";
/*
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
*/
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
                <div class='modal' id='eliminarEventoByInstructor$eventid'>
                    <div class='modal-dialog'>
                        <div class='modal-content'>

                        <!-- Modal Header -->
                        <div class='modal-header'>
                            <h4 class='modal-title'>Eliminar evento</h4>
                            <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                        </div>

                        <!-- Modal body -->
                        <div class='modal-body'>
                            <div class='d-flex flex-column w-100 align-items-center'>
                                <span>
                                    ¿Te gustaría eliminar el evento <span class='text-danger'>$nombreEvento</span>?
                                </span>
                                <br>
                                <form method='post'>
                                    <input type='hidden' id='eventid' name='eventid' value='$eventid'>
                                    <button type='submit' id='deleteEventByInstructor' name='deleteEventByInstructor' class='btn btn-danger'>eliminar</button>
                                    <span class='text-muted'> *Puede tardar un rato</span>
                                </form>
                            </div> 
                        </div>

                        </div>
                    </div>
                </div>
            ";
            /*Modal ver registros*/

            $registersForEvent = $actualClass->getRegistersEvent($eventid);
            $countRegisters =  count($registersForEvent);

            $html .= "
                    <div class='modal fade' id='viewRegistersEvent$eventid'>
                        <div class='modal-dialog modal-xl modal-dialog-centered'>
                            <div class='modal-content'>

                                <div class='modal-header'>
                                    <h4 class='modal-title'>Registros para: $nombreEvento [id: $eventid]</h4>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                </div>

                                <div class='modal-body'>
                                    <label class='mb-3'>Total de registros: $countRegisters</label>
                                    ";

                                
                                    if (!$countRegisters <= 0) {
                               
                                    $html .= "
                                        <div class='d-flex flex-column'>
                                            <div class='row text-bold' style='border-bottom:1px solid lightgrey;border-top:1px solid lightgrey;'>
                                                <div class='col-sm-2 p-3'><strong>Id reg</strong></div>
                                                <div class='col-sm-2 p-3'><strong>Id usuario</strong></div>
                                                <div class='col-sm-2 p-3'><strong>Usuario</strong></div>
                                                <div class='col-sm-3 p-3'><strong>Email</strong></div>
                                                <div class='col-sm-3 p-3'><strong>Fecha registro</strong></div>
                                            </div>

                                            ";

                                            foreach ($registersForEvent as $registers) {

                                                    $user = new WP_User($registers['userid']);
                                                /*  $user_phone = get_user_meta($registers['userid'], 'dbem_phone', true); */
                                                    $registerid = $registers['registerid'];
                                                    $userid = $registers['userid'];
                                                    $fecharegister = $registers['timestamp'];

                                            $html .= "
                                                    <div class='row' style='border-bottom:1px solid lightgrey;'>
                                                        <div class='col-sm-2 p-3'>$registerid</div>
                                                        <div class='col-sm-2 p-3'>$userid</div>
                                                        <div class='col-sm-2 p-3'>$user->user_nicename</div>
                                                        <div class='col-sm-3 p-3'>$user->user_email</div>
                                                        <div class='col-sm-3 p-3'>$fecharegister</div>
                                                    </div>
                                                    ";
                                                }
                                            }else{

                                            $html .= "
                                            <p>Aún no hay registros para este evento</p>
                                            ";

                                            }
                                            
                                        $html .= "

                                       </div>

                                </div>

                            </div>
                        </div>
                    </div>
                    ";
                    /*--------------*/
          

                } /*fin FOR events*/


            if ($count == 0) {
                $html .= "
                                <div style='color:#8d7e6f;' class='w-100 p-4 d-flex justify-content-start'>
                                    <a>Aún no tienes eventos asociados ni caducados.</a>
                                </div>
                        ";
            }
        }

        return $html;
        }

        public function fromClose(){
            $html = "  
                </div>
            ";
            return $html;
        }

        function showInstructorEvents($instructorid){

            $i = $this->getInstructor($instructorid);
            $e = $this->getEventsInstructor($instructorid);


            $html = $this->fromOpen($i,$e);
            $html .= $this->fromClose();

            return $html;

        }


    }
