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

            $html = "";

            if(!$id){
                $html .= "
                    <div class='wrap d-flex justify-content-center align-items-center p-4' style='border:1px solid lightgrey;'>
                        <a>Este instructor ha sido eliminado o el código es incorrecto</a>
                    </div>
                ";

            }else{
  
                $html .= "
                    <div class='wrap' style='border:1px solid lightgrey;'>
                        <div style='width:100%;height:250px;background-image:url($imageLinkInstructor);background-size:cover;background-position:center center;'>
                        </div>
                        <div style='padding:25px;'>
                            <h1 style='font-size:25pt'>$nombreInstructor</h1>
                            <p>$cargo</p>
                            <p>$descripcion</p>
                            <br>
                            <div class='d-flex justify-content-start align-items-center'>
                                <a href='$linkcategoria'>
                                    <button class='btn'style='border-radius:23px;background-color:black;color:#EFEDE8;padding 0;border:0;font-size:12pt;'>Ver clases</button>
                                </a>
                                <a class='ms-2' href='$instagramLink'>
                                    <img src='https://upload.wikimedia.org/wikipedia/commons/thumb/e/e7/Instagram_logo_2016.svg/768px-Instagram_logo_2016.svg.png' style='width:35px;height:35px;'>
                                </a>
                                <!----
                                <a href='$whatsapp'>
                                    <i class='fa-brands fa-whatsapp mx-1' style='font-size:25pt;'></i>
                                </a>
                                ------->
                            </div>
                            <br>
                        </div>
                        
                ";
            }
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
