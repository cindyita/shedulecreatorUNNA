<?php 

    class shortcodeInstructor{

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

        public function fromOpen($id, $nombreInstructor, $cargo, $imageLinkInstructor, $descripcion, $instagramLink, $whatsapp, $linkcategoria, $timestamp){

            $html = "
                <div class='wrap' style='border:1px solid lightgrey;'>
                    <div style='width:100%;height:250px;background-image:url($imageLinkInstructor);background-size:cover;background-position:center center;'>
                    </div>
                    <div style='padding:25px;'>
                        <h4>$nombreInstructor</h4>
                        <p>$cargo</p>
                        <p>$descripcion</p>
                        <br>
                        <div>
                            <a href='$linkcategoria'>
                                <button class='btn'>Ver clases</button>
                            </a> 
                            <a href='$instagramLink'>
                                <i class='fa-brands fa-instagram'></i>
                            </a>
                            <a href='$whatsapp'>
                                <i class='fa-brands fa-whatsapp'></i>
                            </a>
                        </div>
                        <br>
                    </div>
                    
            ";
            return $html;
        }

        public function fromClose(){
            $html = "  
                </div>
            ";
            return $html;
        }

        function showInstructor($instructorid){

            $i = $this->getInstructors($instructorid);

            $id = $i['instructorid'];
            $nombreInstructor = $i['nombre'];
            $cargo = $i['cargo'];
            $imageLinkInstructor = $i['imageLink'];
            $descripcion = $i['descripcion'];
            $instagramLink = $i['instagramLink'];
            $whatsapp = $i['whatsapp'];
            $linkcategoria = $i['linkcategoria'];
            $timestamp = $i['timestamp'];

            $html = $this->fromOpen($id,$nombreInstructor,$cargo, $imageLinkInstructor, $descripcion, $instagramLink, $whatsapp, $linkcategoria, $timestamp);
            $html .= $this->fromClose();

            return $html;

        }


    }
