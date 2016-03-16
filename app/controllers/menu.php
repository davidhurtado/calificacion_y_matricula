<?php

/**
 * Created by PhpStorm.
 * User: PC90
 * Date: 04/12/2015
 * Time: 9:32
 */
if (!$G->user->isLogged()) {
    redirectTo("login");
} else {
   if ($G->user->data->u_tipo == 1) {
        $G->contenido = "admin/principal.phtml";
    } else
    if ($G->user->data->u_tipo == 3) {
        $G->contenido = "participante/principal.phtml";
    }
    loadView('menu.phtml');
}