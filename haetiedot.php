<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try{
    //https://www.php.net/manual/en/funtion.mysqli-connesct.php
    $yhteys=mysqli_connect("localhost", "trtkp24_5", "xAsFu8yG", "trtkp24_5");
}
catch(Exception $e){
    header("Location:../html/yhteysvirhe.html");
    exit;
}

$tulos=mysqli_query($yhteys,"select * from tilaukset");

while ($rivi=mysqli_fetch_object($tulos)){
    print "nimi=$rivi->nimi Osoite=$rivi->osoite puhelin=$rivi->puhelin sahkoposti=$rivi->sahkoposti tilaukset=$rivi->tilaukset". 
    "<a href='./poista.php?id=$rivi->id'>Poista</a><br>".
    "<a href='./muokkaa.php?id=$rivi->id'>muokkaa</a><br>";

}
$ok=mysqli_close($yhteys);
?>
