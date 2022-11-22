<?php
    $arrAvatares = [];

    function getRandAvatarURL($id) {
        // Semilla aleatoria de letras y numeros
        $valoresPosibles = 'abcdefghijklmnopqrstuvwxyz';

        // Generar un string de entre 5 y 15 caracteres
        $longitud = rand(5, 15);

        // Devolver el string
        return 'https://avatars.dicebear.com/api/adventurer-neutral/' . $id . '.svg';
    }


    /**
     * Coge el avatar guardado en array, o si no existe, lo genera y lo guarda
     */
    function getAvatar($id) {
        global $arrAvatares;

        if (isset($arrAvatares[$id])) {
            return $arrAvatares[$id];
        } else {
            $arrAvatares[$id] = getRandAvatarURL($id);
            return $arrAvatares[$id];
        }
    }