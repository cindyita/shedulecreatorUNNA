<?php 

    class shortcodeOverview{

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
                <div class='wrap'>
                    
            ";

            foreach ($e as $key => $value) {
                $nombre = $value['nombre'];
                $date = $value['fechahorainicio'];
                $html .= "
                    <div style='border:1px solid lightgrey; padding:10px;margin:10px;'>
                        <p>$nombre</p>
                        <p>$date</p>
                    </div>
                    <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#myModala'>
                        Open modal
                    </button>
                ";
            $html .= "
                <!-- The Modal -->
                <div class='modal' id='myModala'>
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
