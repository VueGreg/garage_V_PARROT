USE v_parrot;

CREATE TABLE `energies` (
  `id` int(11) NOT NULL PRIMARY KEY ,
  `nom` varchar(255) NOT NULL
) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;

INSERT INTO `energies` (`id`, `nom`) VALUES
(1, 'Air comprimé'),
(2, 'Essence électricité (hybride rechargeable)'),
(3, 'Bicarburation essence-GPL'),
(4, 'Essence-électricité (hybride non rechargeable)'),
(5, 'Electricité'),
(6, 'Bicarburation essence-gaz naturel et électricité (hybride rechargeable)'),
(7, 'Bicarburation essence-gaz naturel'),
(8, 'Bicarburation essence-gaz naturel et électricité (hybride non rechargeable)'),
(9, 'Bicarburation essence-GPL et électricité (hybride non rechargeable)'),
(10, 'Bicarburation essence-GPL et électricité (hybride rechargeable)'),
(11, 'Essence'),
(12, 'Ethanol'),
(13, 'Superéthanol'),
(14, 'Bicarburation superéthanol-GPL'),
(15, 'Superéthanol-électricité (hybride rechargeable)'),
(16, 'Bicarburation superéthanol-gaz naturel'),
(17, 'Gazogène'),
(18, 'Mélange gazogène-essence'),
(19, 'Mélange de gazole et gaz naturel (dual fuel)'),
(20, 'Mélange gazogène-gazole'),
(21, 'Gazole-électricité (hybride non rechargeable)'),
(22, 'Gazole-électricité (hybride rechargeable)'),
(23, 'Mélange de gazole et gaz naturel (dual fuel) et électricité (hybride rechargeable)'),
(24, 'Gaz naturel'),
(25, 'Diesel'),
(26, 'Gaz de pétrole liquéfié GPL'),
(27, 'Mélange de gazole et gaz naturel (dual fuel) et électricité (hybride non rechargeable)'),
(28, 'Autres hydrocarbures gazeux comprimés'),
(29, 'Hydrogène'),
(30, 'Gaz naturel-électricité (hybride rechargeable)'),
(31, 'Gaz naturel-électricité (hybride non rechargeable)'),
(32, 'Monocarburation GPL-électricité (hybride rechargeable)'),
(33, 'Monocarburation GPL-électricité (hybride non rechargeable)'),
(34, 'Pétrole lampant');