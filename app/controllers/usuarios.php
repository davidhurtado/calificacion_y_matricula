<?php

/**
 * Created by PhpStorm.
 * User: PC90
 * Date: 04/12/2015
 * Time: 11:06
 */
if (!$G->user->isLogged()) {
    redirectTo("login");
} else {
    if ($G->user->data->u_tipo == 1) {
        $G->error = "ok";
        $G->act = isset($_GET["act"]) ? trim($_GET["act"]) : "lista";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            function getDatos() {

            }

            if (!empty($_POST["action"])) {
                if ($_POST["action"]=='agregar') {
                $nombres = !empty($_POST["nombres"]) ? trim($_POST["nombres"]) : ($G->error .= "Falta nombres.<br/>");
                $apellidos = !empty($_POST["apellidos"]) ? trim($_POST["apellidos"]) : ($G->error .= "Falta apellidos.<br/>");
                $nick = !empty($_POST["nick"]) ? trim($_POST["nick"]) : ($G->error .= "Falta nick.<br/>");
                $password = !empty($_POST["pass"]) ? trim($_POST["pass"]) : ($G->error .= "Falta password.<br/>");
                $tipo = !empty($_POST["tipo"]) ? trim($_POST["tipo"]) : 7;
                $rol = !empty($_POST["rol"]) ? trim($_POST["rol"]) : 'Sin rol';
                    $queryExiste = $G->db->prepare("SELECT * FROM " . DB_PREFIX . "usuarios WHERE u_nick='" . $nick . "'");
                    $queryExiste->execute();

                    //Existen registros?
                    if ($queryExiste->rowCount()) {
                        $G->error = 'Ya existe ese usuario';
                    } else {
                        $G->usuarios = null;
                    }

                    if ($G->error == "ok") {
                        $password_hashed = hash("sha256", $password);
                        $insert_query = $G->db->prepare("INSERT INTO " . DB_PREFIX . "usuarios (u_nombres, u_apellidos, u_nick, u_password, u_tipo, u_rol)
            VALUES (?, ?, ?, ?,?,?)");

                        $insert_query->execute(
                                array($nombres, $apellidos, $nick, $password_hashed, $tipo, $rol)
                        );
                    }
                }
            }
            if ($G->act == 'eliminar') {
                if (!empty($_POST["id"]) && $_POST["accion"] == 'eliminar') {
                    $uid = $_POST["id"];
                    $query = $G->db->prepare("DELETE FROM " . DB_PREFIX . "usuarios WHERE u_id=" . $uid);
                    $query->execute();
                    echo '1';
                    die();
                }
                //redirectTo("lista");
            }
            if ($G->act == 'editando') {
                if (!empty($_POST["nick"])) {
                                     $nombres = !empty($_POST["nombres"]) ? trim($_POST["nombres"]) : ($G->error .= "Falta nombres.<br/>");
                $apellidos = !empty($_POST["apellidos"]) ? trim($_POST["apellidos"]) : ($G->error .= "Falta apellidos.<br/>");
                $nick = !empty($_POST["nick"]) ? trim($_POST["nick"]) : ($G->error .= "Falta nick.<br/>");
                $password = !empty($_POST["pass"]) ? trim($_POST["pass"]) : ($G->error .= "Falta password.<br/>");
                $tipo = !empty($_POST["tipo"]) ? trim($_POST["tipo"]) : 7;
                $rol = !empty($_POST["rol"]) ? trim($_POST["rol"]) : 'Sin rol';
                    $uid = $_POST["id"];
                    $query = $G->db->prepare("UPDATE FROM " . DB_PREFIX . "usuarios set u_nombres=$nombres, u_apellidos=$apellidos, u_nick=$nick, u_password=$password_hashed, u_tipo=$tipo, u_rol=$rol  WHERE u_id=" . $uid);
                    $query->execute();
                }
                redirectTo("usuarios");
            }
        }
        $G->contenido = 'admin/usuarios.phtml';
//Cargar los registros -->
        $queryUs = $G->db->prepare("SELECT * FROM " . DB_PREFIX . "usuarios ORDER BY u_id ASC");

        $queryUs->execute();

//Existen registros?
        if ($queryUs->rowCount()) {
            $G->usuarios = $queryUs->fetchAll();
        } else {
            $G->usuarios = null;
        }
        loadView('home.phtml');
    } else {
        redirectTo($G->config["w_url"] . DS . 'logout');
    }
} 