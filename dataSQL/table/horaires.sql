USE v_parrot;

CREATE TABLE `horaires` ( 
    `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY , 
    `jour_semaine`VARCHAR(10) NOT NULL ,
    `h_debut` TIME NOT NULL , 
    `h_fin` TIME NOT NULL
) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci; 

INSERT INTO `horaires` (`id`, `jour_semaine`, `h_debut`, `h_fin`) 
VALUES
    (NULL, 'Lundi', '08:00:00', '18:00:00'),
    (NULL, 'Mardi', '08:00:00', '12:00:00'),
    (NULL, 'Mercredi', '08:00:00', '12:00:00'),
    (NULL, 'Jeudi', '08:00:00', '12:00:00'),
    (NULL, 'Vendredi', '08:00:00', '12:00:00'),
    (NULL, 'Samedi', '08:00:00', '12:00:00'),
    (NULL, 'Dimanche', '08:00:00', '12:00:00');