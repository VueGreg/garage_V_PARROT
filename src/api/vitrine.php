<?php

require_once './function.php';
require_once './connection.php';


        //-----Images Sites
        $sql_images = "SELECT * FROM images WHERE id > 50";
        $images = simple_fetch_data($sql_images);

        //-----Réparations
        $sql_reparation = "SELECT * FROM reparations";
        $reparations = simple_fetch_data($sql_reparation);

        //-----Horaires
        $sql_horaires = "SELECT * FROM horaires";
        $horaires = simple_fetch_data($sql_horaires);

        //-----informations entreprise
        $sql_infos = "SELECT * FROM entreprise";
        $informations = simple_fetch_data($sql_infos);

        //-----Témoignages
        $sql_temoignages = "SELECT * FROM temoignages";
        $temoignages = simple_fetch_data($sql_temoignages);


        $result["reparations"] = $reparations;
        $result["horaires"] = $horaires;
        $result["informations"] = $informations;
        $result["temoignages"] = $temoignages;
        $result["images"] = $images;

        return_json(true, "200", $result);