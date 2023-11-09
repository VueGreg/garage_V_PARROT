USE v_parrot;

CREATE TABLE `galeries` ( 
    `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
    `id_images` INT(11) NOT NULL , 
    `id_annonces` INT(11) NOT NULL 
) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci; 

ALTER TABLE `galeries`
ADD CONSTRAINT `images` FOREIGN KEY (`id_images`) REFERENCES `images`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT; 
ALTER TABLE `galeries`
ADD CONSTRAINT `references` FOREIGN KEY (`id_annonces`) REFERENCES `annonces`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;

INSERT INTO galeries (`id`, `id_images`, `id_annonces`) 
VALUES 
    (NULL, '1', '2'),
    (NULL, '2', '2'),
    (NULL, '3', '2'),
    (NULL, '4', '2'),
    (NULL, '5', '2'),
    (NULL, '6', '3'),
    (NULL, '7', '3'),
    (NULL, '8', '3'),
    (NULL, '9', '3'),
    (NULL, '10', '3'),
    (NULL, '11', '4'),
    (NULL, '12', '4'),
    (NULL, '13', '4'),
    (NULL, '14', '4'),
    (NULL, '15', '4'),
    (NULL, '16', '5'),
    (NULL, '17', '5'),
    (NULL, '18', '5'),
    (NULL, '19', '5'),
    (NULL, '20', '5'),
    (NULL, '21', '6'),
    (NULL, '22', '6'),
    (NULL, '23', '6'),
    (NULL, '24', '6'),
    (NULL, '25', '6'),
    (NULL, '26', '7'),
    (NULL, '27', '7'),
    (NULL, '28', '7'),
    (NULL, '29', '7'),
    (NULL, '30', '7'),
    (NULL, '31', '8'),
    (NULL, '32', '8'),
    (NULL, '33', '8'),
    (NULL, '34', '8'),
    (NULL, '35', '8'),
    (NULL, '36', '9'),
    (NULL, '37', '9'),
    (NULL, '38', '9'),
    (NULL, '39', '9'),
    (NULL, '40', '9'),
    (NULL, '41', '1'),
    (NULL, '42', '1'),
    (NULL, '43', '1'),
    (NULL, '44', '1'),
    (NULL, '45', '1'),
    (NULL, '46', '10'),
    (NULL, '47', '10'),
    (NULL, '48', '10'),
    (NULL, '49', '10'),
    (NULL, '50', '10');