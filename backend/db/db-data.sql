-- dumping data for table `coaches`
INSERT INTO `coaches` (`name`) VALUES
('Martin'),
('Simone'),
('Pierre');

-- dumping data for table `locations`
INSERT INTO `locations` (`name`, `logo`) VALUES
('Extérieur', 'ressources/images/exterieur.png'),
('Intérieur', 'ressources/images/interieur.png');

-- dumping data for table `coaches`
INSERT INTO `levels` (`name`) VALUES
('Expert'),
('Intermédiaire'),
('Débutant'),
('Tous les niveaux');

-- dumping data for table `activities` with updated foreign keys
INSERT INTO `activities` (`id`, `name`, `description`, `image`, `level_id`, `coach_id`, `schedule_day`, `schedule_time`, `location_id`) VALUES
(1, 'Football', 'Apprends les bases du soccer tout en t’amusant: dribbles, passes et tirs, dans un esprit d’équipe!', './resources/images/football.png', 'Expert', 1, 'Samedi', '15h-18h', 1),
(2, 'Natation', 'Nagez à votre rythme, détendez-vous, et profitez d’une ambiance apaisante!', './resources/images/natation.png', 'Tous les niveaux', 2, 'Lundi', '19h - 21h', 2),
(3, 'Tennis', 'Jouez à votre rythme, perfectionnez votre style, et profitez de matchs conviviaux.', './resources/images/tennis.jpg', 'Tous les niveaux', 2, 'Mardi', '10h - 14h', 2),
(4, 'Volley', 'Jouez sans pression, amusez-vous entre amis, et ressentez l\'énergie du jeu.', './resources/images/volley.png', 'Tous les niveaux', 3, 'Mercredi', '15h-17h', 2),
(5, 'Basket', 'Jouez sans pression, exprimez votre style, et partagez des moments fun avec une communauté passionnée.', './resources/images/basket.png', 'Tous les niveaux', 1, 'Dimanche', '18h - 19h30', 2);

-- dumping data for table `users`
INSERT INTO `users` (`first_name`, `last_name`, `username`, `password`) 
VALUES ('Test', 'User', 'testuser', '$2y$10$E6Y0YWY2NzMwMDEzMjZidHOplRl25gNcBznF1XZgdcdkaFUYOpim');
