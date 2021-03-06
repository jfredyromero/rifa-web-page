<?php
    include_once("../static/connection/connection.php");
    $mysqli = new mysqli($host, $user, $pw, $db);

    if ($mysqli->connect_error) {
        exit('Could not connect');
    }

    $sql = "SELECT numero_boleta FROM boletas";

    $stmt = $mysqli->prepare($sql);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($num);
    
    /* Diseñado para boletas de 4 digitos*/
    define('NUMDIG', 4);

    $num_boletas_totales = 10000;
    $num_boletas_desplegar = 12;
    $boletas_totales = range(0,$num_boletas_totales);     
    
    function printTicket(string $ticket_value, string $color) : void{

        $is_ch = ($color == "gold") ? 'checked' : ' ';

        echo '                   
                <div class="ticket">
                    <svg min-width="175" min-height="117" width="100%" height="100%" viewBox="0 0 175 117"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path class="ticket-svg"
                            d="M38.8889 29.25H136.111V87.75H38.8889V29.25ZM160.417 58.5C160.417 66.5773 166.946 73.125 175 73.125V102.375C175 110.452 168.471 117 160.417 117H14.5833C6.52908 117 0 110.452 0 102.375V73.125C8.05425 73.125 14.5833 66.5773 14.5833 58.5C14.5833 50.4227 8.05425 43.875 0 43.875V14.625C0 6.54773 6.52908 0 14.5833 0H160.417C168.471 0 175 6.54773 175 14.625V43.875C166.946 43.875 160.417 50.4227 160.417 58.5ZM145.833 26.8125C145.833 22.7739 142.569 19.5 138.542 19.5H36.4583C32.4312 19.5 29.1667 22.7739 29.1667 26.8125V90.1875C29.1667 94.2261 32.4312 97.5 36.4583 97.5H138.542C142.569 97.5 145.833 94.2261 145.833 90.1875V26.8125Z"
                            fill="url(#'.$color.')" />
                        <defs>
                            <linearGradient id="silver" x1="87.5" y1="0" x2="87.5" y2="117"
                                gradientUnits="userSpaceOnUse">
                                <stop stop-color="#7C7C7C" />
                                <stop offset="0.5" stop-color="#D9D9D9" />
                                <stop offset="1" stop-color="#6A6A6A" />
                            </linearGradient>
                            <linearGradient id="gold" x1="87.5" y1="0" x2="87.5" y2="117"
                                gradientUnits="userSpaceOnUse">
                                <stop stop-color="#95702c" />
                                <stop offset="0.5" stop-color="#f8dd57" />
                                <stop offset="1" stop-color="#95702c" />
                            </linearGradient>
                        </defs>
                    </svg>
                    <h1>'.$ticket_value.'</h1>
                    <input type="checkbox" name="checkbox-ticket" value="'.$ticket_value.'" '.$is_ch.'>
                </div>';

    }

    function agregarCeros($n){
        return substr(strval($n + pow(10,NUMDIG)),1, NUMDIG);
    }    

    $boletas_compradas = [];
    while ($stmt -> fetch()) { 
        $boletas_compradas[] = (int)$num;
    }

    $boletas_disponibles = array_map("agregarceros",array_diff($boletas_totales,$boletas_compradas)); // todas las disponibles 
    
    if (isset($_POST['tickets_ch'])){
        $tch_s = $_POST['tickets_ch'];

        if($tch_s != ""){
            $tch = explode("-",$tch_s);
        }
    }
    
    if(isset($_POST['inpSearch'])){
        $iSch = $_POST['inpSearch'];

        if($iSch != ""){
            $iSch = agregarCeros($iSch);
            $is_in_tch = false;
            if($tch_s != ""){
                if((in_array($iSch,$tch)) or (sizeof($tch)==12)){
                    $is_in_tch =  true;
                }
            }

            if(in_array($iSch,$boletas_disponibles) and !$is_in_tch){

                $num_boletas_desplegar -= 1;
                printTicket($iSch,'silver');
            }
        }
    }

    if($tch_s != ""){        
        $num_boletas_desplegar = $num_boletas_desplegar - sizeof($tch);
        $boletas_disponibles = array_diff($boletas_disponibles,$tch);

        for ($i=0; $i < sizeof($tch); $i++) {   
                printTicket($tch[$i],'gold');
        }
    }
    

    // echo $num_boletas_desplegar."<br>";        
    
    if ($num_boletas_desplegar>0){
        $boletas_desplegadas = [];
        if(sizeof($boletas_disponibles) >= $num_boletas_desplegar){
            $boletas_desplegadas =  array_rand($boletas_disponibles, $num_boletas_desplegar);
            if($num_boletas_desplegar==1){
                      printTicket($boletas_disponibles[$boletas_desplegadas],'silver');
            }else{
                foreach ($boletas_desplegadas as $b) {
                    printTicket($boletas_disponibles[$b],'silver'); 
                } 
            }                       
        }else{
            $boletas_desplegadas = $boletas_disponibles;
            if($num_boletas_desplegar==1){
                echo '<input type="checkbox" name="checkbox-ticket" value="'.$boletas_disponibles[$boletas_desplegadas].'"> <label>'.$boletas_disponibles[$boletas_desplegadas].'</label><br>';
            }else{
                foreach ($boletas_desplegadas as $b) {
                    printTicket($b,'silver'); 
                }
            }            
        }
    }
    $stmt->close();
?>