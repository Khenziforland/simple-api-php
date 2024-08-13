CREATE TABLE `product_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);

INSERT INTO
  `product_categories` (`id`, `name`)
VALUES
  (1, 'Technology'),
  (2, 'Gaming'),
  (3, 'Auto'),
  (4, 'Entertainment'),
  (5, 'Books');

CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10, 2) NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`product_category_id`) REFERENCES `product_categories` (`id`)
);

INSERT INTO
  `products` (
    `id`,
    `product_category_id`,
    `name`,
    `description`,
    `price`,
    `file`
  )
VALUES
  (
    1,
    1,
    'Laptop',
    'Deskripsi Laptop',
    10000000,
    '../../assets/image/default.png'
  ),
  (
    2,
    2,
    'TV',
    'Deskripsi TV',
    500000,
    '../../assets/image/default.png'
  ),
  (
    3,
    1,
    'Smartphone',
    'Deskripsi Smartphone',
    2000000,
    '../../assets/image/default.png'
  ),
  (
    4,
    4,
    'Headphone',
    'Deskripsi Headphone',
    100000,
    '../../assets/image/default.png'
  ),
  (
    5,
    4,
    'Keyboard',
    'Deskripsi Keyboard',
    50000,
    '../../assets/image/default.png'
  ),
  (
    6,
    1,
    'Mouse',
    'Deskripsi Mouse',
    10000,
    '../../assets/image/default.png'
  );