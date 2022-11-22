<?php
    /**
     * Coge el avatar guardado en array, o si no existe, lo genera y lo guarda
     */
    function getAvatar($id) {
        // El 8 es porque no me gustaban los iconos normales
        srand($id * 8);

        // Devolver el string
        return 'https://avatars.dicebear.com/api/adventurer-neutral/' . rand() . '.svg';
    }