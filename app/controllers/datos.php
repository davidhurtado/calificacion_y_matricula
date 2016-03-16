<?php

if (!$G->user->isLogged()) {
    redirectTo($G->config["w_url"]);
} else {
    switch ($G->user->data->u_tipo) {
        case 1://Admin
            $G->contenido = 'admin/home_admin.phtml';
            $G->menu_principal = "admin/menu_admin.phtml";
            break;
        case 3://Secretaria
            $G->contenido = 'secretaria/home_secret.phtml';
            $G->menu_principal = "secretaria/menu_secret.phtml";
            break;
        case 5://Profesor(a)
            $G->contenido = 'profesor/home_profe.phtml';
            $G->menu_principal = "profesor/menu_profe.phtml";
            break;
        case 7://Alumnos , Padres de Familia
            $G->contenido = 'alumno/home_alum.phtml';
            $G->menu_principal = "alumno/menu_alum.phtml";
            break;
    }
}