USE v_parrot;

CREATE TABLE `reparations` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  `categorie` VARCHAR(255) NOT NULL,
  `description` TEXT NOT NULL
) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;

INSERT INTO `reparations` (`id`, `categorie`, `description`) 
VALUES
    -- Climatisation
    (NULL, 'Climatisation', 'Recherche et détection de fuite'),
    (NULL, 'Climatisation', 'Traitement des micro-fuites'),
    (NULL, 'Climatisation', 'Remplacement de la bouteille filtrante'),
    (NULL, 'Climatisation', 'Montage condenseur, compresseur, canalisation, détendeur, orifice calibré'),
    (NULL, 'Climatisation', 'Réparation canalisation'),
    (NULL, 'Climatisation', 'Contrôle fonctionnement climatisation'),
    (NULL, 'Climatisation', 'Nettoyage du circuit technique'),
    (NULL, 'Climatisation', 'Recharge en gaz'),
    (NULL, 'Climatisation', 'Traitement désinfectant et anti-bactérien'),
    (NULL, 'Climatisation', 'Filtre habitacle'),
    -- Freinage
    (NULL, 'Freinage', 'Diagnostic complet du système de freinage'),
    (NULL, 'Freinage', 'Purge et remplacement du liquide de frein (liquide de frein inclus)'),
    (NULL, 'Freinage', "Réglage du frein à main sur véhicules équipés de disques à l'arrière"),
    (NULL, 'Freinage', "Réglage du frein à main pour véhicule avec tambours à l'arrière"),
    (NULL, 'Freinage', "Montage du kit de frein tambour + purge + réglage frein à main (kit vendu séparément)"),
    --Eclairage
    (NULL, 'Eclairage', "Remplacement avant d'une ou plusieurs ampoules sur un même phare (ampoules vendues séparément)"),
    (NULL, 'Eclairage', "Remplacement arrière d'une ou plusieurs ampoules sur un même phare (ampoules vendues séparément)"),
    (NULL, 'Eclairage', "Montage 2 ampoules avant LED homologuées"),
    (NULL, 'Eclairage', "Remplacement d'une ou plusieurs ampoules Xénon sur le même phare (ampoules vendues séparément)"),
    (NULL, 'Eclairage', "Réglage des phares du véhicule (hors technologie Xénon)"),
    (NULL, 'Eclairage', "Réglage des phares antibrouillard avant"),
    (NULL, 'Eclairage', "Rénovation des optiques de phare"),
    --Batterie, démarrage
    (NULL, 'Batterie, démarrage', "Montage batterie dans nos ateliers (pièces non incluses)"),
    (NULL, 'Batterie, démarrage', "Montage bougies d'allumage (pièces non incluses)"),
    (NULL, 'Batterie, démarrage', "Montage de la bobine d'allumage"),
    (NULL, 'Batterie, démarrage', "Montage démarreur (pièces non incluses)"),
    --Echappement
    (NULL, 'Echappement', "Diagnostic électronique voyants tableau de bord (lecture + interprétation)"),
    (NULL, 'Echappement', "Lecture électronique des codes défauts"),
    (NULL, 'Echappement', "Diagnostic EcoContrôle + lecture électronique pour véhicule DIESEL"),
    (NULL, 'Echappement', "Pack Eco-Traitement antipollution DIESEL (inclus Diagnostic + Traitement)"),
    (NULL, 'Echappement', "Nettoyage préventif du système d'injection diesel (additif inclus)"),
    (NULL, 'Echappement', "Diagnostic échappement"),
    (NULL, 'Echappement', "Diagnostic EcoContrôle + lecture électronique pour véhicule ESSENCE ou GPL"),
    (NULL, 'Echappement', "Nettoyage curatif du système d'injection diesel (additif inclus)"),
    (NULL, 'Echappement', "Montage de l'échappement intermédiaire"),
    (NULL, 'Echappement', "Montage du silencieux arrière"),
    (NULL, 'Echappement', "Montage de la ligne complète de l'échappement sauf sortie collecteur"),
    (NULL, 'Echappement', "Montage du catalyseur"),
    (NULL, 'Echappement', "Montage turbocompresseur (pièces non incluse)"),
    --Distribution
    (NULL, 'Distribution', "Remplacement du kit distribution + Pompe à eau"),
    (NULL, 'Distribution', "Remplacement courroie d'accessoires"),
    (NULL, 'Distribution', "Remplacement du liquide de refroidissement"),
    (NULL, 'Distribution', "Contrôle du système d’injection"),
    (NULL, 'Distribution', "Contrôle du circuit d’admission d’air"),
    --Direction
    (NULL, 'Direction', "Forfait amortisseurs pièces incluses : Montage + 2 Amortisseurs avant MONROE + Coupelles + Géométrie"),
    (NULL, 'Direction', "Forfait amortisseurs pièces incluses : Montage + 2 Amortisseurs arrière MONROE + Coupelles"),
    (NULL, 'Direction', "Contrôle de la géométrie des trains roulants avant et arrière (réglage non inclus)"),
    (NULL, 'Direction', "Montage des triangle de suspension (pièces non incluses)"),
    (NULL, 'Direction', "Montage rotule de direction extérieure (pièces non incluses)"),
    (NULL, 'Direction', "Montage amortisseurs (pièces non incluses)"),
    --Motorisation
    (NULL, 'Motorisation', "Lecture électronique moteur"),
    (NULL, 'Motorisation', "Montage vanne EGR (pièces non incluses)"),
    (NULL, 'Motorisation', "Montage du débitmètre"),
    --Transmission
    (NULL, 'Transmission', "Montage embrayage (Pièces non incluses)"),
    (NULL, 'Transmission', "Montage du soufflet de transmission");