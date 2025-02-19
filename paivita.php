<?php
//Tässä lomakkeessa käsitellään tietojen päivittämistä tietokannassa.

// Hakee tietokannan tiedot erillisestä salatusta tiedostosta 
$initials=parse_ini_file(".ht.asetukset.ini"); 

//Luetaan lomakkeelta tulleet tiedot funktiolla $_POST jos syötteet ovat olemassa
$id=isset($_POST["id"]) ? $_POST["id"] : "";
$nimi=isset($_POST["nimi"]) ? $_POST["nimi"] : "";
$osoite=isset($_POST["osoite"]) ? $_POST["osoite"] : "";
$puhelin=isset($_POST["puhelin"]) ? $_POST["puhelin"] : "";
$sahkoposti=isset($_POST["sposti"]) ? $_POST["sposti"] : "";
$tilaus=isset($_POST["tilaus"]) ? $_POST["tilaus"] : 0;

//Jos ei jompaa kumpaa tai kumpaakaan tietoa ole annettu ohjataan pyyntö takaisin lomakkeelle. Tarkista ehtolause.
if (empty($id) || empty($nimi) || empty($osoite) || empty($puhelin) || empty($sahkoposti) || empty($tilaus)){
    header("Location: haetiedot.php");
    exit;
}
//Yhteyden muodostaminen tietokantaan
try{
    $yhteys=mysqli_connect($initials["databaseserver"], $initials["username"], $initials["password"], $initials["database"]); 
  
    //Tarkista onko yhteys onnistunut
    if(mysqli_connect_errno()){
      throw new Exception("Yhteysvirhe: " . mysqli_connect_error());
    }
  }
  catch(Exception $e){
      header("Location:../html/yhteysvirhe.html");
      exit; //ja suoritus lopetetaan exit;-komennolla.
  }

//Tehdään sql-lause, jossa kysymysmerkeillä osoitetaan paikat joihin laitetaan muuttujien arvoja.
$sql="update tilaukset set nimi=?, osoite=?, puhelin=?, sposti=?, tilaus=? where id=?";
$stmt=mysqli_prepare($yhteys, $sql);//Valmistellaan sql-lause
mysqli_stmt_bind_param($stmt, 'sssssi', $nimi, $osoite, $puhelin, $sahkoposti,$tilaus,$id);//Sijoitetaan muuttujat oikeisiin paikkoihin
mysqli_stmt_execute($stmt);//Suoritetaan sql-lause
mysqli_close($yhteys);//Suljetaan tietokantayhteys

header("Location:./haetiedot.php");//Ohjaa käyttäjän toiseen sivuun tässä tapauksessa haetiedot.php.
?>

  