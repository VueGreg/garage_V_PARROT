USE v_parrot;

CREATE TABLE `temoignages` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  `date` DATE NOT NULL,
  `nom` VARCHAR(50) NOT NULL,
  `prenom` VARCHAR(50) NOT NULL,
  `commentaire` TEXT NOT NULL,
  `note` TINYINT NOT NULL,
  `etat` BOOLEAN NOT NULL
) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;

INSERT INTO `temoignages` (`id`, `date`, `nom`, `prenom`, `commentaire`, `note`, `id_image`) 
VALUES 
    (NULL, '2023-10-04', 'De la Fontaine', 'Jean', 'Très bon garage, je recommande les yeux fermé', '5', 1),
    (NULL, '2023-09-26', 'Dupont', 'Georges', 'Très professionnel...cherche à faire le meilleur prix avec des pièces compatibles Toujours bien reçu Je recommande ce garage ', '5', 1),
    (NULL, '2023-08-12', 'Tapis', 'Bernard', 'Tres bon accueil, Travail consciencieux, dans les délais... vraiment très agréable ', '5', 1);