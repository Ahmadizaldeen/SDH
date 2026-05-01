<?php

function dd($data) { //dump and die
    echo "dump und die: <pre>";
    
    if (empty($data)) {
        echo gettype($data) ." ist leer.";
        exit;
    }
    else{
        print_r($data);    
        #var_dump($data);
        exit;
    }
}
?>