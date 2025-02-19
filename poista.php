<?php
//Tämä käsittelee tietokannasta tietojen poistamisen URL-parametrin perusteella.
// Hakee tietokannan tiedot erillisestä salatusta tiedostosta 
$initials=parse_ini_file(".ht.asetukset.ini"); //Tiedosto sisältää tietokannan tiedot (palvelin, käyttäjätunnus, salasana ja tietokannan nimi).
//Yhteyden muodostaminen tietokantaan
try{
  $yhteys=mysqli_connect($initials["databaseserver"], $initials["username"], $initials["password"], $initials["database"]); 

  //Tarkista onko yhteys onnistunut
  if(mysqli_connect_errno()){
    throw new Exception("Yhteysvirhe: " . mysqli_connect_error());
  }
}//Poikkeuksen käsittely
catch(Exception $e){
    header("Location:../html/yhteysvirhe.html");
    exit;
}
//Poistettavan tiedon tarkistus
$poistettava=isset($_GET["poistettava"]) ? $_GET["poistettava"] :"";//isset() tarkistaa, onko URL-parametri poistettava asetettu Jos poistettava löytyy,se tallennetaan muuttujaan $poistettava Jos sitä ei ole, muuttujalle annetaan tyhjä merkkijono ("").
  if (!empty($poistettava)){ //Tiedon poistaminen tietokannasta:Tarkistetaan, onko "$poistettava" muuttuja tyhjä Jos se ei ole tyhjä, suoritetaan poisto-operaatio.                                   
    $sql="delete from tilaukset where id=?";//Poistaa rivin tilaukset-taulusta, jossa id vastaa annettua arvoa.
    $stmt=mysqli_prepare($yhteys,$sql);//mysqli_prepare() valmistelee SQL-lauseen suoritettavaksi.
    mysqli_stmt_bind_param($stmt,"i", $poistettava);//mysqli_stmt_bind_param() sitoo muuttujan SQL-lauseen paikkamerkkiin.
    mysqli_stmt_execute($stmt);//Poistokyselyn suorittaminen:mysqli_stmt_execute() suorittaa valmistellun SQL-lauseen, Tässä kohtaa rivi poistetaan tietokannasta, jos se löytyy.
   }

header("Location:./haetiedot.php");//header() uudelleenohjaa käyttäjän haetiedot.php-sivulle.
exit;//exit; pysäyttää skriptin suorituksen, jotta muu koodi ei enää suoritu.
?>

