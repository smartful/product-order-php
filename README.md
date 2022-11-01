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
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reference` varchar(10) NOT NULL,
  `designation` varchar(50) NOT NULL,
  `unit_price` float NOT NULL,
  `rate` float NOT NULL,
  `add_date` datetime NOT NULL,
  `update_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `user_id`, `reference`, `designation`, `unit_price`, `rate`, `add_date`, `update_date`) VALUES
(1, 2, 'XKCR845', 'Livre sur Elon Musk', 8.55, 5.5, '2022-10-31 02:59:26', '2022-10-31 02:59:26'),
(2, 2, 'KBTR124', 'I phone 14', 1899, 20, '2022-10-31 03:44:36', '2022-11-01 10:53:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;
```
