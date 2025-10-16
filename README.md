<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.33.0-red?style=flat-square&logo=laravel" alt="Laravel Version">
  <img src="https://img.shields.io/badge/PHP-8.4.13-blue?style=flat-square&logo=php" alt="PHP Version">
  <img src="https://img.shields.io/github/license/stephdeve/eventmanager?style=flat-square" alt="License">
  <img src="https://img.shields.io/github/issues/stephdeve/eventmanager?style=flat-square" alt="Issues">
  <img src="https://img.shields.io/github/stars/stephdeve/eventmanager?style=flat-square" alt="Stars">
</p>

<h1 align="center">🎟️ EventManager</h1>
<p align="center">
  Une plateforme web complète pour la gestion d’événements et de billets, conçue avec <strong>Laravel</strong> et un design <strong>UI/UX moderne</strong>.
</p>

---

## 🚀 À propos du projet

**EventManager** est une application web qui facilite la gestion et l’inscription aux événements.
Elle offre une expérience fluide aussi bien pour les **organisateurs** que pour les **participants**.

### 🌟 Fonctionnalités principales

#### 👨‍💼 Côté Organisateur :
- Création, édition et suppression d’événements.
- Visualisation des statistiques d’inscriptions et de billets.
- Suivi des événements récents et à venir.

#### 🙋‍♂️ Côté Utilisateur :
- Consultation des événements disponibles.
- Inscription à un événement avec confirmation.
- Gestion de ses billets depuis le tableau de bord.

---

## 🧠 Stack technique

| Technologie | Rôle |
|--------------|------|
| **Laravel 12** | Backend puissant et structuré |
| **Blade & Tailwind CSS** | Interface moderne et responsive |
| **Eloquent ORM** | Gestion des données simplifiée |
| **MySQL / PostgreSQL** | Base de données relationnelle |
| **Laravel Breeze / Auth** | Authentification, rôles, sessions |
| **Chart.js / ApexCharts** | Visualisation des données |
| **FontAwesome** | Icônes élégantes |

---

## 🏗️ Architecture du projet

eventmanager/
├── app/
│ ├── Http/
│ ├── Models/
│ └── Providers/
├── resources/
│ ├── views/
│ └── css/js/
├── routes/
├── database/
│ ├── migrations/
│ └── seeders/
└── public/
└── build/ (assets compilés)


---

## 🧱 Installation locale

1. **Cloner le dépôt**

   ```bash
   git clone https://github.com/stephdeve/eventmanager.git
   cd eventmanager

composer install
npm install && npm run dev

cp .env.example .env
php artisan key:generate

cp .env.example .env
php artisan key:generate

php artisan migrate --seed

php artisan serve


---

## ⚖️ Copyright & Droits d’auteur

© 2025 [@Bestbeedev](https://github.com/Bestbeedev) & [@stephdeve](https://github.com/stephdeve).
Tous droits réservés.

Ce projet — **EventManager** — est protégé par le droit d’auteur.
Aucune reproduction, distribution ou modification du code source n’est autorisée sans l’accord écrit préalable des auteurs.

Toute utilisation non autorisée du design, du code ou des ressources du projet
pour des fins commerciales ou de re-distribution constitue une violation du copyright.

> 🧠 **Remarque :** certaines bibliothèques tierces utilisées dans le projet conservent leurs propres licences respectives (MIT, Apache, etc.).
> Veuillez consulter leurs dépôts pour plus de détails.

---

<p align="center">
  <strong>Développé avec ❤️ par <a href="https://github.com/Bestbeedev">@Bestbeedev</a> & <a href="https://github.com/stephdeve">@stephdeve</a></strong><br/>
  <i>« Le code est un art, chaque ligne une intention. »</i>
</p>
