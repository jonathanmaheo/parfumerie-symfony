# 🌸 Maison Elixir — Boutique de parfums de niche

Projet Symfony réalisé dans le cadre d'une formation de développeur web.

**Maison Elixir** est une boutique en ligne de parfums de niche. Le site permet à un
membre de parcourir le catalogue, de composer un panier, de passer une commande (paiement
simulé) puis de suivre ses commandes dans un espace client dédié. Un back-office complet
permet à l'administrateur de gérer les parfums, leurs déclinaisons (contenance, stock, prix),
les marques, les clients et les commandes.

---

## 🚀 Fonctionnalités

### Côté client
- Accueil, catalogue de parfums (filtres par marque)
- Fiche parfum avec choix de la contenance (variante) : prix, stock, sillage, tenue
- Panier en session : ajout / retrait / suppression, **limitation par le stock**
- Paiement **simulé** (page de paiement factice — aucune donnée bancaire traitée)
- Page de confirmation de commande avec récapitulatif
- Espace client : inscription avec **vérification par email**, connexion, liste de
  ses commandes ("Suivi de commande")
- Pages institutionnelles : Contact, FAQ, CGV/CGU, mentions légales, politique de
  confidentialité, livraisons et retours, guide du parfum, Qui sommes-nous

### Côté administrateur (`/admin`)
- Tableau de bord + gestion des **parfums**, **variantes**, **marques**, **clients**,
  **utilisateurs**, **commandes** et **lignes de commande**
- Fiches détaillées : commande ⮕ client, lignes de commande ⮕ produit et prix
- Sécurité : accès réservé aux comptes `ROLE_ADMIN`

---

## 🛠️ Technologies

| Technologie | Usage |
|---|---|
| Symfony 7.4 / PHP 8.2 | Framework backend (MVC) |
| Doctrine ORM | Modèle de données (MySQL / MariaDB) |
| Twig | Moteur de templates |
| Bootstrap 5 + Bootstrap Icons | Interface et icônes |
| Mailtrap (SMTP sandbox) | Envoi d'emails de vérification en dev |

---

## 📦 Installation (environnement local)

1. **Prérequis** : PHP ≥ 8.2, Composer, MySQL/MariaDB.

2. **Installer les dépendances**
   ```bash
   composer install
   ```

3. **Configurer l'environnement**
   Créer le fichier `.env.local` à partir de `.env` et renseigner :
   ```env
   DATABASE_URL="mysql://root:@127.0.0.1:3306/parfumerie?serverVersion=10.4.32-MariaDB&charset=utf8mb4"
   MAILER_DSN="smtp://USER:PASSWORD@sandbox.smtp.mailtrap.io:2525"
   ```
   > Le DSN Mailtrap s'obtient dans l'onglet **Email Testing** (inbox Sandbox) de mailtrap.io.

4. **Créer la base de données et appliquer les migrations**
   ```bash
   php bin/console doctrine:database:create
   php bin/console doctrine:migrations:migrate
   ```

5. **Lancer le serveur**
   ```bash
   symfony server:start
   ```
   puis ouvrir `http://localhost:8000`.

---

## 🔑 Comptes de démo

- **Compte membre** : s'inscrire sur `/inscription`, puis confirmer l'email via le message
  reçu dans l'inbox **Mailtrap** (le lien de confirmation s'y trouve).
- **Compte administrateur** : après inscription + vérification, passer le rôle `ROLE_ADMIN`
  dans la base (`user.roles` = `["ROLE_ADMIN"]`) ou via `/admin/user`.

---

## 🗂️ Structure du projet (essentiel)

```
config/                 Configuration (routes, sécurité, doctrine, mailer)
src/Controller/         Contrôleurs (client, panier, commande, profil, admin, pages)
src/Entity/             Entités Doctrine (Parfum, ParfumVariant, Marque, Commande, ...)
src/Form/               Formulaires
src/Security/           Gestion des comptes (vérification email)
templates/              Vues Twig (front + back-office + email de confirmation)
migrations/             Migrations de la base de données
```

## 🔗 Routes principales

| URL | Page |
|---|---|
| `/` | Accueil |
| `/catalogue` | Catalogue des parfums |
| `/marques` | Marques |
| `/page/contact` | Contact |
| `/panier` | Panier |
| `/commande/paiement` | Paiement simulé |
| `/mon-espace-client` | Espace client (mes commandes) |
| `/admin` | Back-office |

---

## ⚠️ Notes importantes

- **Paiement simulé** : le paiement est factice et pédagogique (aucun appel bancaire,
  aucune donnée réelle). Le stock est décrémenté à la validation de la commande.
- **Emails** : les emails (vérification d'inscription) ne sont visibles que dans l'inbox
  **Mailtrap** en développement. Pour un déploiement en production, remplacer `MAILER_DSN`
  par un vrai service d'envoi (Brevo, SendGrid, Gmail SMTP, etc.).
- Un membre **connecté** qui valide une commande génère automatiquement une fiche **Client**
  (si elle n'existe pas) reliée à la commande.