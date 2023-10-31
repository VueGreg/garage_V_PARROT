USE v_parrot;

CREATE TABLE `utilisateurs` ( 
    `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    `nom` VARCHAR(50) NOT NULL , 
    `prenom` VARCHAR(50) NOT NULL , 
    `mdp` VARCHAR(32) NOT NULL , 
    `mail` VARCHAR(100) NOT NULL ,
    `token` TEXT (64) NOT NULL,
    `id_permissions` INT(11) NOT NULL
) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci; 

ALTER TABLE `utilisateurs` 
ADD CONSTRAINT `permissions` FOREIGN KEY (`id_permissions`) REFERENCES `permissions`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT; 

INSERT INTO utilisateurs (`id`, `nom`, `prenom`,`mdp`,`mail`,`token`,`id_permissions`) 
VALUES
    (NULL, 'Vincent', 'PARROT', 'MotDePasse', 'v.parrot@gmail.com','hEPzuMbT2DbQpXuZxlI2cUrLsJxa84UseI7G4QliB5efq8oZD4SxG4fuaLZXuHuf','1'),
    (NULL, 'John', 'DOE', 'MotDePasse', 'j.doe@gmail.com', 'l5kcV4KVLIw6Pp5ycFl1Tik2DDrtJUUcqSqZBRjFz2hoQ4xPuIqYJCKvvU5VfbWo', '2'),
    (NULL, 'Stephane', 'KING', 'MotDePasse', 's.king@gmail.com', 'maxGAFfY7qb1mq4Xd35rMgok7q0CPaWGdzlDmXrFpfv2vDmsZ56kkyMJreE9FFDe', '3');