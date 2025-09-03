# 🏠 NGOMBILAND - Plateforme d'Immobilier Collaboratif au Cameroun

## 📋 Table des matières

-   [Description du projet](#description-du-projet)
-   [Fonctionnalités](#fonctionnalités)
-   [Installation](#installation)
-   [Configuration](#configuration)
-   [Structure du projet](#structure-du-projet)
-   [Routes et fonctionnalités](#routes-et-fonctionnalités)
-   [Modèles et relations](#modèles-et-relations)
-   [Comptes de test](#comptes-de-test)
-   [Utilisation](#utilisation)
-   [API](#api)
-   [Développement](#développement)

## 🎯 Description du projet

NGOMBILAND est une plateforme web d'investissement immobilier collaboratif spécialement conçue pour le marché camerounais. Elle permet aux utilisateurs d'investir dans l'immobilier, de gérer leurs propriétés et de participer à des projets de crowdfunding immobilier.

## ✨ Fonctionnalités

### 🔓 **Fonctionnalités publiques**

-   Page d'accueil avec présentation de la plateforme
-   Consultation des propriétés disponibles
-   Système de contact et support
-   Inscription et connexion utilisateurs

### 🔐 **Fonctionnalités authentifiées**

-   **Dashboard personnalisé** selon le rôle utilisateur
-   **Gestion des propriétés** (CRUD complet)
-   **Système de messagerie** entre utilisateurs
-   **Portefeuille numérique** (Wallet)
-   **Gestion des investissements**
-   **Système de rapports**

### 👑 **Fonctionnalités administrateur**

-   Gestion des utilisateurs
-   Modération des propriétés
-   Statistiques et analytics
-   Configuration système

## 🚀 Installation

### Prérequis

-   PHP 8.1 ou supérieur
-   Composer
-   Node.js et NPM
-   Base de données (MySQL/PostgreSQL/SQLite)

### Étapes d'installation

1. **Cloner le projet**

```bash
git clone <repository-url>
cd Ngombiland_new
```

2. **Installer les dépendances PHP**

```bash
composer install
```

3. **Installer les dépendances Node.js**

```bash
npm install
```

4. **Configuration de l'environnement**

```bash
cp .env.example .env
php artisan key:generate
```

5. **Configuration de la base de données**
   Éditez le fichier `.env` et configurez votre base de données :

```env
DB_CONNECTION=sqlite
DB_DATABASE=/chemin/vers/database/database.sqlite
```

6. **Exécuter les migrations**

```bash
php artisan migrate
```

7. **Peupler la base de données**

```bash
php artisan db:seed
```

8. **Démarrer le serveur**

```bash
php artisan serve
```

L'application sera accessible sur `http://127.0.0.1:8000`

## ⚙️ Configuration

### Variables d'environnement importantes

```env
APP_NAME="NGOMBILAND"
APP_URL=http://127.0.0.1:8000
DB_CONNECTION=sqlite
MAIL_MAILER=smtp
```

### Configuration des rôles

Les rôles utilisateur sont définis dans la migration `create_users_table` :

-   `admin` : Administrateur système
-   `agent` : Agent immobilier
-   `client` : Client standard
-   `proprietor` : Propriétaire immobilier
-   `investor` : Investisseur

## 📁 Structure du projet

```
Ngombiland_new/
├── app/
│   ├── Http/Controllers/
│   │   ├── Auth/                 # Contrôleurs d'authentification
│   │   ├── admin/                # Contrôleurs administrateur
│   │   ├── api/                  # Contrôleurs API
│   │   ├── crowdfunding/         # Contrôleurs crowdfunding
│   │   └── services/             # Services métier
│   ├── Models/                   # Modèles Eloquent
│   ├── Http/Middleware/          # Middlewares personnalisés
│   └── Notifications/            # Notifications
├── database/
│   ├── migrations/               # Migrations de base de données
│   └── seeders/                  # Seeders pour données de test
├── resources/
│   ├── views/                    # Vues Blade
│   │   ├── auth/                 # Vues d'authentification
│   │   ├── properties/           # Vues des propriétés
│   │   ├── partials/             # Partiels réutilisables
│   │   └── admin/                # Vues administrateur
│   ├── css/                      # Styles CSS
│   └── js/                       # Scripts JavaScript
├── routes/
│   ├── web.php                   # Routes web
│   ├── api.php                   # Routes API
│   └── auth.php                  # Routes d'authentification
└── public/
    ├── images/                   # Images statiques
    └── storage/                  # Fichiers uploadés
```

## 🛣️ Routes et fonctionnalités

### 🔓 **Routes publiques**

| Route              | Méthode | Description             |
| ------------------ | ------- | ----------------------- |
| `/`                | GET     | Page d'accueil          |
| `/services`        | GET     | Page des services       |
| `/about`           | GET     | Page à propos           |
| `/contact`         | GET     | Page de contact         |
| `/properties`      | GET     | Liste des propriétés    |
| `/properties/{id}` | GET     | Détails d'une propriété |
| `/support/message` | POST    | Envoi message support   |

### 🔑 **Routes d'authentification**

| Route             | Méthode  | Description                   |
| ----------------- | -------- | ----------------------------- |
| `/login`          | GET/POST | Connexion                     |
| `/register`       | GET/POST | Inscription                   |
| `/logout`         | POST     | Déconnexion                   |
| `/password/reset` | GET/POST | Réinitialisation mot de passe |
| `/email/verify`   | GET      | Vérification email            |

### 🔐 **Routes authentifiées**

| Route                   | Méthode  | Description               |
| ----------------------- | -------- | ------------------------- |
| `/dashboard`            | GET      | Tableau de bord           |
| `/wallet`               | GET      | Portefeuille numérique    |
| `/wallet/topup`         | POST     | Rechargement portefeuille |
| `/wallet/withdraw`      | POST     | Retrait portefeuille      |
| `/messages`             | GET      | Messages reçus            |
| `/messages/{id}`        | GET      | Détail message            |
| `/reports`              | GET      | Rapports                  |
| `/properties/create`    | GET/POST | Créer propriété           |
| `/properties/{id}/edit` | GET/PUT  | Modifier propriété        |
| `/properties/{id}`      | DELETE   | Supprimer propriété       |
| `/investments`          | GET/POST | Gestion investissements   |

### 👑 **Routes administrateur**

| Route             | Méthode | Description          |
| ----------------- | ------- | -------------------- |
| `/admin`          | GET     | Dashboard admin      |
| `/admin/users`    | GET     | Gestion utilisateurs |
| `/admin/settings` | GET     | Paramètres système   |

## 🗄️ Modèles et relations

### **User** (Utilisateur)

```php
// Relations
- properties() : hasMany(Property)
- investments() : hasMany(Investment)
- wallet() : hasOne(Wallet)
- transactions() : hasMany(Transaction)
- messages() : hasMany(Message)

// Méthodes
- isAdmin() : bool
- unreadMessages() : hasMany(Message)
```

### **Property** (Propriété)

```php
// Relations
- owner() : belongsTo(User)
- investments() : hasMany(Investment)

// Attributs
- title, description, price, location
- type, status, images
- latitude, longitude
```

### **Investment** (Investissement)

```php
// Relations
- user() : belongsTo(User)
- property() : belongsTo(Property)

// Attributs
- amount, roi, status
- investment_date
```

### **Wallet** (Portefeuille)

```php
// Relations
- user() : belongsTo(User)
- transactions() : hasMany(Transaction)

// Attributs
- balance, currency, status
```

### **Message** (Message)

```php
// Relations
- sender() : belongsTo(User)
- receiver() : belongsTo(User)

// Attributs
- message, read
```

## 👥 Comptes de test

### **Administrateur**

-   **Email** : `admin@ngombiland.cm`
-   **Mot de passe** : `password`
-   **Rôle** : Administrateur système

### **Client**

-   **Email** : `jean@example.com`
-   **Mot de passe** : `password`
-   **Rôle** : Client standard

### **Propriétaire**

-   **Email** : `marie@example.com`
-   **Mot de passe** : `password`
-   **Rôle** : Propriétaire immobilier

### **Investisseur**

-   **Email** : `paul@example.com`
-   **Mot de passe** : `password`
-   **Rôle** : Investisseur

## 🎮 Utilisation

### **Pour les visiteurs**

1. Accédez à la page d'accueil
2. Consultez les propriétés disponibles
3. Inscrivez-vous pour accéder aux fonctionnalités complètes

### **Pour les utilisateurs connectés**

1. **Dashboard** : Vue d'ensemble de votre activité
2. **Propriétés** : Gérez vos biens immobiliers
3. **Wallet** : Gérez votre portefeuille numérique
4. **Messages** : Communiquez avec d'autres utilisateurs
5. **Investissements** : Suivez vos investissements

### **Pour les administrateurs**

1. Accédez à `/admin` après connexion
2. Gérez les utilisateurs et propriétés
3. Consultez les statistiques
4. Configurez les paramètres système

## 🔌 API

### **Endpoints API disponibles**

```bash
# Authentification
POST /api/auth/register
POST /api/auth/login
POST /api/auth/logout

# Utilisateurs
GET /api/users
POST /api/users
PUT /api/users/{id}
DELETE /api/users/{id}

# Propriétés
GET /api/properties
POST /api/properties
PUT /api/properties/{id}
DELETE /api/properties/{id}

# Wallet
POST /api/wallet/topup
POST /api/wallet/withdraw
GET /api/wallet/balance

# Statistiques (Admin)
GET /api/admin/statistics/users
GET /api/admin/statistics/properties
GET /api/admin/statistics/transactions
GET /api/admin/statistics/investments
```

### **Authentification API**

Utilisez Sanctum pour l'authentification API :

```bash
# Obtenir un token
POST /api/auth/login
{
    "email": "user@example.com",
    "password": "password"
}

# Utiliser le token
Authorization: Bearer {token}
```

## 🛠️ Développement

### **Commandes utiles**

```bash
# Nettoyer le cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Régénérer l'autoload
composer dump-autoload

# Créer un nouveau contrôleur
php artisan make:controller NomController

# Créer une nouvelle migration
php artisan make:migration nom_migration

# Créer un nouveau modèle
php artisan make:model NomModel

# Créer un nouveau seeder
php artisan make:seeder NomSeeder
```

### **Tests**

```bash
# Exécuter les tests
php artisan test

# Tests avec couverture
php artisan test --coverage
```

### **Déploiement**

1. Configurez votre serveur web (Apache/Nginx)
2. Pointez le document root vers `/public`
3. Configurez les variables d'environnement
4. Exécutez les migrations en production
5. Optimisez l'application :

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 📞 Support

Pour toute question ou problème :

-   **Email** : support@ngombiland.cm
-   **Documentation** : Consultez ce README
-   **Issues** : Utilisez le système de tickets du projet

## 📄 Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus de détails.

---

**NGOMBILAND** - Révolutionner l'investissement immobilier au Cameroun 🏠🇨🇲
