<?php
if (isset($_GET['productid'])) {
    $ProductId = $_GET['productid'];
    $servernaam = 'localhost';
    $gerbruikersnaam = 'root';
    $wachtwoord = '';
    $dbnaam = 'php_examen1';

    $connectie = new mysqli($servernaam, $gerbruikersnaam, $wachtwoord, $dbnaam);
    if ($connectie->connect_error) {
        die('Connection failed: ' . $connectie->connect_error);
    }

    $sql = 'SELECT ProductId, ProductOmschrijving, ProductPrijs, ProductAantalInVoorraad ' .
        'FROM producten ' .
        'WHERE ProductId=' . $ProductId;
    $result = $connectie->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $ProductOmschrijving = $row['ProductOmschrijving'];
            $ProductPrijs = $row['ProductPrijs'];
            $ProductAantalInVoorraad = $row['ProductAantalInVoorraad'];
        }
        $connectie->close();
    } else {
        echo 'Er is geen product terug te vinden met ProductId = ' . $ProductId . '!<br>';
        echo 'Ga terug naar het <a href="index.php">overzicht</a>';
        $connectie->close();
        exit();
    }
} else {
    //als er geen id is meegegeven in de URL
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Verwijderen</title>
</head>

<body>
    <h1>Product verwijderen</h1>
    <form action="index.php" method="POST">
        <input type="hidden" name="todo" value="verwijderen">
        ProductId:<br>
        <input type="text" name="ProductId" value="<?php echo $ProductId; ?>" readonly>
        <br>
        ProductOmschrijving:<br>
        <input type="text" name="ProductOmschrijving" value="<?php echo $ProductOmschrijving; ?>" readonly>
        <br>
        ProductPrijs:<br>
        <input type="text" name="ProductPrijs" value="<?php echo $ProductPrijs; ?>" readonly>
        <br>
        ProductAantalInVoorraad:<br>
        <input type="text" name="ProductAantalInVoorraad" value="<?php echo $ProductAantalInVoorraad; ?>" readonly>
        <br>
        <br>
        <input type="submit" value="Bevestig verwijderen">
    </form>
</body>

</html>
