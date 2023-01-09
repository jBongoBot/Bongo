<?php
$tekst = '';
if (isset($_GET['getal1']) && isset($_GET['getal2'])) {
    $getal1 = (float)$_GET['getal1'];
    $getal2 = (float)$_GET['getal2'];

    $resultaat = $getal1 + $getal2;
    $tekst .= '<p>' . $getal1 . ' + ' . $getal2 . ' = ' . $resultaat . '</p>';
    $resultaat = $getal1 - $getal2;
    $tekst .= '<p>' . $getal1 . ' - ' . $getal2 . ' = ' . $resultaat . '</p>';
    $resultaat = $getal1 * $getal2;
    $tekst .= '<p>' . $getal1 . ' * ' . $getal2 . ' = ' . $resultaat . '</p>';
    $resultaat = $getal1 / $getal2;
    $tekst .= '<p>' . $getal1 . ' / ' . $getal2 . ' = ' . $resultaat . '</p>';
    $resultaat = ($getal1 / 100) * $getal2;
    $tekst .= '<p>' . $getal1 . ' % ' . $getal2 . ' = ' . $resultaat . '</p>';
} ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oef01</title>
</head>

<body>
    <h1>Oefening 01</h1>
    <?php echo $tekst ?>
    <form action="index.php" method="get">
        <input type="number" name="getal1" value="" size="30" placeholder="">
        <input type="number" name="getal2" value="" size="30" placeholder="">
        <br><br>
        <input type="hidden" name="viaIndex" value="true">
        <input type="submit" name="oplossen" value="Oplossen">
    </form>
</body>

</html>