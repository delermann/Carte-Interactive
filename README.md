# Carte Interactive Radio WNE

Une application cartographique minimaliste et élégante basée sur **Leaflet.js** et **PHP/MySQL**. Elle permet d'afficher des points d'intérêt (lieux, podcasts, sites web) liés aux activités de Radio WNE.

## Fonctionnalités
- **Carte Interactive** : Visualisation des lieux avec icônes personnalisées.
- **Filtres Thématiques** : Filtrage dynamique par catégories (Écologie, Culture, etc.).
- **Interface Admin** : CMS complet pour gérer les catégories et les points (Ajout, Modification, Suppression, Upload d'images).
- **Responsive Design** : Optimisé pour une intégration en Iframe sur d'autres sites.

## Installation

1. **Base de données** :
   - Créez une base de données MySQL.
   - Importez le fichier `structure.sql` fourni.

2. **Configuration** :
   - Modifiez les variables `$host`, `$dbname`, `$user` et `$pass` dans `index.php` et `admin.php`.
   - **Important** : Changez le mot de passe `$admin_password` dans `admin.php`.

3. **Déploiement** :
   - Transférez les fichiers sur votre serveur web.
   - Créer le dossier `uploads/` et assurez-vous qu'il possède les droits d'écriture (`chmod 755`).

## 📦 Technologies
- **Frontend** : HTML5, CSS3, JavaScript (Leaflet.js).
- **Backend** : PHP 7.4+ / 8.0+.
- **Database** : MySQL / MariaDB.