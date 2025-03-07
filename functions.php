<?php
    include_once "database.php";
    global $viajeBrasil, $auto;
    $viajeBrasil = 2500;
    $auto = 4950;
    function generate_winner ($num_compra, $premios, $db){
        global $viajeBrasil, $auto;
        foreach ($premios as &$premio) { 
            if ($num_compra ==  $premio['cada_n_compras']) {
                if ($premio['disponibles'] > 0) {
                    update_disponibilidad($db, $premio, $premio['disponibles'] - 1);
                    return $premio;
                }else{
                    return false;
                }
            } elseif ($num_compra % $premio['cada_n_compras'] == 0 && $premio['disponibles'] > 0 && $num_compra != $viajeBrasil && $num_compra != $auto) {
                update_disponibilidad($db, $premio, $premio['disponibles'] - 1);
                return $premio;
            }
        }
        return false;
    }

    function generate_img_slots($award){
        $arrayImg = [
            './resources/img/10k.png', './resources/img/20k.png', './resources/img/argentina.png', './resources/img/auto.png', './resources/img/brasil.png', './resources/img/perfume.png', 
            './resources/img/10k.png', './resources/img/20k.png', './resources/img/argentina.png', './resources/img/auto.png', './resources/img/brasil.png', './resources/img/perfume.png', 
            './resources/img/10k.png', './resources/img/20k.png', './resources/img/argentina.png', './resources/img/auto.png', './resources/img/brasil.png', './resources/img/perfume.png', 
            './resources/img/10k.png', './resources/img/20k.png', './resources/img/argentina.png', './resources/img/auto.png', './resources/img/brasil.png', './resources/img/perfume.png', 
            './resources/img/10k.png', './resources/img/20k.png', './resources/img/argentina.png', './resources/img/auto.png', './resources/img/brasil.png', './resources/img/perfume.png', 
            './resources/img/10k.png', './resources/img/20k.png', './resources/img/argentina.png', './resources/img/auto.png', './resources/img/brasil.png', './resources/img/perfume.png', 
            './resources/img/10k.png', './resources/img/20k.png', './resources/img/argentina.png', './resources/img/auto.png', './resources/img/brasil.png', './resources/img/perfume.png', 
            './resources/img/10k.png', './resources/img/20k.png', './resources/img/argentina.png', './resources/img/auto.png', './resources/img/brasil.png', './resources/img/perfume.png', 
            './resources/img/10k.png'
        ];
        if ($award) {
            if($award == '10k.png'){
                return $arrayImg;
            }
            $arrayImg[] = './resources/img/' . $award;
        } else {
            $arrayImg[] = './resources/img/error.png';
        }
        return $arrayImg;
    }
    
?>