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

    $sql = 'SELECT ProductOmschrijving, ProductPrijs, ProductAantalInVoorraad ' .
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
    <title>Wijzigen</title>
</head>

<body>
<h1>Product wijzigen</h1>
    <form action="index.php" method="POST">
        <input type="hidden" name="todo" value="wijzigen">
        Id:<br>
        <input type="text" value="<?php echo $ProductId; ?>" name="ProductId" readonly>
        <br>
        ProductOmschrijving:<br>
        <input type="text" name="ProductOmschrijving" placeholder="ProductOmschrijving" value="<?php echo $ProductOmschrijving; ?>">
        <br>
        ProductPrijs:<br>
        <input type="text" name="ProductPrijs" placeholder="ProductPrijs" value="<?php echo $ProductPrijs; ?>">
        <br>
        ProductAantalInVoorraad:<br>
        <input type="text" name="ProductAantalInVoorraad" placeholder="ProductAantalInVoorraad" value="<?php echo $ProductAantalInVoorraad; ?>">
        <br>
        <br>
        <input type="submit" value="Bevestig wijzigen">
    </form>
</body>

</html>