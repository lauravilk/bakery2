<?php
// TÄMÄ LOMAKE TALLENTAA TIEDOT TIETOKANTAAN

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try{
    //https://www.php.net/manual/en/function.mysqli-connect.php
    $yhteys=mysqli_connect("localhost", "trtkp24_5", "xAsFu8yG", "trtkp24_5");

    // Tarkista onko yhteys onnistunut
    if (mysqli_connect_errno()) {
        throw new Exception("Yhteysvirhe: " . mysqli_connect_error());
    }
}
catch(Exception $e){
    header("Location:../html/yhteysvirhe.html");
    exit;
}

/*luetaan tiedot lomakkeelta */
$nimi=isset($_POST["nimi"]) ? $_POST["nimi"] :"";
$osoite=isset($_POST["osoite"]) ? $_POST["osoite"] :"";
$puhelin=isset($_POST["puhelin"]) ? $_POST["puhelin"] :"0";
$sposti=isset($_POST["sposti"]) ? $_POST["sposti"] :"";
$tilaus=isset($_POST["tilaus"]) ? $_POST["tilaus"] :"";

/*tallennetaan tiedot tietokantaan */
$sql="insert into tilaukset (nimi, osoite, puhelin, sposti, tilaus) values(?, ?, ?, ?, ?)";
$stmt=mysqli_prepare($yhteys, $sql);

// Tarkista, että valmistelu onnistui
if (!$stmt) {
    die("Virhe SQL-lauseessa: " . mysqli_error($yhteys));
}

mysqli_stmt_bind_param($stmt, 'ssiss', $nimi, $osoite, $puhelin, $sposti, $tilaus); /*sd = s=string, d=desimaaliluku */

// Suoritetaan kysely ja tarkistetaan mahdolliset virheet
if (!mysqli_stmt_execute($stmt)) {
    die("Virhe tietojen tallennuksessa: " . mysqli_stmt_error($stmt));
}

//ysqli_stmt_execute($stmt);

header("Location:./kiitostilauksesta.php"); /*siirtyy halutulle sivulle*/
?>