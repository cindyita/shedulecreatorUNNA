<?php 

    class shortcodeEvent{

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

        public function getEvents($id){
            global $wpdb;
            $tabla_shedule = "{$wpdb->prefix}shedule_event";

            $query = "SELECT * FROM $tabla_shedule WHERE eventoid = '$id'";
            $data = $wpdb->get_results($query,ARRAY_A);

            if(empty($data)){
                $data = array();
            }
            return $data[0];
        }

        public function getInstructors($id){
            global $wpdb;
            $tabla_instructor = "{$wpdb->prefix}shedule_instructor";

            $query = "SELECT * FROM $tabla_instructor WHERE instructorid = '$id'";
            $data = $wpdb->get_results($query, ARRAY_A);

            if (empty($data)) {
                $data = array();
            }
            return $data[0];
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

        public function eventFromOpen($id,$nombre,$imageLink,$fechahorainicio,$fechahorafin,$nombreInstructor,$imageLinkInstructor,$descripcion,$linkevent,$linkcalendar,$timestamp){

            global $wpdb;

            $actualClass = new shortcodeEvent;
            $userId = get_current_user_id();

            $date =  new DateTime($fechahorainicio);
            $hour = date("g:s a", strtotime($fechahorainicio));

            $day = $date->format('d');
            $month = $actualClass->converterMonth($date);
            $week = $actualClass->converterWeek($date);

            if (isset($_GET['msgevent']) && $_GET['msgevent'] == 'success') {
                echo "
                    <div class='modal' id='registroexitoso3'>
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
                        var modalShowSuccess = new bootstrap.Modal(document.getElementById('registroexitoso3'), {});
                        document.onreadystatechange = function () {
                            modalShowSuccess.show();
                        };
                    </script>";
            }

            /*POST INSCRIPCION*/
            if (isset($_POST['inscribirse'])) {

                $idins = $_POST['inscripcionid'];
                $url = $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];

                if ($actualClass->searchRegister($idins) != 1) {

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
                        echo '<script language="javascript">location.href ="' . $url . '?msgevent=success";</script>';
                       
                        /*header("Location: $url");*/
                    } catch (Exception $e) {

                        echo '<script language="javascript">alert("ERROR: ' . $e->getMessage() . '");</script>';
                    }
                } else {
                    echo '<script language="javascript">alert("Ya te has inscrito a este evento");</script>';
                }
            }
            /*----------------*/

            $checkRegister = $actualClass->searchRegister($id);
            $datecheck = $date->format('d/m/Y');
            $today = new DateTime();
            $today = $today->format('d/m/Y');

            $html = "";

            if(!$id){

            $html .= "
                    <div class='wrap d-flex justify-content-center align-items-center p-4' style='border:1px solid lightgrey;'>
                        <a>Este evento ha sido eliminado o el código es incorrecto</a>
                    </div>
                ";

            }else{

            $html .= "
                <div class='wrap' style='border:1px solid lightgrey;'>
                    <div style='width:100%;height:250px;background-image:url($imageLink);background-size:cover;background-position:center center;'>
                    </div>
                    <div style='padding:25px;'>
                        <div class='d-flex flex-column'>
                            <h1 style='font-size:25pt'>$nombre</h1>
                            <p style='line-height:12pt;'>$week $day de $month</p>
                            <p style='line-height:12pt;'>$hour <span style='font-size:9pt;color:grey;'>(hora CDMX)</span></p>
                        </div>
                ";
                if($nombreInstructor){
                $html .= "
                        <div style='display:flex;align-items:center;'>
                            <span>
                                <img src='$imageLinkInstructor' style='width:50px;height:50px;border-radius:50%;margin-right:5px;'></span>
                            <span>
                                $nombreInstructor
                            </span>
                            
                        </div>

                ";
                }

            $html .= "

                        <p>$descripcion</p>
                        <br>
                        <div class='d-flex gap-2 align-items-center'>
                    ";
                    if($datecheck >= $today){
                            /*-----------------------*/
                            if ($userId != 0) {
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
                            } elseif ($userId == 0) {
                                $html .= "
                                            <a href='https://somosunna.com/unna-studio/'>
                                                <button class='btn' style='display:block;border-radius:23px;background-color:black;color:#EFEDE8;padding 0;border:0;font-size:12pt;'>inscribirme</button>
                                            </a>
                                                
                                            ";
                            }
                        /*-----------------------*/
                        $html .= "
                            <a href='$linkcalendar'>
                                <button class='btn' style='border-radius:23px;background-color:black;color:#EFEDE8;padding 0;border:0;font-size:12pt;'>agregar a calendario</button>
                            </a>
                         ";
                        }else{
                            $html .= "
                                <a>
                                    Evento expirado
                                </a>
                            ";
                        }

                    $html .= "
                        </div>
                        <br>
                    </div>
                    
            ";
            }
            return $html;
        }

        public function eventRegistration($idEvent){

            global $wpdb;
            $userId = get_current_user_id();
            $tabla_register = "{$wpdb->prefix}shedule_registrations";
            $format = NULL;

            if(isset($idEvent)){
                $data = array(
                    'registerid' => NULL,
                    'userid' => $userId,
                    'eventid' => $idEvent
                );
            }

            try {

                $wpdb->insert($tabla_register, $data, $format);

                } catch (Exception $e) {

                echo '<script language="javascript">alert("ERROR: '. $e->getMessage().'");</script>';
                }


            echo '<script language="javascript">alert("Te has registrado con éxito");</script>';

        }

        public function eventFromClose(){
            $html = "  
                </div>
            ";
            return $html;
        }

        function showEvent($eventoid){

            $e = $this->getEvents($eventoid);

            $id = $e['eventoid'];
            $nombre = $e['nombre'];
            $imageLink = $e['imageLink'];
            $fechahorainicio = $e['fechahorainicio'];
            $fechahorafin = $e['fechahorafin'];
            $instructorIdAssign = $e['instructorIdAssign'];
            $descripcion = $e['descripcion'];
            $linkevent = $e['linkevent'];
            $timestamp = $e['timestamp'];
            $linkcalendar = $e['linkcalendar'];

            $i = $this->getInstructors($instructorIdAssign);

            $nombreInstructor = $i['nombre'];
            $imageLinkInstructor = $i['imageLink'];

            $html = $this->eventFromOpen($id, $nombre, $imageLink, $fechahorainicio, $fechahorafin, $nombreInstructor, $imageLinkInstructor, $descripcion, $linkevent, $linkcalendar,$timestamp);
            $html .= $this->eventFromClose();

            return $html;

        }


    }


?>