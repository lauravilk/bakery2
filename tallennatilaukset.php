<?php
// TÄMÄ LOMAKE TALLENTAA TIEDOT TIETOKANTAAN

error_reporting(E_ALL ^ E_WARNING);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Hakee tietokannan tiedot erillisestä salatusta tiedostosta
$initials=parse_ini_file(".ht.asetukset.ini");

try{
    $yhteys=mysqli_connect($initials["databaseserver"], $initials["username"], $initials["password"], $initials["database"]);
    //$yhteys=mysqli_connect("localhost", "trtkp24_5", "xAsFu8yG", "trtkp24_5");

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
$puhelin=isset($_POST["puhelin"]) ? $_POST["puhelin"] :"";
$sposti=isset($_POST["sposti"]) ? $_POST["sposti"] :"";
$tilaus=isset($_POST["tilaus"]) ? $_POST["tilaus"] :"";

/*tallennetaan tiedot tietokantaan */
$sql="insert into tilaukset (nimi, osoite, puhelin, sposti, tilaus) values(?, ?, ?, ?, ?)";
$stmt=mysqli_prepare($yhteys, $sql);

// Tarkista, että valmistelu onnistui
if (!$stmt) {
    die("Virhe SQL-lauseessa: " . mysqli_error($yhteys));
}

mysqli_stmt_bind_param($stmt, 'sssss', $nimi, $osoite, $puhelin, $sposti, $tilaus); /*sd = s=string, d=desimaaliluku */

// Suoritetaan kysely ja tarkistetaan mahdolliset virheet
if (!mysqli_stmt_execute($stmt)) {
    die("Virhe tietojen tallennuksessa: " . mysqli_stmt_error($stmt));
}

//ysqli_stmt_execute($stmt);

header("Location:./kiitostilauksesta.html"); /*siirtyy halutulle sivulle*/
?>