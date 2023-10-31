USE v_parrot;

CREATE TABLE `permissions` ( 
    `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    `type` VARCHAR(50) NOT NULL , 
    `rang` INT(5) NOT NULL,
) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci; 

INSERT INTO permissions (`id`, `nom`, `rang`) 
VALUES
    (NULL, 'admin', '1'),
    (NULL, 'modérateur', '2'),
    (NULL, 'salarié', '3');