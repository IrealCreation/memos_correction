<?php 
    // Code PHP exécuté côté serveur

    // Démarrage de la session (indispensable pour avoir le droit d'utiliser $_SESSION)
    session_start();

    // Vérifions si le formulaire a bien été envoyé
    if(isset($_POST["submit"])) {

        // Validation des informations envoyées par le formulaire
        // Je crée un tableau $errors qui contiendra les erreurs peut-être rencontrées
        $errors = [];

        // Vérification du nom
        if(!isset($_POST["name"]) || strlen($_POST["name"]) == 0) {
            $errors[] = "Le nom doit avoir au moins 1 caractère";
        }

        // Vérification du mot de passe
        if(!isset($_POST["password"]) || $_POST["password"] != "1234") {
            $errors[] = "Mot de passe incorrect";
        }

        // S'il n'y a pas d'erreurs, tout est OK, la personne est connectée
        if(count($errors) == 0) {
            // Enregistrer les infos de la personne dans la session
            $_SESSION["name"] = $_POST["name"];

            // Redirection vers une nouvelle page
            header("Location: /ajout.php");
            exit;
        }

    }


    // Ci-dessous, code HTML exécuté côté client
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous" defer></script>
    <title>Mémo</title>
</head>
<body>
    <main class="container">
        <h1>Site Mémo</h1>
        <form action="#" method="POST">
            <fieldset>
                <legend>Formulaire de connexion</legend>

                <?php 

                // Affichage des erreurs, si elles existent
                if(isset($errors) && count($errors) > 0) {
                    // Boucle permettant d'afficher les erreurs
                    foreach($errors as $error) {
                        echo '<div class="alert alert-danger">' . $error . '</div>';
                    }
                }

                ?>

                <label for="name">Nom :</label>
                <input type="text" name="name" id="name" class="form-control">

                <label for="password">Mot de passe :</label>
                <input type="password" name="password" id="password" class="form-control">

                <button type="submit" name="submit" class="btn btn-success mt-2">Se connecter</button>
            </fieldset>
        </form>
    </main>
</body>
</html>