CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hlou VARCHAR(255) NOT NULL,
    quantite INT NOT NULL,
    telephone VARCHAR(20) NOT NULL,
    adresse VARCHAR(255) NOT NULL,
    date_commande TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
