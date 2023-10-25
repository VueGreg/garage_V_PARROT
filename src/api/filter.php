<?php

require_once './function.php';
require_once './connection.php';



        $sql_marques = "SELECT DISTINCT vehicules.marque AS marque 
                        FROM annonces
                        INNER JOIN vehicules ON annonces.id_vehicules = vehicules.id";
        
        $sql_modeles = "SELECT DISTINCT vehicules.modele AS modele
                        FROM annonces
                        INNER JOIN vehicules ON annonces.id_vehicules = vehicules.id";
        
        $sql_annees_min =   "SELECT DISTINCT MIN(annee) FROM annonces";
        $sql_annees_max =   "SELECT DISTINCT MAX(annee) FROM annonces";


        $marques = simple_fetch_data($sql_marques);
        $modele = simple_fetch_data($sql_modeles);
        $annee_min = simple_fetch_data($sql_annees_min);
        $annee_max = simple_fetch_data($sql_annees_max);

        $result["marque"] = $marques;
        $result["modele"] = $modele;
        $result["annee_min"] = $annee_min;
        $result["annee_max"] = $annee_max;

    
return_json(true, "200", $result);
