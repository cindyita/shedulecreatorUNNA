<?php 

    class shortcodeNextSession{

        public function getEvents(){
            global $wpdb;
            $tabla_shedule = "{$wpdb->prefix}shedule_event";

            $query = "SELECT * FROM $tabla_shedule WHERE fechahorainicio >= CURDATE() ORDER BY fechahorainicio ASC LIMIT 1";
            $data = $wpdb->get_results($query,ARRAY_A);

            if(empty($data)){
                $data = array();
                return $data;
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
                return $data;
            } else {
                return $data[0];
            }
            
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

        public function eventFromOpen($e){

            if($e){
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
            }else{
                $id = "";
                $nombre = "";
                $imageLink = "";
                $fechahorainicio = "";
                $fechahorafin = "";
                $instructorIdAssign = "";
                $descripcion = "";
                $linkevent = "";
                $timestamp = "";
                $linkcalendar = "";
            }

            global $wpdb;

            $datestart = new DateTime($fechahorainicio);
            $date = $datestart->format('d/m/Y');
            $today = new DateTime();
            $todaydmy = $today->format('d/m/Y');
            $month = $datestart->format('m');
            $week = $datestart->format('N');   
            $day = $datestart->format('d');
            $hour = $datestart->format('g:i a');

            $current_user = wp_get_current_user()->id;
            $actualClass = new shortcodeNextSession;
            $checkRegister = $actualClass->searchRegister($id);

            if (isset($_GET['msgnext']) && $_GET['msgnext'] == 'success') {
                echo "
                    <div class='modal' id='registroexitoso2'>
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
                        var modalShowSuccess = new bootstrap.Modal(document.getElementById('registroexitoso2'), {});
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
                        echo '<script language="javascript">location.href ="' . $url . '?msgnext=success";</script>';
                        /*header("Location: $url");*/
                    } catch (Exception $e) {

                        echo '<script language="javascript">alert("ERROR: ' . $e->getMessage() . '");</script>';
                    }
                } else {
                    echo '<script language="javascript">alert("Ya te has inscrito a este evento");</script>';
                }
            }
            /*-----------------------------*/

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

            if ($todaydmy == $date) {
                $week = "hoy";
            }

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

            $html = "
                <script src='https://kit.fontawesome.com/e0df5df9e9.js' crossorigin='anonymous'></script>
                <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC' crossorigin='anonymous'>
                <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js' integrity='sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM' crossorigin='anonymous'></script>
            ";
            if(!$e){
            $html .= "
                <div class='wrap d-flex p-4 w-100 justify-content-center align-items-center' style='padding:0 10px;background-color:#f7f6f5;'>
                    <a>No hay eventos próximos ¡Revisa más tarde!</a>
                </div>
            ";

            }else{
            $html .= "
                <div class='wrap' style='width:100%;padding:0 10px;'>
                    <h1 style='color:#2B2B2B;'>Próxima sesión</h1>
                    <div class='d-flex flex-md-row flex-column align-items-center justify-content-center' style='width:100%'>

                        <div class='imageNextSession bg-primary w-100 w-md-50' style='height:300px;border-radius:20px;background-image:url($imageLink);background-repeat:no-repeat;background-size:cover;background-position:center center;'></div>

                        <div class='d-flex flex-column justify-content-center w-100 w-md-50 pt-3 pt-md-0 ps-0 ps-md-4'>
                            <h1 style='font-size:31px;color:#2B2B2B;'>$nombre</h1>
                            <div>

                            <p style='line-hight:5pt;color:#2B2B2B;'>$week $day de $month <br> $hour <span style='font-size:9pt;color:grey;'>(hora CDMX)</span></p>
 
                            </div>

                            <div class='d-flex flex-row flex-lg-column gap-1 justify-content-center'>
                            ";
                            /*------------------------------*/
                            if ($current_user != 0) {

                                if ($checkRegister == 1) {
                                    $html .= "
                                                <a class='w-xs-100 w-sm-100 w-md-100 w-lg-50 w-xl-50' href='$linkevent' style='font-style: italic;font-size:15pt;font-family:athelas;color:#8A7E71;'>
                                                    Entrar a la sesión
                                                </a>
                                        ";
                                } else {



                                $html .= "  <form method='post' action='' class='w-50'>
                                                <input type='hidden' id='inscripcionid' name='inscripcionid' value='$id'>

                                                <button class='btn w-100' style='display:block;border-radius:23px;background-color:black;color:#EFEDE8;padding 0;border:0;font-size:12pt;' id='inscribirse$id' name='inscribirse' type='submit' onclick='loading($id)'>inscribirme</button>

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
                            } elseif ($current_user == 0) {
                                $html .= "
                                            <a class='w-50' href='https://somosunna.com/unna-studio/#pricing'>
                                                <button class='btn w-100' style='display:block;border-radius:23px;background-color:black;color:#EFEDE8;padding 0;border:0;font-size:12pt;'>inscribirme</button>   
                                            </a>
                                        
                                    ";
                            }
                            /*----------BOTON AGREGAR A CALENDARIO-------------------    
                            $html .= "     
                                <a href='$linkcalendar' class='w-50'>
                                    <button class='btn w-100'style='border-radius:20px;background-color:black;color:#EFEDE8;padding 0 8px;border:0;'>agregar a calendario</button>
                                </a> ";
                            */
                            $html .= " 
                            </div>
                        </div>
                    </div>
            ";
            }
            return $html;
        }

        public function eventFromClose(){
            $html = "
                </div>
            ";
            return $html;
        }

        function showEvent(){

            $e = $this->getEvents();


            $html = $this->eventFromOpen($e);
            $html .= $this->eventFromClose();

            return $html;

        }


    }
