<?php
// Hakee tietokannan tiedot erillisestä salatusta tiedostosta 
$initials=parse_ini_file(".ht.asetukset.ini"); 

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
$poistettava=isset($_GET["poistettava"]) ? $_GET["poistettava"] :"";
  if (!empty($poistettava)){
    $sql="delete from tilaukset where id=?";
    $stmt=mysqli_prepare($yhteys,$sql);
    mysqli_stmt_bind_param($stmt,"i", $poistettava);
    mysqli_stmt_execute($stmt);
   }
header("Location:./haetiedot.php");
exit;
?>

