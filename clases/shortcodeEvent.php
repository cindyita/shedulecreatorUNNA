<?php 

    class shortcodeEvent{

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

        public function eventFromOpen($id,$nombre,$imageLink,$fechahorainicio,$fechahorafin,$nombreInstructor,$imageLinkInstructor,$descripcion,$linkevent,$timestamp){


            $date =  date("l d F Y", strtotime($fechahorainicio));
            $hour = date("g:s a", strtotime($fechahorainicio));
            $html = "
                <div class='wrap' style='border:1px solid lightgrey;'>
                    <div style='width:100%;height:250px;background-image:url($imageLink);background-size:cover;background-position:center center;'>
                    </div>
                    <div style='padding:25px;'>
                        <h4>$nombre</h4>
                        <p>$date</p>
                        <p>$hour</p>
                        <div style='display:flex;align-items:center;'>
                            <img src='$imageLinkInstructor' width='40px' height='40px' style='border-radius:50%;margin-right:10px;'>
                            <p>$nombreInstructor</p>
                        </div>
                        <p>$descripcion</p>
                        <br>
                        <div>
                            <button class='btn'>inscribirme</button>
                            <button class='btn'>agregar a calendario</button>
                        </div>
                        <br>
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

            $i = $this->getInstructors($instructorIdAssign);

            $nombreInstructor = $i['nombre'];
            $imageLinkInstructor = $i['imageLink'];

            $html = $this->eventFromOpen($id, $nombre, $imageLink, $fechahorainicio, $fechahorafin, $nombreInstructor, $imageLinkInstructor, $descripcion, $linkevent, $timestamp);
            $html .= $this->eventFromClose();

            return $html;

        }


    }


?>