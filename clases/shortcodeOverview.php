<?php 

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

        public function eventFromOpen($e){

            $html = "
            <script src='https://kit.fontawesome.com/e0df5df9e9.js' crossorigin='anonymous'></script>
            <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC' crossorigin='anonymous'>
            <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js' integrity='sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM' crossorigin='anonymous'></script>
            
            <div class='wrap' style='display:flex;padding:0 10px;'>
                    
            ";

            foreach ($e as $key => $value) {
                
                $nombre = $value['nombre'];
                $datestart = $value['fechahorainicio'];
                $datestart = new DateTime($datestart);
                $week = $datestart->format('N');
                $month = $datestart->format('m');
                $dateend = $value['fechahorafin'];
                $dateend = new DateTime($dateend);
                $duracion = $datestart->diff($dateend);
                $duraciondate = "";
                $hour = $datestart->format('g:i a');
                $date = $datestart->format('d/m/Y');
                $day = $datestart->format('d');
                $id = $value['eventoid'];

                $linkevent = $value['linkevent'];
                $instructorIdAssign = $value['instructorIdAssign'];

                $today = new DateTime();
                $todaydmy = $today->format('d/m/Y');

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

                if($todaydmy == $date){
                    $week = "Hoy";
                }

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

                if($datestart >= $today){

                    $html .= "
                        <div style='padding:20px;margin:5px;box-shadow:2px 2px 4px 2px lightgrey;background-color:#F1F0EA;width:220px;'>
                            <a>
                                <h1 style='font-size:30px;'>$week</h1>
                                ";

                            if ($week != "Hoy") {
                                $html .= "<p style='color:#8A7E71;font-size:11px;'>$day de $month</p>";
                            } else {
                                $html .= "<br>";
                            }

                    $html .= "
                            </a>
                            <h1 style='color:#8A7E71;font-size:21pt;'>$hour</h1>
                            <p style='font-size:14pt;cursor:pointer;' data-bs-toggle='modal' data-bs-target='#modal$id'>$nombre</p>

                            <p>Instructor: $instructorIdAssign</p>
                            <hr>

                            <p style='color:#8A7E71;font-size:14pt;'>$duraciondate</p>

                            <a href='$linkevent' class='w-50'>
                                <button class='btn w-75'style='border-radius:23px;background-color:black;color:#EFEDE8;padding 0;border:0;font-size:12pt;'>registrarme</button>
                            </a>

                        </div>
                    ";
                    $html .= "
                        <!-- The Modal -->
                        <div class='modal' id='modal$id'>
                            <div class='modal-dialog'>
                                <div class='modal-content'>

                                <!-- Modal Header -->
                                <div class='modal-header'>
                                    <h4 class='modal-title'>Modal Heading</h4>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                </div>

                                <!-- Modal body -->
                                <div class='modal-body'>
                                    Modal body..
                                </div>

                                <!-- Modal footer -->
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-danger' data-bs-dismiss='modal'>Close</button>
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
            ";
            return $html;
        }

        function showOverview(){

            $e = $this->getEvents();

            $html = $this->eventFromOpen($e);
            $html .= $this->eventFromClose();

            return $html;

        }


    }
