<?php 

// Démarrage de la session (indispensable pour avoir le droit d'utiliser $_SESSION)
session_start();

// Si la personne n'est pas connectée (si elle n'a pas de nom dans $_SESSION) alors on la redirige vers l'index
if(!isset($_SESSION["name"])) {
    header("Location: /index.php");
    exit;
}

// Si le cookie "memos" existe...
if(isset($_COOKIE["memos"])) {
    // ... je le récupère sous forme de tableau grâce à json_decode
    $memos = json_decode($_COOKIE["memos"]);
}
else {
    // ... sinon je crée un tableau vide
    $memos = [];
}

// var_dump($memos);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous" defer></script>
    <title>Liste des mémos</title>
</head>
<body>
    <main class="container">
        <h1>Liste des mémo</h1>
        <section class="row">
            <?php foreach($memos as $memo) { 
                // Transformons notre $memo en tableau associatif - pour l'instant c'est un objet, mais on ne sait pas les utiliser ;)
                $memo = (array)$memo;
                ?>
                <article class="col-md-6 col-lg-4 mt-3">
                    <div class="card">
                        <div class="card-header">
                            <?= $memo["date"]; ?>
                        </div>
                        <div class="card-body">
                            <?= $memo["text"]; ?>
                        </div>
                        <div class="card-footer">
                            <?= $memo["priority"]; ?>
                        </div>
                    </div>
                </article>
            <?php } ?>
        </section>
    </main>
</body>
</html>