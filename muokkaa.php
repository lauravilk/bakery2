<?php
include "header.html"
?>

<?php
if (isset($_GET["muokattava"])) {
    $muokattava=$_GET["muokattava"];
}

if (!isset($muokattava)) {
    header("Location:./tallennatilaukset.php");
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

    $sql="select * from kala where id=?";
    $stmt=mysqli_prepare($yhteys,$sql);
    mysqli_stmt_bind_param($stmt,"i", $muokattava);
    mysqli_stmt_execute($stmt);
    $tulos=mysqli_stmt_get_result($stmt);

if ($rivi=mysqli_fetch_object($tulos)) {
?>
<h2>Fill in</h2>
<form action='paivita.php' method='post'>
<input type='hidden' id='id' name='id' value='<?php print $rivi->id;?>'><br>
nimi:<input type='text' id='nimi' name='nimi' value='<?php print $rivi->nimi;?>'><br>
Osoite:<input type='text' id='osoite' name='osoite' value='<?php print $rivi->Osoite;?>'><br>
Puhelinumero:<input type='text' id='puhelin' name='puhelin' value='<?php print $rivi->puhelinumero;?>'><br>
Sähköposti:<input type='text' id='sposti' name='sposti' value='<?php print $rivi->Sähköposti;?>'><br>
Tilauksen tiedot:<textarea id='tilaus' name='tilaus'value='<?php print $rivi->Tilaus;?>'></textarea><br>
<input type='submit' value='Lähetä'><br>
</form>
<?php

}
    

?>










