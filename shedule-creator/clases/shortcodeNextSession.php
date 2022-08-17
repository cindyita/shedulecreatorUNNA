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

        public function eventFromOpen($id,$nombre,$imageLink,$fechahorainicio,$fechahorafin,$nombreInstructor,$descripcion,$linkevent,$timestamp){

            $date =  date("l d F Y", strtotime($fechahorainicio));
            $hour = date("g:s a", strtotime($fechahorainicio));
            $html = "
                <div class='wrap w-100' style='width:100%;padding:0 10px;'>
                    <h1>Próxima sesión</h1>
                    <div style='display:flex;'>
                        <img src='$imageLink' width='50%;' style='border-radius:10%'>
                        <div style='padding:0 0 40px 40px;width:50%'>
                            <h3>$nombre</h3>
                            <p>$date</p>
                            <p>$hour</p>
                            <button>agregar a calendario</button>
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

            $i = $this->getInstructors($instructorIdAssign);

            $nombreInstructor = $i['nombre'];

            $html = $this->eventFromOpen($id, $nombre, $imageLink, $fechahorainicio, $fechahorafin, $nombreInstructor, $descripcion, $linkevent, $timestamp);
            $html .= $this->eventFromClose();

            return $html;

        }


    }
