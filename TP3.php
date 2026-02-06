<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Tâches</title>

    <!-- Bootstrap 5 CDN -->
    <link rel="stylesheet" href="css/bootstrap.css">
    
    <style>
        body {
            background-color: #f8f9fa;
        }
        .task-card {
            min-height: 180px;
        }
    </style>
</head>
<?php 
    $tabTache = [];
    if(file_exists("tacheTp3.json")){
        $fileTp3 = file_get_contents("tacheTp3.json");
        $tabTache = json_decode($fileTp3, true); // Transformer du texte JSON en tableau PHP

        if (!is_array($tabTache)) { // permet de vérifier qu’une variable est bien un tableau avant de l’utiliser comme tel.
            $tabTache = [];
        }
    }
    if(isset($_POST["ajouter"])){
        $titre = $_POST["titre"];
        $description = $_POST["description"];
        $statut = $_POST["statut"];
        if($titre !== "" && $description !== ""){

            $tabDataFile = [
                "titre" => $titre,
                "description" => $description,
                "statut" => $statut
            ];
            $tabTache[] = $tabDataFile;
            $newjson = json_encode($tabTache, JSON_PRETTY_PRINT); // transforme un tableau PHP en texte JSON
            file_put_contents("tacheTp3.json",$newjson);
        }
    }

    if(isset($_POST["supprimer"])){
        $indexDel = $_POST["index"];
        unset($tabTache[$indexDel]);
        $tabTache = array_values($tabTache); // // Réindexer le tableau
        $newjson = json_encode($tabTache, JSON_PRETTY_PRINT);
        file_put_contents("tacheTp3.json", $newjson);
        header("location:" . $_SERVER['PHP_SELF']);
        exit;
    }
?>
<body>

<div class="container my-5">

    <!-- Titre -->
    <h2 class="text-center mb-4">Gestion des Tâches</h2>

    <!-- Formulaire -->
    <div class="card mb-5">
        <div class="card-header bg-primary text-white">
            Ajouter une tâche
        </div>
        <div class="card-body">
            <form method="POST">
                <!-- Titre -->
                <div class="mb-3">
                    <label class="form-label">Titre</label>
                    <input type="text" name="titre" class="form-control">
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" name="description" rows="3"></textarea>
                </div>

                <!-- Statut -->
                <div class="mb-3">
                    <label class="form-label">Statut</label>
                    <select name="statut" class="form-select">
                        <option value="en_cours">En cours</option>
                        <option value="terminer">Terminée</option>
                    </select>
                </div>

                <!-- Bouton -->
                <button class="btn btn-success" name="ajouter" type="submit">Ajouter la tâche</button>
            </form>
        </div>
    </div>

    <!-- Liste des tâches -->
<h4 class="mb-3">Liste des tâches</h4>
<?php foreach($tabTache as $index => $tache): ?>
<div class="row g-3">
    <div class="col-md-4">
         <div class="card task-card">
            <div class="card-body">
                <h5>Titre : <?php echo $tache['titre']; ?></h5>
                <p>Description : <?php echo $tache['description']; ?></p>
                <p>Statut : <?php echo $tache['statut']; ?></p>
                <form method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cette tâche ?');"> // affiche une boîte Oui / Annuler
                    <!-- <input type="hidden" name="index" value="<?php echo $index; ?>"> -->
                    <button class="btn btn-primary btn-sm" name="modifier">Modifier</button>
                    <input type="hidden" name="index" value="<?php echo $index; ?>">
                    <button class="btn btn-danger btn-sm" name="supprimer">Supprimer</button>
                </form>
            </div>
        </div>
    </div>

</div>
<?php endforeach; ?>


</body>
</html>
