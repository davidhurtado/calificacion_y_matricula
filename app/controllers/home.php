<?php

if ($G->user->isLogged()) {
    $G->controller = 'home';
    loadView('home.phtml');
} else {
    redirectTo("login");
}
