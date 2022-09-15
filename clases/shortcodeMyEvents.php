<?php 

    class shortcodeMyEvents{

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

            $html = "<div>";

            if(!$e){

            $html .= "
                    <div class='w-100 p-4 d-flex justify-content-center'>
                        <a>Aún no te inscribes a ningún evento</a>
                    </div>
            ";

            }else{

                foreach ($r as $key => $register) {

                        foreach ($e as $key => $events) {
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
                            }

                            $datestart =  new DateTime($fechahorainicio);
                            $dateend =  new DateTime($fechahorafin);
                            $hour = date("g:s a", strtotime($fechahorainicio));
                            $day = $datestart->format('d');
                            $month = $actualClass->converterMonth($datestart);
                            $week = $actualClass->converterWeek($datestart);
                            $duracion = $datestart->diff($dateend);
                            $duracion = $actualClass->converterDuration($duracion);
                        }

                    $html .= "
                            <div class='card m-3 d-none d-lg-block' style='border-radius:10px;'>

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
                                            <span class='text-muted small'>$week $day de $month a las $hour | $duracion</span>
                                        </div>
                                        <div class='d-flex gap-2'>
                                            <a href='$imageLinkevento'>
                                                <button class='btn' style='border-radius:23px;background-color:black;color:#EFEDE8;padding 0;border:0;font-size:12pt;'>Entrar</button>
                                            </a>
                                        </diV>
                                    </div>
                                </div>

                            </div>

                            <div class='card m-3 d-block d-lg-none'>

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
                                        <div class='d-flex gap-2'>
                                            <a href='$imageLinkevento'>
                                                <button class='btn' style='border-radius:23px;background-color:black;color:#EFEDE8;padding 0;border:0;font-size:12pt;'>Entrar</button>
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
