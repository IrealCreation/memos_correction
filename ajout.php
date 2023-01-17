<?php 

// Démarrage de la session (indispensable pour avoir le droit d'utiliser $_SESSION)
session_start();

// Si la personne n'est pas connectée (si elle n'a pas de nom dans $_SESSION) alors on la redirige vers l'index
if(!isset($_SESSION["name"])) {
    header("Location: /index.php");
    exit;
}

// Est-ce que le formulaire a été envoyé ?
if(isset($_POST["submit"])) {
    // Validation des éléments du formulaire
    // Je crée un tableau $errors qui contiendra les erreurs peut-être rencontrées
    $errors = [];

    // Est-ce que la date est correcte ?
    if(!isset($_POST["date"]) || !DateTime::createFromFormat("Y-m-d", $_POST["date"])) {
        $errors[] = "La date envoyée est incorrecte";
    }

    // Est-ce que la priorité est correcte ?
    if(!isset($_POST["priority"]) || !in_array($_POST["priority"], ["Faible", "Moyenne", "Haute"])) {
        $errors[] = "La priorité est incorrecte";
    }

    // Est-ce que le texte est correct
    if(!isset($_POST["text"]) || strlen($_POST["text"]) < 1) {
        $errors[] = "Le texte doit contenir au moins 1 caractère";
    }

    if(count($errors) == 0) {
        // Les informations du formulaire sont correctes

        // Créons notre tableau associatif $memo
        $memo = [
            "date" => $_POST["date"],
            "priority" => $_POST["priority"],
            "text" => $_POST["text"]
        ];

        // Vérifions si un cookie existe déjà...
        if(isset($_COOKIE["memos"])) {
            // ... si oui, on récupère la liste des memos contenus dans le cookie grâce à json_decode
            $memos = json_decode($_COOKIE["memos"]);
        }
        else {
            // ... si non, on crée une nouvelle liste vide
            $memos = [];
        }

        // Ajoutons notre nouveau memo à la liste
        $memos[] = $memo;

        // Encodons notre tableau de memos grâce à json_encode
        $memos = json_encode($memos);

        // Stockons notre tableau de memos (encodé en JSON) dans le cookie
        setcookie("memos", $memos, [
            // Date d'expiration du cookie (1 mois)
            "expires" => time() + (60 * 60 * 24 * 30),
            // Le cookie fonctionne sans HTTPS
            "secure" => false,
            // Seul notre notre site a le droit d'utiliser ce cookie
            "samesite" => "strict",
            // Rend le cookie utilisable sur tout le site
            "path" => "/"
        ]);
    }
}

// var_dump($_COOKIE["memos"]);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous" defer></script>
    <title>Ajout de mémo</title>
</head>
<body>
    <main class="container">
        <h1>Ajout de mémo</h1>
        <p>Bonjour, <?= $_SESSION["name"]; ?>. Souhaitez-vous ajouter un mémo ?</p>

        <form action="#" method="POST">
            <fieldset>
                <legend>Ajout de mémo</legend>

                <?php 

                // Affichage des erreurs, si elles existent
                if(isset($errors) && count($errors) > 0) {
                    // Boucle permettant d'afficher les erreurs
                    foreach($errors as $error) {
                        echo '<div class="alert alert-danger">' . $error . '</div>';
                    }
                }

                ?>

                <label for="date">Date :</label>
                <input type="date" name="date" id="date" class="form-control">

                <label for="priority">Priorité :</label>
                <select name="priority" id="priority" class="form-control">
                    <option value="" selected hidden disabled>Sélectionner</option>
                    <option value="Faible">Faible</option>
                    <option value="Moyenne">Moyenne</option>
                    <option value="Haute">Haute</option>
                </select>

                <label for="text">Texte :</label>
                <textarea name="text" id="text" cols="30" rows="10" class="form-control"></textarea>

                <button type="submit" name="submit" class="btn btn-success mt-2">Enregistrer</button>
            </fieldset>
        </form>
    </main>
</body>
</html>