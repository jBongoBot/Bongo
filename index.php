<?php
$htmlTabel = '';
if (isset($_POST['alles'])) {
    $htmlTabel = AllesTonen();
}
if (!isset($_POST['alles']) && !isset($_POST['filteren'])) {
    $htmlTabel = AllesTonen();
}
if (isset($_POST['filteren'])) {
    if (!isset($_POST['chkOmschrijving']) && !isset($_POST['chkPrijs'])) {
        $htmlTabel = '<h3>Bij filteren, vink 1 van de 2 mogelijkheden aan.</h3>';
    }
    if (isset($_POST['chkOmschrijving']) && !isset($_POST['chkPrijs'])) {
        $htmlTabel = FilterenOpOmschrijving($_POST['txtOmschrijving']);
    }
    if (!isset($_POST['chkOmschrijving']) && isset($_POST['chkPrijs'])) {
        $htmlTabel = FilterenOpPrijs($_POST['txtPrijsMinimum'], $_POST['txtPrijsMaximum']);
    }
    if (isset($_POST['chkOmschrijving']) && isset($_POST['chkPrijs'])) {
        $htmlTabel = FilterenOpOmschrijvingEnPrijs($_POST['txtOmschrijving'], $_POST['txtPrijsMinimum'], $_POST['txtPrijsMaximum']);
    }
}
function AllesTonen()
{
    $servernaam = 'localhost';
    $gebruikersnaam = 'root';
    $wachtwoord = '';
    $dbnaam = 'php_examen1';

    // Create connection
    $connectie = new mysqli($servernaam, $gebruikersnaam, $wachtwoord, $dbnaam);
    // Check connection
    if ($connectie->connect_error) {
        die('Connection failed: ' . $connectie->connect_error);
    }

    // html-tabel met albums vullen - START
    $sql = 'SELECT ProductId, ProductOmschrijving, ProductPrijs, ProductAantalInVoorraad FROM producten';
    $sqlStatement = $connectie->prepare($sql);
    if ($sqlStatement->execute() === true) {
        $sqlStatement->bind_result(
            $ProductId,
            $ProductOmschrijving,
            $ProductPrijs,
            $ProductAantalInVoorraad
        );
        $htmlTabel = '<table class="table table-primary table-hover">';
        $htmlTabel .= '<tr>' .
            '<th>Id</th>' .
            '<th>Omschrijving</th>' .
            '<th style="text-align: center">Prijs</th>' .
            '<th style="text-align: center">Aantal In Voorraad</th>' .
            '<th></th>' .
            '<th></th>';
        $htmlTabel .= '</tr>';
        while ($sqlStatement->fetch()) {
            $htmlTabel .= '<tr>' .
                '<td>' . $ProductId . '</td>' .
                '<td>' . $ProductOmschrijving . '</td>' .
                '<td style="text-align: right">' . $ProductPrijs . '</td>' .
                '<td style="text-align: center">' . $ProductAantalInVoorraad . '</td>' .
                '<td><a href="wijzigen.php?productid=' . $ProductId . '"><i class=" fas fa-pencil-alt"></i></a></td>' .
                '<td><a href="verwijderen.php?productid=' . $ProductId . '"><i class="fas fa-trash"></i></a></td>' .
            '</tr>';
        }
        $htmlTabel .= '</table>';
        if ($sqlStatement->num_rows < 1) {
            $htmlTabel = 'Er zijn geen producten terug te vinden!';
        }
    }
    // html-tabel met albums vullen - STOP
    return $htmlTabel;
}

function FilterenOpOmschrijving($omschrijving)
{
    $servernaam = 'localhost';
    $gebruikersnaam = 'root';
    $wachtwoord = '';
    $dbnaam = 'php_examen1';

    // Create connection
    $connectie = new mysqli($servernaam, $gebruikersnaam, $wachtwoord, $dbnaam);
    // Check connection
    if ($connectie->connect_error) {
        die('Connection failed: ' . $connectie->connect_error);
    }

    // html-tabel met albums vullen - START
    $sql = 'SELECT ProductId, ProductOmschrijving, ProductPrijs, ProductAantalInVoorraad FROM producten ' .
        'WHERE ProductOmschrijving LIKE ?';
    $sqlStatement = $connectie->prepare($sql);
    $zoekOmschrijving = '%' . $omschrijving . '%';
    $sqlStatement->bind_param(
        's',
        $zoekOmschrijving
    );
    if ($sqlStatement->execute() === true) {
        $sqlStatement->bind_result(
            $ProductId,
            $ProductOmschrijving,
            $ProductPrijs,
            $ProductAantalInVoorraad
        );
        $htmlTabel = '<table class="table table-primary table-hover">';
        $htmlTabel .= '<tr>' .
            '<th>Id</th>' .
            '<th>Omschrijving</th>' .
            '<th style="text-align: center">Prijs</th>' .
            '<th style="text-align: center">Aantal In Voorraad</th>' .
            '<th></th>' .
            '<th></th>';
        $htmlTabel .= '</tr>';
        while ($sqlStatement->fetch()) {
            $htmlTabel .= '<tr>' .
                '<td>' . $ProductId . '</td>' .
                '<td>' . $ProductOmschrijving . '</td>' .
                '<td>' . $ProductPrijs . '</td>' .
                '<td style="text-align: center">' . $ProductAantalInVoorraad . '</td>' .
                '<td><a href="wijzigen.php?productid=' . $ProductId . '"><i class=" fas fa-pencil-alt"></i></a></td>' .
                '<td><a href="verwijderen.php?productid=' . $ProductId . '"><i class="fas fa-trash"></i></a></td>' .
                '</tr>';
        }
        $htmlTabel .= '</table>';
        if ($sqlStatement->num_rows < 1) {
            $htmlTabel = 'Er zijn geen producten terug te vinden van ' . $omschrijving;
        }
    }
    // html-tabel met albums vullen - STOP
    return $htmlTabel;
}

function FilterenOpPrijs($min, $max)
{
    $servernaam = 'localhost';
    $gebruikersnaam = 'root';
    $wachtwoord = '';
    $dbnaam = 'php_examen1';

    // Create connection
    $connectie = new mysqli($servernaam, $gebruikersnaam, $wachtwoord, $dbnaam);
    // Check connection
    if ($connectie->connect_error) {
        die('Connection failed: ' . $connectie->connect_error);
    }

    // html-tabel met albums vullen - START
    $sql = 'SELECT ProductId, ProductOmschrijving, ProductPrijs, ProductAantalInVoorraad FROM producten ' .
        'WHERE ProductPrijs >= ? AND ProductPrijs <= ?';
    $sqlStatement = $connectie->prepare($sql);

    $sqlStatement->bind_param(
        'dd',
        $min,
        $max
    );
    if ($sqlStatement->execute() === true) {
        $sqlStatement->bind_result(
            $ProductId,
            $ProductOmschrijving,
            $ProductPrijs,
            $ProductAantalInVoorraad
        );
        $htmlTabel = '<table class="table table-primary table-hover">';
        $htmlTabel .= '<tr>' .
            '<th>Id</th>' .
            '<th>Omschrijving</th>' .
            '<th style="text-align: center">Prijs</th>' .
            '<th style="text-align: center">Aantal In Voorraad</th>' .
            '<th></th>' .
            '<th></th>';
        $htmlTabel .= '</tr>';
        while ($sqlStatement->fetch()) {
            $htmlTabel .= '<tr>' .
                '<td>' . $ProductId . '</td>' .
                '<td>' . $ProductOmschrijving . '</td>' .
                '<td>' . $ProductPrijs . '</td>' .
                '<td style="text-align: center">' . $ProductAantalInVoorraad . '</td>' .
                '<td><a href="wijzigen.php?productid=' . $ProductId . '"><i class=" fas fa-pencil-alt"></i></a></td>' .
                '<td><a href="verwijderen.php?productid=' . $ProductId . '"><i class="fas fa-trash"></i></a></td>' .
                '</tr>';
        }
        $htmlTabel .= '</table>';
        if ($sqlStatement->num_rows < 1) {
            $htmlTabel = 'Er zijn geen producten terug te vinden tussen ' . $min . ' en ' . $max;
        }
    }
    // html-tabel met albums vullen - STOP
    return $htmlTabel;
}

function FilterenOpOmschrijvingEnPrijs($omschrijving, $min, $max)
{
    $servernaam = 'localhost';
    $gebruikersnaam = 'root';
    $wachtwoord = '';
    $dbnaam = 'php_examen1';

    // Create connection
    $connectie = new mysqli($servernaam, $gebruikersnaam, $wachtwoord, $dbnaam);
    // Check connection
    if ($connectie->connect_error) {
        die('Connection failed: ' . $connectie->connect_error);
    }

    // html-tabel met albums vullen - START
    $sql = 'SELECT ProductId, ProductOmschrijving, ProductPrijs, ProductAantalInVoorraad FROM producten ' .
        'WHERE ProductOmschrijving LIKE ? AND ProductPrijs >= ? AND ProductPrijs <= ?';
    $sqlStatement = $connectie->prepare($sql);
    $zoekOmschrijving = '%' . $omschrijving . '%';
    $sqlStatement->bind_param(
        'sdd',
        $zoekOmschrijving,
        $min,
        $max
    );
    if ($sqlStatement->execute() === true) {
        $sqlStatement->bind_result(
            $ProductId,
            $ProductOmschrijving,
            $ProductPrijs,
            $ProductAantalInVoorraad
        );
        $htmlTabel = '<table class="table table-primary table-hover">';
        $htmlTabel .= '<tr>' .
            '<th>Id</th>' .
            '<th>Omschrijving</th>' .
            '<th style="text-align: center">Prijs</th>' .
            '<th style="text-align: center">Aantal In Voorraad</th>' .
            '<th></th>' .
            '<th></th>';
        $htmlTabel .= '</tr>';
        while ($sqlStatement->fetch()) {
            $htmlTabel .= '<tr>' .
                '<td>' . $ProductId . '</td>' .
                '<td>' . $ProductOmschrijving . '</td>' .
                '<td>' . $ProductPrijs . '</td>' .
                '<td style="text-align: center">' . $ProductAantalInVoorraad . '</td>' .
                '<td><a href="wijzigen.php?productid=' . $ProductId . '"><i class=" fas fa-pencil-alt"></i></a></td>' .
                '<td><a href="verwijderen.php?productid=' . $ProductId . '"><i class="fas fa-trash"></i></a></td>' .
                '</tr>';
        }
        $htmlTabel .= '</table>';
        if ($sqlStatement->num_rows < 1) {
            $htmlTabel = 'Er zijn geen producten terug te vinden van ' . $omschrijving . ' tussen ' . $min . ' en ' . $max;
        }
    }
    return $htmlTabel;
}

// BEGIN todo = verwijderen of wijzigen of toevoegen
$servernaam = 'localhost';
$gebruikersnaam = 'root';
$wachtwoord = '';
$dbnaam = 'php_examen1';

// Create connection
$connectie = new mysqli($servernaam, $gebruikersnaam, $wachtwoord, $dbnaam);
// Check connection
if ($connectie->connect_error) {
    die('Connection failed: ' . $connectie->connect_error);
}

if (isset($_POST['todo'])) {
    if (isset($_POST['ProductId'])) {
        $ProductId = $_POST['ProductId'];
    }
    $ProductOmschrijving = $_POST['ProductOmschrijving'];
    $ProductPrijs = $_POST['ProductPrijs'];
    $ProductAantalInVoorraad = $_POST['ProductAantalInVoorraad'];

    // VERWIJDEREN
    if ($_POST['todo'] == 'verwijderen') {
        // sql to delete a record
        $sql = 'DELETE FROM producten WHERE ProductId=?';
        $sqlStatement = $connectie->prepare($sql);
        $sqlStatement->bind_param(
            'i',
            $ProductId
        );
        if ($sqlStatement->execute() === true) {
            echo 'Product succesvol verwijderd';
            header('Location: index.php');
        } else {
            echo 'Fout bij het verwijderen van de product: ' . $connectie->error;
            exit;
        }
    }
    // WIJZIGEN
    if ($_POST['todo'] == 'wijzigen') {
        $sql = 'UPDATE producten SET ' .
            'ProductOmschrijving=? , ' .
            'ProductPrijs=? , ' .
            'ProductAantalInVoorraad=? ' .
            'WHERE ProductId=?';
        $sqlStatement = $connectie->prepare($sql);
        $sqlStatement->bind_param(
            'sdii',
            $ProductOmschrijving,
            $ProductPrijs,
            $ProductAantalInVoorraad,
            $ProductId
        );
        if ($sqlStatement->execute() === true) {
            echo 'Product succesvol gewijzigd';
            header('Location: index.php');
        } else {
            echo 'Fout bij het wijzigen van de product: ' . $connectie->error;
        }
    }

    // TOEVOEGEN
    if ($_POST['todo'] == 'toevoegen') {
        $sql = 'INSERT INTO producten (ProductOmschrijving, ProductPrijs, ProductAantalInVoorraad) ' .
            'VALUES (? , ? , ?   )';
        $sqlStatement = $connectie->prepare($sql);
        $sqlStatement->bind_param(
            'sdi',
            $ProductOmschrijving,
            $ProductPrijs,
            $ProductAantalInVoorraad,
        );
        if ($sqlStatement->execute() === true) {
            echo 'Product succesvol toegevoegd';
            header('Location: index.php');
        } else {
            echo 'Fout bij het toevoegen van de product: ' . $connectie->error;
        }
    }
}
?>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Producten</title>

    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="js/jquery.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
    <link href="css/fontawesome.css" rel="stylesheet" type="text/css">
    <link href="css/mijnOpmaak.css" rel="stylesheet">
</head>

<body>
<div class="container">
        <h1>Producten</h1>
        <?php echo $htmlTabel ?>
        <h4><a href="toevoegen.php">Toevoegen product</a></h4>
        <hr>
        <h4>Gegevens tonen</h4>
        <p class="text-left mb-4">
            Klik op "Alles tonen", of vul de gegevens in en klik op "Filteren op".
        </p>
        <form action="index.php" method="POST">
            <div class="border border-dark p-3 mb-2">
                <p class="text-justify mb-4">
                    Alles tonen!
                </p>
                <input type="hidden" name="alles" id="alles" value="true">
                <button type="submit" class="btn btn-primary">Alles tonen</button>
            </div>
        </form>
        <form action="index.php" method="POST">
            <div class="border border-dark p-3 mb-2">
                <div class="form-group custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input form-control" name="chkOmschrijving" id="chkOmschrijving">
                    <label class="custom-control-label" for="chkOmschrijving">Filteren op omschrijving</label>
                </div>
                <div class="form-group custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input form-control" name="chkPrijs" id="chkPrijs">
                    <label class="custom-control-label" for="chkPrijs">Filteren op prijs (tussen minimum en maximum)</label>
                </div>
                <p class="text-justify mb-4">
                    Filteren op:
                </p>
                <div class="form-group">
                    <label for="txtOmschrijving">Geef de omschrijving of een deel van de omschrijving:</label>
                    <input type="text" class="form-control" name="txtOmschrijving" id="txtOmschrijving" placeholder="Omschrijving">
                </div>
                <div class="form-group">
                    <label for="txtPrijsMinimum">Geef de minimum prijs:</label>
                    <input type="number" class="form-control" name="txtPrijsMinimum" id="txtPrijsMinimum" placeholder="Prijs minimum" value="100.00" step=".01">
                </div>
                <div class="form-group">
                    <label for="txtPrijsMaximum">Geef de maximum prijs:</label>
                    <input type="number" class="form-control" name="txtPrijsMaximum" id="txtPrijsMaximum" placeholder="Prijs maximum" value="500.00" step=".01">
                </div>

                <input type="hidden" name="filteren" id="filteren" value="true">
                <button type="submit" class="btn btn-primary">Filteren op</button>
        </form>

    </div>
</body>

</html>