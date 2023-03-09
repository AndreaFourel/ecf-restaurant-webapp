INSERT INTO
    daily_schedule (id, opening_time, closing_time)
VALUES
    (1, '12:00:00', '15:00:00'),
    (2, '19:00:00', '22:00:00'),
    (3, '19:00:00', '23:00:00');

INSERT INTO
    image_gallery (id, title, file_name)
VALUES
    (1, 'La raviole de bœuf du chef', 'yoav-aziz-EGRJe6BHG9I-unsplash.jpg'),
    (2, 'plat1', 'adam-bartoszewicz-vdkyWisomns-unsplash.jpg'),
    (3, 'plat2', 'christian-hogue-wvdc2osHNTA-unsplash.jpg'),
    (4, 'plat3', 'christian-hogue-rOgthmj3RLY-unsplash.jpg'),
    (5, 'plat4', 'viktor-zhulin-wa3rAOia8F4-unsplash.jpg');

INSERT INTO
    meal (id, meal_category_id, title, description, price)
VALUES
    (1, 1, 'Raviole de bœuf', 'Raviole de bœuf braisé, crémeux de potimarron, noisettes et émulsion parmesan.', 19.00),
    (2, 2, 'La Noix', 'Noix de Saint-Jacques snackées.', 26.00),
    (3, 3, 'Le Porc', 'Paleron de veau cuit 36h, légumes racines au beurre de truffes, bouillon de pot-au-feu.', 24.00),
    (4, 1, 'Le Velouté', 'Velouté de topinambours et œuf parfait, feuilleté aux champignons et chorizo.', 16.00),
    (5, 4, 'L\'Agrume', 'Tartelette au citron, ganache pistache, agrumes, sorbet calamansi.', 9.00);

INSERT INTO
    meal_category (id, title)
VALUES
    (1, 'Entrées'),
    (2, 'Poissons'),
    (3, 'Viandes'),
    (4, 'Desserts');

INSERT INTO
    settings (id, item, description, value)
VALUES
    (1, 'Téléphone', 'Coordonnées téléphoniques', '00 00 00 00 00'),
    (2, 'Adresse', 'Adresse postale', '1 Impasse des Fossés, 33210 Au Fond D\'un Trou'),
    (3, 'Capacité maximale', 'Nombre de convives maximum', '30'),
    (4, 'E-mail', 'Adresse mail', 'admin@myrestaurant.com');

INSERT INTO
    user (id, email, roles, password, first_name, allergy_list, created_at, guest_quantity)
VALUES
    (1, 'admin1@mail.com', '[\"ROLE_USER\",\"ROLE_ADMIN\",\"ROLE_SUPER_ADMIN\"]', '$2y$13$pLTCeC8gfq1z1RFg.O8hd.T7uWw5n0vxbuqh/mrvsw0YXmvk.6P9.', 'john', 'lait', '2023-02-04 10:39:38', 4);

INSERT INTO
    week_day (id, title, open)
VALUES
    (1, 'Lundi', 0),
    (2, 'Mardi', 1),
    (3, 'Mercredi', 1),
    (4, 'Jeudi', 1),
    (5, 'Vendredi', 1),
    (6, 'Samedi', 1),
    (7, 'Dimanche', 1);

INSERT INTO
    week_day_daily_schedule (week_day_id, daily_schedule_id)
VALUES
   (2, 1),
   (3, 1),
   (4, 1),
   (4, 2),
   (5, 1),
   (5, 3),
   (6, 1),
   (6, 3),
   (7, 1);
