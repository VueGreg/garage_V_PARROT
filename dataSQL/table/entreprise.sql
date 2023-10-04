USE v_parrot;

CREATE TABLE `entreprise` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `adresse` VARCHAR(255) NOT NULL,
  `code_postal` INT(5) NOT NULL,
  `ville` VARCHAR(255) NOT NULL,
  `num_telephone` INT(10) NOT NULL,
  `mail` VARCHAR (100) NOT NULL,
  `adresse_logo` VARCHAR(255) NOT NULL,
  `facebook` VARCHAR(255) NOT NULL,
  `twitter` VARCHAR(255) NOT NULL,
  `linkedin` VARCHAR(255) NOT NULL,
  `instagram` VARCHAR(255) NOT NULL
) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;

INSERT INTO `entreprise` (`id`, `adresse`, `code_postal`, `ville`, `num_telephone`, `mail`, `adresse_logo`, `facebook`, `twitter`, `linkedin`, `instagram`) 
VALUES
    (NULL, 
    '13, rue des réparations', 
    '57100', 
    'THIONVILLE',
    '0382456987', 
    'garagev.parrot@gmail.com',
    'http://gregory-wolff.com/images/wepik-geometric-gradient-brandname-logo-20230927155932MPVN.png',
    '#',
    '#',
    '#',
    '#');