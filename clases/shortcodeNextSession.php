<?php 

    class shortcodeNextSession{

        public function getEvents(){
            global $wpdb;
            $tabla_shedule = "{$wpdb->prefix}shedule_event";

            $query = "SELECT * FROM $tabla_shedule WHERE fechahorainicio >= CURDATE() ORDER BY fechahorainicio ASC LIMIT 1";
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

        public function eventFromOpen($id,$nombre,$imageLink,$fechahorainicio,$fechahorafin,$nombreInstructor,$descripcion,$linkevent,$linkcalendar,$timestamp){

            $datestart = new DateTime($fechahorainicio);
            $date = $datestart->format('d/m/Y');
            $today = new DateTime();
            $todaydmy = $today->format('d/m/Y');
            $month = $datestart->format('m');
            $week = $datestart->format('N');   
            $day = $datestart->format('d');
            $hour = $datestart->format('g:i a');

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

            if ($todaydmy == $fechahorainicio) {
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

            $html = "
                <script src='https://kit.fontawesome.com/e0df5df9e9.js' crossorigin='anonymous'></script>
                <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC' crossorigin='anonymous'>
                <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js' integrity='sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM' crossorigin='anonymous'></script>
            ";

            $html .= "
                <div class='wrap' style='width:100%;padding:0 10px;'>
                    <h1 style='color:#2B2B2B;'>Próxima sesión</h1>
                    <div class='d-flex flex-md-row flex-column align-items-center justify-content-center' style='width:100%'>

                        <div class='imageNextSession bg-primary w-100 w-md-50' style='height:300px;border-radius:20px;background-image:url($imageLink);background-repeat:no-repeat;background-size:cover;background-position:center center;'></div>

                        <div class='d-flex flex-column justify-content-center w-100 w-md-50 pt-3 pt-md-0 ps-0 ps-md-4'>
                            <h1 style='font-size:31px;color:#2B2B2B;'>$nombre</h1>
                            <div>
                                <p style='line-hight:5pt;color:#2B2B2B;'>$week $day de $month <br> $hour</p>
                            </div>
                            
                            <a href='$linkcalendar' class='w-50'>
                                <button class='btn w-100'style='border-radius:20px;background-color:black;color:#EFEDE8;padding 0 8px;border:0;'>agregar a calendario</button>
                            </a>
                        </div>
                    </div>
            ";
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

            $html = $this->eventFromOpen($id, $nombre, $imageLink, $fechahorainicio, $fechahorafin, $nombreInstructor, $descripcion, $linkevent,$linkcalendar, $timestamp);
            $html .= $this->eventFromClose();

            return $html;

        }


    }
