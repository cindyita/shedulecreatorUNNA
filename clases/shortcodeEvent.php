<?php 

    class shortcodeEvent{

    public function converterWeek($datestart)
    {

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

    public function converterMonth($datestart)
    {

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
                        echo '<script language="javascript">alert("Te has registrado con éxito");</script>';
                        sleep(5);
                        header("Location: $url");
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
                            <p style='line-height:12pt;'>$hour</p>
                        </div>
                ";
                if($nombreInstructor){
                $html .= "
                        <div style='display:flex;align-items:center;'>
                            <img src='$imageLinkInstructor' width='40px' height='40px' style='border-radius:50%;margin-right:10px;margin-bottom:18px;'>
                            <p>$nombreInstructor</p>
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
                                                <a href='$linkevent' style='font-style: italic;font-size:15pt;font-family:athelas'>
                                                    Clase reservada
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
                                            <a href='../login'>
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