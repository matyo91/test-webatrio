Enoncé :

1)  L'application permet de gérer des "Personnes" (nom, prénom, date de naissance) et leurs "Emplois" (nom de l'entreprise, poste occupé).

=> Bootstrap du projet et creation des entités et de la base de donnée.

2) Créez les endpoints qui:
- Sauvegardent une nouvelle personne. Attention, seules les personnes de moins de 150 ans peuvent être enregistrées. Sinon, renvoyez une erreur.

=> création de la route REST https://127.0.0.1:8000/api/user (POST) + contrôle de l'age

- Permettent d'ajouter un emploi à une personne avec une date de début et de fin d'emploi. Pour le poste actuellement occupé, la date de fin n'est pas obligatoire. Une personne peut avoir plusieurs emplois aux dates qui se chevauchent.

=> creation de la route REST https://127.0.0.1:8000/api/user/{id}/job (POST) afin d'enregistrer plusieurs emploi pour un utilisateur d'identifiant {id}

- Renvoient toutes les personnes enregistrées par ordre alphabétique, et indiquent également leur âge et leur(s) emploi(s) actuel(s).

=> creation de la route REST https://127.0.0.1:8000/api/users (GET) retournant les informations demandées

- Renvoient toutes les personnes ayant travaillé pour une entreprise donnée.

=> creation de la route REST https://127.0.0.1:8000/api/users/list_from_company/{company} (GET) et prend en paramètre la société {company}

- Renvoient tous les emplois d'une personne entre deux plages de dates.

=> creation de la route REST https://127.0.0.1:8000/api/user/{id}/jobs (POST) qui requière deux dates pour la selection des posts de l'utilisateur {id}


3) Créez une structure d'application et une base de données répondant aux besoins énoncés ci-dessus

4) Générez une API DOC.

La documentation API est générée et consultable sur https://127.0.0.1:8000/api/doc