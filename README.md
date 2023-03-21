# Projet-Restaurant-ECF

# Sujet: Restaurant Quai Antique

L'objectif de ce projet consiste à développer un site web de restaurant doté de multiples fonctionnalités. Il comprendra des pages d'inscription, de connexion, d'accueil, de réservation, de menu et de la carte. Certaines pages ne seront accessibles qu'à l'administrateur. La page d'accueil comportera une galerie d'images avec un bouton de réservation. La carte affichera les différentes catégories de plats proposés, tandis que le menu affichera les formules proposées. L'administrateur aura accès aux pages de la galerie d'images, de la carte, du menu, des formules et des plats, lui permettant ainsi de les modifier, supprimer ou ajouter du contenu au besoin. Les clients pourront également réserver une table via la page de réservation. Toutes les modifications, suppressions ou ajouts pourront être effectués par l'administrateur grâce aux boutons intégrés dans les différentes pages, tout comme la réservation, la carte et le menu pourront être affichés par les clients via les boutons associés.


Par exemple pour réserver, un client peut cliquer sur le bouton qui se trouve sur la page d'accueil qui est "Réserver" ou directement cliquer sur lien qui est dans le header qui est "Réservation", ensuite il devra remplir quelques champs et enregistrer et verra par la suite ses réservations. Un client n'a bien sûr pas l'obligation d'avoir un compte pour s'inscrire. 

Pour les pages de l'administrateur, il aura toujours le même cheminement à suivre. Par exemple, pour ajouter une image dans la galerie d'image qui se trouve dans la page d'accueil (partie "Nos Spécialités"), il devra cliquer sur le lien qui est "Galerie d'image" qui se trouve dans le header et devra appuyer sur insérer une nouvelle image puis il aura des champs à remplir et enregistrer et la galerie d'image sera ainsi modifier. 

J'ai déployé mon site sur la plateforme Heroku. Pour que vous puissiez avoir accès au site, voici le lien "http://blooming-stream-13928.herokuapp.com/home". Ceci vous redirigirera vers la page d'accueil de mon site sans qu'il y ai un utilisateur inscrit. J'ai créer deux comptes différents (un pour l'administrateur et un pour un client) car les deux utilisateurs n'auront pas accès aux mêmes droits. Vous pourrez vous connecter directement sur la page de connexion. Pour vous connecter en tant qu'administrateur, vous pourrez écrire dans le champ e-mail "admin@gmail.com" avec le mot de passe suivant "123456" et pour vous connecter en tant que client, vous pourrez écrire dans le champ e-mail "client@gmail.com" avec le mot de passe suivant "123456". Vous pouvez tout de même vous inscrire en remplissant le formulaire d'inscription pour vous créer un compte client.

J'aimerai préciser aussi que tous les fichiers demandées (documentations techniques, charte graphique, diagramme de classe, diagramme de séquence, diagramme de cas d'utilisation, wireframes) sont dans le dossier "LivrablePDF" qui contient deux fichiers qui est aussi dans mon projet Git.

# Démarches à suivres pour l'execution en locale :

Tout d'abord, vous devez installer les prérequis suivants :

PHP (version recommandée : 7.4 ou supérieure)
Composer (gestionnaire de paquets pour PHP)
Symfony CLI (interface en ligne de commande pour Symfony)
Clonez le référentiel du projet depuis le système de contrôle de version tel que Git sur votre machine locale.

Ouvrez un terminal ou une ligne de commande et accédez au répertoire du projet.

Exécutez la commande composer install pour installer les dépendances du projet.

Configurez la base de données. Ouvrez le fichier .env à la racine du projet et modifiez la configuration de la base de données en fonction de votre environnement. Vous pouvez utiliser une base de données locale telle que SQLite ou MySQL.

Créez la base de données. Exécutez la commande php bin/console doctrine:database:create pour créer la base de données.

Exécutez les migrations. Exécutez la commande php bin/console doctrine:migrations:migrate pour créer les tables de base de données.

Enfin, exécutez l'application. Exécutez la commande symfony server:start pour démarrer le serveur de développement local.

Ouvrez votre navigateur et accédez à l'adresse http://localhost:8000 pour accéder à l'application Symfony en local.


# Explications de la création d'un administrateur pour le back office :

Tout d'abord, créez une classe de fixture pour votre utilisateur administrateur en utilisant la commande suivante : php bin/console make:fixture

Dans votre classe de fixture, créez une méthode load() qui contiendra le code pour créer votre utilisateur administrateur. Renseignez les informations de l'administrateur.

Enregistrez votre fixture en l'ajoutant à la méthode load() de la classe AppFixtures dans la méthode load() de la classe AppFixtures

Exécutez votre fixture pour créer votre utilisateur administrateur en utilisant la commande suivante : php bin/console doctrine:fixtures:load

Une fois que votre fixture a été exécutée avec succès, vous pouvez vous connecter à l'interface d'administration de votre application Symfony en utilisant les informations d'identification de votre nouvel utilisateur admin.

