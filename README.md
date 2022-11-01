# Product Order

C'est une version de **Product Order** en PHP.

## BDD

Script pour recréer la base de données :

```sql
--
-- Base de données : `productorder`
--

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(60) NOT NULL,
  `register_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `register_date`) VALUES
(2, 'Petit', 'NOUNOURS', 'petit.nounours@gmail.com', '$2y$10$4q6QgY0fkIeD2xAf0IDHM.XW0m5smtjJ7kRgKX02xaxYMn6LZwfRO', '2022-10-23 14:53:35');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;

--
-- Structure de la table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reference` varchar(10) NOT NULL,
  `designation` varchar(50) NOT NULL,
  `unit_price` float NOT NULL,
  `rate` float NOT NULL,
  `add_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `delete_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `user_id`, `reference`, `designation`, `unit_price`, `rate`, `add_date`, `update_date`, `deleted`, `delete_date`) VALUES
(1, 2, 'XKCR845', 'Livre sur Elon Musk', 8.99, 5.5, '2022-10-31 02:59:26', '2022-11-01 18:51:58', 0, '0000-00-00 00:00:00'),
(2, 2, 'KBTR124', 'I phone 14', 1699, 20, '2022-10-31 03:44:36', '2022-11-01 18:47:00', 0, '0000-00-00 00:00:00'),
(3, 2, 'AIUJ748', 'Croquettes pour nounours', 42.99, 5.5, '2022-11-01 15:52:01', '2022-11-01 18:44:04', 1, '2022-11-01 18:46:00'),
(4, 2, 'KBTR125', 'I phone 14 PRO', 1899, 20, '2022-11-01 18:51:32', '2022-11-01 18:51:32', 0, '0000-00-00 00:00:00');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `code` varchar(10) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_HT` float NOT NULL,
  `total_TTC` float NOT NULL,
  `add_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `delete_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

--
-- Structure de la table `order_lines`
--

CREATE TABLE `order_lines` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `reference` varchar(10) NOT NULL,
  `designation` varchar(50) NOT NULL,
  `unit_price` float NOT NULL,
  `rate` float NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_HT` float NOT NULL,
  `total_TTC` float NOT NULL,
  `add_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `delete_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `order_lines`
--
ALTER TABLE `order_lines`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `order_lines`
--
ALTER TABLE `order_lines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;
```
