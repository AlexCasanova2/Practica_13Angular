<?php
    session_start();
       
    if(!isset($_SESSION["usuarios"])) 
        $_SESSION["usuarios"] = array("alex" => array("nick" => "alex", "edad" => "21", "puntuacion" => "34", "intentos" => "5"));
    
    else $_SESSION["usuarios"];
    
    switch ($_SERVER['REQUEST_METHOD']) {
        case "GET":
            if(empty(explode("usuaris/", $_SERVER['REQUEST_URI'])[1])){
                echo json_encode($_SESSION["usuarios"]);               
            }else{
                $datos = split("/", explode("usuaris/", $_SERVER['REQUEST_URI'])[1]);
                
                if($datos[0] == "login"){
                    $nick = $datos[1]; $edad = $datos[2]; 
                    if(!isset($_SESSION["usuarios"][$nick])){
                        $nuevoUsuario = array("nick" => $nick, "edad" => $edad, "puntuacion" => 0, "intentos" => 0);
                        $_SESSION["usuarios"][$nick] = $nuevoUsuario;
                    }else{
                        
                        $_SESSION["usuarios"][$nick]["edad"] = $edad;
                    }
                    echo json_encode($_SESSION["usuarios"]);
                    
                }else if($datos[0] == "byuser"){
                    $nick = $datos[1];
                    echo json_encode($_SESSION["usuarios"][$nick]);
                }
            }
            break;
            
        case "PUT":
            
            $datos = json_decode(file_get_contents("php://input"), false);
            $datos->intentos = $datos->intentos + 1;
            
            if(split("/", explode("usuaris/", $_SERVER['REQUEST_URI'])[1])[0] == "acertado"){
                $datos->puntuacion = $datos->puntuacion + 1;
            }
            
            $_SESSION["usuarios"][$datos->nick] = $datos;
            echo json_encode($_SESSION["usuarios"]);
            
            break;
            
        case "DELETE":
            $nick = explode("usuaris/", $_SERVER['REQUEST_URI'])[1];
            unset($_SESSION["usuarios"][$nick]);
            break;
    }
?>


