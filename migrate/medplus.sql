CREATE TABLE `motivi` (
  `id` int NOT NULL,
  `motivo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `motivi` (`id`, `motivo`) VALUES
(1, 'Vuoto'),
(2, 'Pranzo'),
(3, 'Corso');

ALTER TABLE `motivi`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `motivi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;