USE v_parrot;

CREATE TABLE `messages` ( 
    `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    `nom` VARCHAR(50) NOT NULL , 
    `prenom` VARCHAR(50) NOT NULL , 
    `num_telephone` VARCHAR(10) NOT NULL , 
    `mail` VARCHAR(100) NOT NULL ,
    `date`DATETIME NOT NULL ,
    `text` TEXT NOT NULL ,
    `status`BOOLEAN NOT NULL ,
    `num_annonce` INT(11) NULL
) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci; 

ALTER TABLE `messages` 
ADD CONSTRAINT `annonce` FOREIGN KEY (`num_annonce`) REFERENCES `annonces`(`numero_annonce`) ON DELETE RESTRICT ON UPDATE RESTRICT; 