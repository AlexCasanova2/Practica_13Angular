<?php
    session_start();
    
    $imgRetos = array("retoMental.png", "retoMental2.jpg");
    $respRetos = array("si", "no");
    
    /*
     * [{url: "", pista: "", pregunta: "", resp: ""}]
     */
    
    $respuesta = '{';
  
    if(isset($_GET["ruta"])){
        $posicion = rand(0, sizeof($imgRetos)-1);
        $_SESSION["posicion"] = $posicion;
        $respuesta .= '"ruta":"'.$imgRetos[$posicion].'"';

    }else if(isset($_GET["pregunta"])){
        $respuesta .= '"pregunta": "¿Son todas las imagenes iguales?"';
    }else if(isset($_GET["pista"])){
         $respuesta .= '"pista" : "Fíjate bien en cada una de ellas..."';
    }else if(isset($_GET["respuesta"])){
        if($respRetos[$_SESSION["posicion"]] == $_GET["respuesta"]){
            
            $respuesta .= '"respuesta" : "acertado",';
        }else{
            $respuesta .= '"respuesta" : "fallado",';
       }
        $respuesta .= '"posicion" : "'.$_GET["respuesta"].'"';
    }
    
    $respuesta .= '}';
    
    echo $respuesta;
    
?>