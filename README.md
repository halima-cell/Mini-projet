Librairie en Ligne
Description
Ce projet est une application web complète de librairie en ligne développée en PHP, permettant aux utilisateurs de parcourir un catalogue de livres, gérer un panier d'achat, se connecter/inscrire, et effectuer des paiements simulés. Les administrateurs peuvent gérer les livres (ajouter, supprimer). Le design est moderne et responsive, utilisant Bootstrap et une CSS personnalisée avec un thème clair et tendance (pastels, gradients).

Fonctionnalités
Pages principales :

Accueil : Présentation et recherche rapide de livres.
Catalogue : Liste des livres avec images, titres, auteurs, prix. Recherche par titre/auteur.
Détails d'un livre : Description, disponibilité, bouton "Ajouter au panier".
Panier : Liste des livres sélectionnés, calcul du total, suppression individuelle, bouton de paiement.
Connexion/Inscription : Gestion des utilisateurs (clients/admins) avec hashage sécurisé des mots de passe.
Espace Admin : Ajouter/modifier/supprimer des livres.
Mon Compte (Client) : Modifier profil (nom, email, mot de passe).
Paiement : Formulaire simulé pour paiement (carte, adresse), enregistrement de la commande.
Déconnexion : Fin de session.
Fonctionnalités clés :

Recherche de livres (par titre/auteur).
Panier dynamique avec sessions PHP.
Authentification sécurisée (password_hash/password_verify).
CRUD admin pour les livres.
Gestion des commandes (insertion en DB après paiement).
Responsive design pour mobile/desktop.
Technologies Utilisées
Frontend : HTML, CSS (thème personnalisé avec gradients et glassmorphism), Bootstrap 5.3.0, Google Fonts (Montserrat).
Backend : PHP 7+ (sessions, formulaires, PDO pour DB).
Base de Données : MySQL (tables : users, books, orders).
Serveur : XAMPP (Apache, MySQL) pour développement local.
Sécurité : Hashage des mots de passe, validation des entrées, sessions PHP.
Installation et Configuration
Prérequis :

XAMPP installé (ou équivalent : Apache, MySQL, PHP).
Navigateur web (Chrome recommandé pour les effets CSS).
Clonage du Projet :

bash

Copy code
git clone https://github.com/votre-utilisateur/librairie-en-ligne.git
cd librairie-en-ligne
Configuration de la Base de Données :

Démarrez XAMPP (Apache et MySQL).
Ouvrez phpMyAdmin (http://localhost/phpmyadmin).
Créez une base de données nommée librairie.
Exécutez le script SQL suivant pour créer les tables et insérer des données d'exemple :
sql

Copy code
CREATE DATABASE librairie;
USE librairie;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    mot_de_passe VARCHAR(255),
    role ENUM('client', 'admin') DEFAULT 'client'
);

CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255),
    auteur VARCHAR(255),
    prix DECIMAL(10,2),
    stock INT,
    image VARCHAR(255),
    description TEXT
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    date DATETIME DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10,2),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Données d'exemple
INSERT INTO users (nom, email, mot_de_passe, role) VALUES ('Admin', 'admin@example.com', '$2y$10$hash_admin', 'admin');
INSERT INTO books (titre, auteur, prix, stock, image, description) VALUES ('Livre 1', 'Auteur 1', 10.00, 5, 'image1.jpg', 'Description 1');
Configuration PHP :

Placez les fichiers dans C:\xampp\htdocs\Mini projet\ (ou équivalent).
Modifiez les connexions DB dans les fichiers PHP si nécessaire (par défaut : host='localhost', user='root', pass='').
Lancement :

Accédez à http://localhost/Mini%20projet/index.php.
Inscrivez-vous ou connectez-vous (admin@example.com / admin pour l'admin).
Structure des Fichiers
index.php : Page d'accueil.
catalogue.php : Catalogue des livres.
details.php : Détails d'un livre.
panier.php : Gestion du panier.
login.php : Connexion/Inscription.
admin.php : Espace admin.
compte.php : Mon compte (client).
paiement.php : Page de paiement.
logout.php : Déconnexion.
style.css : Feuille de style personnalisée.
README.md : Ce fichier.
Utilisation
Client : Parcourez le catalogue, ajoutez au panier, connectez-vous, modifiez votre compte, payez.
Admin : Connectez-vous, ajoutez/supprimez des livres.
Paiement : Simulé (en production, intégrez Stripe/PayPal).
Améliorations Futures
Intégration d'une vraie API de paiement.
Gestion des quantités dans le panier.
Historique des commandes pour les clients.
Upload d'images pour les livres.
Tests unitaires et déploiement sur serveur.
Contributeurs
Halima Bouhmid - Développeur principal.
