USE v_parrot;

CREATE TABLE `annonces` ( 
    `numero_annonce` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY , 
    `id_vehicules` INT(11) NOT NULL , 
    `id_energies` INT(11) NOT NULL , 
    `prix` DECIMAL(10,2) NOT NULL , 
    `kilometrage` INT(7) NOT NULL , 
    `annee` INT(4) NOT NULL , 
    `puissance` INT(4) NOT NULL , 
    `boite_vitesse` VARCHAR(255) NOT NULL , 
    `motorisation` VARCHAR(255) NOT NULL , 
    `finition` VARCHAR(255) NOT NULL,
    `status` BOOLEAN NOT NULL

) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;

ALTER TABLE `annonces`
ADD CONSTRAINT `energies` FOREIGN KEY (`id_energies`) REFERENCES `energies`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT; 
ALTER TABLE `annonces`
ADD CONSTRAINT `vehicules` FOREIGN KEY (`id_vehicules`) REFERENCES `vehicules`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT; 

INSERT INTO annonces (`numero_annonce`, `id_vehicules`, `id_energies`, `prix`, `kilometrage`, `annee`, `puissance`, `boite_vitesse`, `motorisation`, `finition`, `status`) 
VALUES 
    (NULL, '1113', '2', '26455', '67000', '2020', '180', 'Boite automatique', '508 Hybrid 225 e-EAT8', 'Allure Pack', 0),
    (NULL, '80', '25', '22749', '84200', '2016', '184', 'Boite séquentielle', 'Q3 2.0 TDI 184ch S-tronic 7 Quattro', 'S-line', 0),
    (NULL, '147', '25', '20099', '152900', '2016', '190', 'Boite automatique', '320d 190ch', 'Luxury A', 0),
    (NULL, '299', '11', '11249', '141100', '2016', '130', 'Boite manuelle', 'C4 Picasso PureTech 130 S&S', 'Intensive', 0),
    (NULL, '605', '5', '31099', '21000', '2021', '204', 'Automatique à fonction continu', 'Kona Electrique 64kWh-204ch', 'Executive', 0),
    (NULL, '746', '25', '23399', '120300', '2016', '150', 'Boite automatique', 'Discovery Sport Mark II TD4 150ch', 'Business A', 0),
    (NULL, '884', '25', '10490', '107500', '2010', '136', 'Boite automatique', 'Classe C 200 CDI BlueEfficiency', 'Avantgarde Euro VA', 0),
    (NULL, '944', '11', '27390', '8600', '2020', '136', 'Boite automatique', 'Hatch 5 Portes Cooper 136ch BVA7', 'Finition Business Design', 0),
    (NULL, '1099', '25', '9790', '127200', '2015', '120', 'Boite automatique', '308 SW 1.6 BlueHDI 120ch S&S EAT6', 'Business Pack', 0),
    (NULL, '1539', '11', '10590', '150500', '2014', '105', 'Boite manuelle', 'Golf 1.2 TSI 105 BlueMotion Technologie', 'Trendline', 0);