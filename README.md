# Projet de Généalogie - README

## Explication des données

### Cas 0 : Présentation et Installation
Je suis **Fulbert SOSSA**, étudiant en **troisième année de licence Informatique MIAGE** (Méthode Informatique Appliquée à la Gestion) à l'Université de Rennes.

Pour installer et compiler ce projet, suivez ces étapes :

1. Exécutez la commande suivante pour créer les tables nécessaires dans la base de données :
   ```bash
   php artisan migrate
   ```
2. Importez le fichier `data.sql` joint au projet pour insérer les données initiales.

---

### **Premier cas : Propositions de Modifications**

Lorsqu'un utilisateur propose une modification d'une fiche personne ou une relation familiale, une nouvelle entrée est ajoutée dans la table `contributions`.

Les champs suivants sont remplis :

- **created_by** : Identifiant de l'utilisateur ayant proposé la modification.
- **relationship_id** : Identifiant de la relation existante (NULL si c'est une nouvelle relation).
- **parent_id** et **child_id** : Identifiants des entités concernées par la relation.
- **users_accept** et **users_reject** : Champs JSON initialisés à des listes vides pour suivre les votes des utilisateurs.
- **confirm_relation** : Définie par défaut à `false`, indiquant que la modification est en attente de validation.

#### **Mise à jour des votes**
Les utilisateurs de la communauté peuvent accepter ou rejeter une proposition :

- Les votes favorables sont ajoutés dans le champ **users_accept**.
- Les votes défavorables sont ajoutés dans le champ **users_reject**.

---

### **Deuxième cas : Validation des Modifications**

Ce processus se déroule en deux phases :

#### **A) Les Votes**
Un utilisateur connecté peut confirmer ou rejeter une demande de modification ou une nouvelle relation.

- **Confirmer** : L'ID de l'utilisateur est ajouté à la liste `users_accept` des personnes ayant validé cette contribution.
- **Rejeter** : L'ID de l'utilisateur est ajouté à la liste `users_reject` des personnes ayant refusé cette contribution.

#### **B) La Décision Finale**
Lors des votes, deux scénarios sont possibles :

1. **Validation de la Contribution**
   - Si **3 utilisateurs** confirment la modification avant que 3 autres ne la rejettent, la contribution est **approuvée**.
   - La relation est alors enregistrée dans la table **relationships** et devient officielle.

2. **Rejet de la Contribution**
   - Si **3 utilisateurs** rejettent la modification avant qu'elle ne soit validée, la contribution est **annulée** et ne sera plus soumise au vote.

---

