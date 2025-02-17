<?php
//Luetaan lomakkeelta tulleet tiedot funktiolla $_POST
//jos syötteet ovat olemassa
if (isset($_POST["nimi"])){ 
    $nimi=$_POST["nimi"];
}
if (isset($_POST["osoite"])){ 
    $osoite=$_POST["osoite"];
}
if (isset($_POST["puhelin"])){ 
    $puhelin=$_POST["puhelin"];
}
if (isset($_POST["sahkoposti"])){ 
    $sahkoposti=$_POST["sahkoposti"];
}

if (isset($_POST["tilaus"])){ 
    $tilaus=$_POST["tilaus"];
}

//Jos ei jompaa kumpaa tai kumpaakaan tietoa ole annettu
//ohjataan pyyntö takaisin lomakkeelle. Tarkista ehtolause.
if (!isset($nimi) || isset($osoite) || isset($puhelin) || isset($sahkoposti) || isset($tilaus)){
    header("Location: poista.php");
    exit;
}


try{
    $yhteys=mysqli_connect($initials["databaseserver"], $initials["username"], $initials["password"], $initials["database"]); 
  
    //Tarkista onko yhteys onnistunut
    if(mysqli_connect_errno()){
      throw new Exception("Yhteysvirhe: " . mysqli_connect_error());
    }
  }
  catch(Exception $e){
      header("Location:../html/yhteysvirhe.html");
      exit;
  }

//Tehdään sql-lause, jossa kysymysmerkeillä osoitetaan paikat
//joihin laitetaan muuttujien arvoja
$sql="update nimet set nimi=?, osoite=? puhelin=? sahkoposti=? tilaus=? where id=?";

//Valmistellaan sql-lause
$stmt=mysqli_prepare($yhteys, $sql);
//Sijoitetaan muuttujat oikeisiin paikkoihin
mysqli_stmt_bind_param($stmt, 'sdi', $nimi, $osoite, $puhelin, $sahkoposti,$tilaus, $id);
//Suoritetaan sql-lause
mysqli_stmt_execute($stmt);
//Suljetaan tietokantayhteys
mysqli_close($yhteys);

header("Location:./poista.php");
exit;
?>

  