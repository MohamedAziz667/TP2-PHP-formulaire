<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mini Projet PHP – Gestion des Tâches</title>

    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="css/bootstrap.css">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .badge-priority-low { background-color: #6c757d; }
        .badge-priority-medium { background-color: #0d6efd; }
        .badge-priority-high { background-color: #dc3545; }

        .task-late {
            border-left: 5px solid red;
        }
    </style>
</head>
<?php 
    $tache = [];
    $statu = "a_faire";
    $dateDuJour = date("Y-m-d");
    $nbTache = 0;
    $nbTacheTerminer = 0;
    $nbTacheRetard = 0;
    $pctgTache = 0;
    if(file_exists("dataMiniProjet1.json")){
        $contenu = file_get_contents("dataMiniProjet1.json");
        $tache = json_decode($contenu, true);
    }

    if(!is_array($tache)){
        $tache = [];
    }

    if(isset($_POST['ajouter'])){
        $id = time();
        $titre = $_POST["titre"];
        $description = $_POST["description"];
        $priorite = $_POST["priorite"];
        $dateLimite = $_POST["dateLimite"];
        $dateCreation = date("Y-m-d");

        // if($titre !== "" && $description !== ""){

            $tacheTab = [
                "id" => $id,
                "titre" => $titre,
                "description" => $description,
                "priorite" => $priorite,
                "dateLimite" => $dateLimite,
                "statut" => $statu,
                "dateCreation" => $dateCreation
            ];
        // }
        $tache[] = $tacheTab;
        $newjson = json_encode($tache, JSON_PRETTY_PRINT);
        file_put_contents("dataMiniProjet1.json", $newjson);
    }
    foreach($tache as $t){
        $nbTache++;
        if($t["statut"] === "termine"){
            $nbTacheTerminer++;
        }
        if($t["statut"] !== "termine" && $dateDuJour > $t["dateLimite"]){
            $nbTacheRetard++;
        }
    }
    if($nbTache >= 1){
        $pctgTache = ($nbTacheTerminer / $nbTache) * 100;
    }
    $pctgTache = round($pctgTache, 2);

    if(isset($_GET["action"]) && $_GET["action"] === "changer_statut"){
        $index = $_GET["index"];
        if(isset($tache[$index])){
            if($tache[$index]["statut"] === "a_faire"){
                $tache[$index]["statut"] = "en_cours";
            } elseif($tache[$index]["statut"] === "en_cours"){
                $tache[$index]["statut"] = "termine";
            } else {
                header("Location:" . $_SERVER["PHP_SELF"] . "?message=termine");
                exit;
            }
            file_put_contents("dataMiniProjet1.json",
                json_encode($tache, JSON_PRETTY_PRINT)
            );
            header("Location: " . $_SERVER["PHP_SELF"]); // Permet d'eviter une double action
            exit; // pour empêcher PHP de continuer à exécuter le HTML
        }
    } elseif(isset($_GET["action"]) && $_GET["action"] === "supprimer"){
        $index = $_GET["index"];
        unset($tache[$index]);
        $tache = array_values($tache);
        file_put_contents("dataMiniProjet1.json", json_encode($tache, JSON_PRETTY_PRINT));
        header("Location: " . $_SERVER["PHP_SELF"]);
        exit;
    }
    $motCle = strtolower($_GET["q"] ?? '');
    $statCle = $_GET["statut"] ?? '';
    $prioCle = $_GET["priorite"] ?? '';
    $tachesFiltrees = array_filter($tache, function ($t) use ($motCle, $statCle, $prioCle) {

    // Recherche mot-clé
    if ($motCle !== '') {
        if (
            strpos(strtolower($t["titre"]), $motCle) === false &&
            strpos(strtolower($t["description"]), $motCle) === false
        ) {
            return false;
        }
    }

    // Filtre statut
    if ($statCle !== '' && $t["statut"] !== $statCle) {
        return false;
    }

    // Filtre priorité
    if ($prioCle !== '' && $t["priorite"] !== $prioCle) {
        return false;
    }

    return true;
});

?>
<body>

<div class="container my-5">

    <!-- Titre -->
    <h2 class="text-center mb-4">Mini Projet – Gestion des Tâches</h2>

    <!-- ================= FORMULAIRE AJOUT ================= -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            Ajouter une tâche
        </div>
        <div class="card-body">
            <form method="post">
                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Titre</label>
                        <input type="text" name="titre" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Priorité</label>
                        <select name="priorite" class="form-select">
                            <option>Basse</option>
                            <option>Moyenne</option>
                            <option>Haute</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="3"></textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Date limite</label>
                        <input type="date" name="dateLimite" class="form-control">
                    </div>

                    <div class="col-md-6 d-flex align-items-end">
                        <button name="ajouter" class="btn btn-success w-100">
                            Ajouter la tâche
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <!-- ================= RECHERCHE & FILTRES ================= -->
     
    <div class="card mb-4">
        <div class="card-body">
            <form method="get">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text"
                        name="q"
                        class="form-control"
                        placeholder="Recherche par mot-clé"
                        value="<?php echo $_GET['q'] ?? ''; ?>">
                    </div>
                    <div class="col-md-4">
                        <select name="statut" class="form-select">
                            <option value="">Tous les statuts</option>
                            <option value="a_faire">À faire</option>
                            <option value="en_cours">En cours</option>
                            <option value="termine">Terminée</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <select name="priorite" class="form-select">
                            <option value="">Toutes les priorités</option>
                            <option value="Basse">Basse</option>
                            <option value="Moyenne">Moyenne</option>
                            <option value="Haute">Haute</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary w-100">
                            Filtrer
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- ================= LISTE DES TÂCHES ================= -->
     <?php if(isset($_GET["message"]) && $_GET["message"] === "termine"): ?>
        
            <div class="alert alert-warning">
                Cette tâche est déjà terminée, le statut ne peut plus être modifié.
            </div>
        
     <?php endif; ?>
    <h4 class="mb-3">Liste des tâches</h4>
    
    <div class="row g-3">
        
        <!-- Tâche exemple -->
        <?php foreach($tachesFiltrees as $index => $t): ?>
        <div class="col-md-4">
            <div class="card task-late">
                <div class="card-body">
                    <h5 class="card-title"> Titre : <?php echo $t["titre"]; ?> </h5>
                    <p class="card-text">Id : <?php echo $t["id"]; ?> </p>
                    <p class="card-text"> Description : <?php echo $t["description"]; ?> </p>
                    <p class="card-text">Date de création : <?php echo $t["dateCreation"]; ?> </p>
                    <p class="card-text">Date de Limite de Dépot : <?php echo $t["dateLimite"]; ?> </p>
                    <p>
                        <span class="badge bg-warning text-dark">Statut:<?php echo $t["statut"]; ?> </span>
                        <span class="badge badge-priority-high">Priorité : <?php echo $t["priorite"]; ?> </span>
                    </p>

                    <?php if($t["statut"] !== "termine"): ?>
                        <?php if($dateDuJour > $t["dateLimite"]): ?>
                            <p class="text-danger">
                                Date limite dépassée
                                Sans avoir terminer votre tache!
                            </p>
                            
                        <?php else: ?>
                            <p class="text-danger">
                                Veuillez terminée votre tache avant la date limite
                            </p>
                        <?php endif; ?>
                    <?php endif; ?>

                    <div class="d-flex gap-2">
                            <a class="btn btn-outline-secondary btn-sm" 
                                href="?action=changer_statut&index=<?php echo $index; ?>">
                                Changer statut
                            </a>
                        <a class="btn btn-danger btn-sm"
                            href="?action=supprimer&index=<?php echo $index; ?>"
                            onclick="return confirm('Voulez vous supprimer cette tache ?');">
                            Supprimer
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Autres cartes → même structure -->
        <?php endforeach; ?>
    </div>
    

    <!-- ================= STATISTIQUES ================= -->
    <div class="card mt-5">
        <div class="card-header bg-dark text-white">
            Statistiques
        </div>
        <div class="card-body">
            <div class="row text-center">

                <div class="col-md-3">
                    <h5>Total</h5>
                    <p class="fs-4"> <?php echo $nbTache; ?> </p>
                </div>

                <div class="col-md-3">
                    <h5>Terminées</h5>
                    <p class="fs-4 text-success"><?php echo $nbTacheTerminer; ?></p>
                </div>
                <div class="col-md-3">
                    <h5>% Terminées</h5>
                    <p class="fs-4"> <?php echo $pctgTache; ?> </p>
                </div>

                <div class="col-md-3">
                    <h5>En retard</h5>
                    <p class="fs-4 text-danger"><?php echo $nbTacheRetard ?></p>
                </div>

            </div>
        </div>
    </div>

</div>

</body>
</html>
