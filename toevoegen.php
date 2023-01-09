<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Toevoegen</title>
</head>
<body>
  <h2>Product toevoegen</h2>
  <form action="index.php" method="POST">
  <input type="hidden" name="todo" value="toevoegen">
        ProductOmschrijving:<br>
        <input type="text" name="ProductOmschrijving" placeholder="ProductOmschrijving">
        <br>
        ProductPrijs:<br>
        <input type="text" name="ProductPrijs" placeholder="ProductPrijs">
        <br>
        ProductAantalInVoorraad:<br>
        <input type="text" name="ProductAantalInVoorraad" placeholder="ProductAantalInVoorraad">
        <br>
        <br>
        <input type="submit" value="Bevestig toevoegen">
    </form>
</body>
</html>