
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Document</title>
<link rel="stylesheet" href="css/bootstrap.css">
</head>
<?php
    $taches = [];

    if(file_exists("tache.json")){
        $jsonContent = file_get_contents("tache.json");
        $taches = json_decode($jsonContent, true);
    }

    if(isset($_POST['send'])){
        $titre = $_POST['titre'];
        $description = $_POST['description'];
        $statut = $_POST['statut'];
        
        $tache = [
            "titre" => $titre,
            "description" => $description,
            "statut" => $statut
        ];
    }
    $taches[] = $tache;
    $newJson = json_encode($taches, JSON_PRETTY_PRINT);
    file_put_contents("tache.json", $newJson)
?>
<body>
    <div class="card col-6 offset-3 mt-5">
        <div class="card-header h2">Ajouter une tache</div>
        <div class="card-body">
            <form method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Titre</label>
                    <input type="text" name="titre" class="form-control" id="exampleFormControlInput1" placeholder="Titre du livre">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                    <textarea name="description" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label for="formFile" class="form-label" for="">statut</label>
                    <select name="statut" id="statut">
                        <option value="en_cours">En cours</option>
                        <option value="termine">Terminé</option>
                    </select>
                </div>
                <button type="submit" name="send" class="btn btn-primary">ajouter la tache</button>
            </form>
        </div>
    </div>
    <h1>Liste des taches</h1>
    <?php foreach($taches as $t): ?>
    <div class="card">
        <div class="card-header">
            tache
        </div>
        <div class="card-body">
            <h5 class="card-title"> <?php echo htmlspecialchars($t['titre']) ?> </h5>
            <p class="card-text"> <?php echo htmlspecialchars($t['description']) ?> </p>
            <p class="card-text"> <?php echo htmlspecialchars($t['statut']) ?> </p>
            <button class="btn btn-warning">Modifier</button>
            <button class="btn btn-danger">Supprimer</button>
        </div>
    </div>
    <?php endforeach; ?>

</body>
</html>
