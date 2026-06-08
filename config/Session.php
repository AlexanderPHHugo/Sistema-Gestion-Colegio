<?php

function iniciarSesionSegura()
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }

    session_set_cookie_params([
        "lifetime" => 0,
        "path" => "/",
        "secure" => isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] === "on",
        "httponly" => true,
        "samesite" => "Lax",
    ]);

    session_start();
}

function usuarioAutenticado()
{
    return isset($_SESSION["usuario"]);
}

function protegerRuta()
{
    if (!usuarioAutenticado()) {
        header("Location: index.php?accion=login");
        exit;
    }
}