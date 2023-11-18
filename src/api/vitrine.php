<?php

require_once './function.php';
require_once './connection.php';


        //-----Images Sites
        $sql_images = "SELECT * FROM images WHERE id > 50";
        $images = simple_fetch_data($sql_images);

        //-----Réparations
        $sql_reparation = "SELECT * FROM reparations";
        $reparations = simple_fetch_data($sql_reparation);

        //------Categorie Réparations
        $sql_cat_reparation = "SELECT DISTINCT categorie FROM reparations";
        $cat_reparations = simple_fetch_data($sql_cat_reparation);

        //-----Horaires
        $sql_horaires = "SELECT * FROM horaires";
        $horaires = simple_fetch_data($sql_horaires);

        for ($i=0; $i < count($horaires); $i++) { 
                foreach ($horaires[$i] as $key => $value) {
                        if ($key == 'h_debut') {
                                $arrayheure = explode(':', $value);
                                $newheure = $arrayheure[0].'h'.$arrayheure[1];
                                $horaires[$i]['h_debut'] = $newheure;
                        }
                        elseif ($key == 'h_fin') {
                                $arrayheure = explode(':', $value);
                                $newheure = $arrayheure[0].'h'.$arrayheure[1];
                                $horaires[$i]['h_fin'] = $newheure;
                        }
                }
                $horaires[$i]['list'] = array();
                for ($j=1; $j < 24; $j++) { 
                        array_push($horaires[$i]['list'], $j.'h00');
                        array_push($horaires[$i]['list'], $j.'h30');
                }
                
        }


        //-----informations entreprise
        $sql_infos = "SELECT * FROM entreprise";
        $informations = simple_fetch_data($sql_infos);

        //-----Témoignages
        $sql_temoignages = "SELECT * FROM temoignages";
        $temoignages = simple_fetch_data($sql_temoignages);

        //-----Nombres de véhicules
        $sql_annonces = "SELECT * FROM annonces WHERE status = '0'";
        $annonces = simple_fetch_data($sql_annonces);
        $countAnnonces = count($annonces);


        $result["reparations"] = $reparations;
        $result["horaires"] = $horaires;
        $result["informations"] = $informations;
        $result["temoignages"] = $temoignages;
        $result["images"] = $images;
        $result["categorie_reparations"] = $cat_reparations;
        $result["nombre_vehicules"] = $countAnnonces;

        return_json(true, "200", $result);