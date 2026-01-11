<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post">
        <div>
            <label for="">Entrez un nombre : </label>
            <input type="text" name="val">
            <button type="submit" name="btn1">afficher table</button>
        </div>
    </form>
    <?php  
        if (isset($_POST['btn1'])) {
            $nombre = $_POST['val'];
            TableMul($nombre);
        }
        function TableMul($nb){
            for($i=1; $i<11; $i++){
                echo $nb . " * " . $i . " = " . $nb * $i . "<br>";
            }
        }
    ?>
</body>
</html>