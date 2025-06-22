<?php

require_once __DIR__."/../services/core/controller.service.php";

register_controller("GET", "/", function() {
    redirect("/pages/accueil.php");
});
