<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table { border-collapse: collapse; width: 50%; }
        th, td { border: 1px solid #333; padding: 8px; text-align: center; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <?php
        echo "Premier cours php Omar changel machine";
        echo "<br> <h1> Ngir yAllah ! </h1>";
        echo '<br> <p> Mais boul diaxlé nala expliquer </h1>';
        echo '<br> <h1> Boul enrouler nk dh! </h1>';
        $a = 5; 
        $b = 10;
        echo "<br> La valeur de a est $a et celle de b est $b";
        echo '<br> La valeur de a est '. $a . 'et celle de b est '. $b;
        if ($a > $b)
            echo "<br> $a est superieur a $b";
        elseif ($a < $b)
            echo "<br> $a est inferieur a $b";
            else
            echo "<br> $a est egal a $b";
        
        for ($i=1; $i < 10; $i++) { 
            if ($a == 5) 
                echo '<br> '.$a. '*'. $i. '='. $a * $i;
        }
    ?>
    <?php 
        $class = [
            "etu1" => [
                "nom" => "Toure",
                "pnom" => "Abdoul",
                "age" => 21,
                "moyenne" => 15.1,
            ],
            "etu2" => [
                "nom" => "Thiam",
                "pnom" => "Omar",
                "age" => 22,
                "moyenne" => 16.2,
            ],
            "etu3" => [
                "nom" => "Niane",
                "pnom" => "Daouda",
                "age" => 23,
                "moyenne" => 15.8,
            ],
        ];

        $class["etu4"] = ["nom" => "Camara", "pnom" => "Abdou Aziz", "moyenne" => 16.1, "age" => 23];
        $nbEtu = count($class);
        echo "<br> nombbre etudiant : " . $nbEtu ;
        $TabMoy = array_column($class, "moyenne");
        $somMoy = array_sum($TabMoy);
        echo "<br> la somme des moyennes : " . $somMoy;
        $moyClass = $somMoy / $nbEtu;
        echo "<br> la moyenne générale de la classe : " . $moyClass;
        $maxMoy = max($TabMoy);
        $minMoy = min($TabMoy);
        $etudiant = array_values($class);
        $idxMax = array_search($maxMoy, $TabMoy);
        $idxMin = array_search($minMoy, $TabMoy);
        echo "<br> <strong>l’étudiant avec la meilleure moyenne :</strong>";
        echo "<br>" . $etudiant[$idxMax]["pnom"] . " " . $etudiant[$idxMax]["nom"] . " : " . $etudiant[$idxMax]["moyenne"];
        echo "<br> <strong>l’étudiant avec la plus faible moyenne :</strong>";
        echo "<br>" . $etudiant[$idxMin]["pnom"] . " " . $etudiant[$idxMin]["nom"] . " : " . $etudiant[$idxMin]["moyenne"];
        usort($class, function ($a, $b) {
            return $b['moyenne'] <=> $a['moyenne'];
        });
        echo "<br>";
        foreach($class as $cle){
            echo "<br>" . $cle["pnom"] . " " . $cle["nom"] . " : " . $cle["moyenne"] ;
        }

        // $cpt = 0;
        // foreach($class as $e => $etu){
        //     if ($etu ["moyenne"] >= 12){
        //         $cpt = $cpt + 1;
        //         echo "<br> Info de $e";
        //         foreach($etu as $cle => $val){
        //                 echo "<br> $cle : $val";
        //             }
        //     }
        //     echo "<br>";
        // }
        // echo $cpt . " étudiant(s) ont eu une moyenne >= 12";
        // $etudiant = array_values($class);
        // $bestEtu = $etudiant[0];
        // $worstEtu = $etudiant[0];
        // foreach($class as $cl ){
        //     if ($cl["moyenne"] < $worstEtu["moyenne"]){
        //         $worstEtu = $cl;
        //     } 
        //     if ($cl["moyenne"] > $worstEtu["moyenne"]){
        //         $bestEtu = $cl;
        //     }
        // }
        // echo "<br> Meilleur moyenne : <br> " . $bestEtu["nom"] . "<br>" . $bestEtu["pnom"] . "<br>" . $bestEtu["moyenne"];
        // echo "<br> Pire moyenne : <br> " . $worstEtu["nom"] . "<br>" . $worstEtu["pnom"] . "<br>" . $worstEtu["moyenne"];

        // $tabMoy = array_column($class, "moyenne");
        // $maxMoy = max($tabMoy);
        // $minMoy = min($tabMoy);
        // $etudiant = array_values($class);
        // $idxMax = array_search($maxMoy, $tabMoy);
        // $idxMin = array_search($minMoy, $tabMoy);
        // echo "<br> Meilleur etudiant : ". $etudiant[$idxMax]["nom"] . $etudiant[$idxMax]["pnom"] . $etudiant[$idxMax]["moyenne"];
        // echo "<br> Pire etudiant : ". $etudiant[$idxMin]["nom"] . $etudiant[$idxMin]["pnom"] . $etudiant[$idxMin]["moyenne"] . "<br>";
        // arsort($tabMoy);
        // foreach($tabMoy as $moy){
        //     echo $moy;
        //     echo "<br>";
        // }
        usort($class, function ($a, $b) {
            return $b['moyenne'] <=> $a['moyenne'];
        });
    ?>
    <?php
$classe = [
    "etu1" => ["nom"=>"Toure", "pnom"=>"Abdoul", "age"=>21, "moyenne"=>15.1],
    "etu2" => ["nom"=>"Thiam", "pnom"=>"Omar", "age"=>22, "moyenne"=>16.2],
    "etu3" => ["nom"=>"Niane", "pnom"=>"Daouda", "age"=>23, "moyenne"=>15.8],
    "etu4" => ["nom"=>"Camara", "pnom"=>"Abdou Aziz", "age"=>23, "moyenne"=>16.1]
];
?>

<h2>Liste des étudiants</h2>
<table>
    <tr>
        <th>Prénom</th>
        <th>Nom</th>
        <th>Âge</th>
        <th>Moyenne</th>
    </tr>

    <?php foreach($classe as $etu): ?>
    <tr>
        <td><?= $etu['pnom']; ?></td>
        <td><?= $etu['nom']; ?></td>
        <td><?= $etu['age']; ?></td>
        <td><?= $etu['moyenne']; ?></td>
    </tr>
    <?php endforeach; ?>

</table>


</body>
</html>
<!-- 
        creer un script php permetant d'avoir une fonction qui reçoit en parametre une valeur entière positive et d'afficher sa table de multiplication, la fonction retourne le message "erreur de parametre" si le parametre n'est pas une valur entière (incorect)
-->