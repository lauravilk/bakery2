<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tilaus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="tilaukset.css">

    <!-- LINKIT FONTTEIHIN-->
    <link href="https://fonts.googleapis.com/css2?family=Tangerine&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=InriaSerif&display=swap" rel="stylesheet">

</head>
<body>
    <header>
        <div>
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                  <a class="navbar-brand" href="index.html"><img id="logoimg" src="images/kanelipuu.png" width="222" height="222" alt="logo kuva"></a>
                  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                  </button>
                  <!--<div class="otsikot">-->
                  <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                      <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.html">Etusivu</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="#">Tuotteet</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="tilaukset.html">Tilaukset</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="#">Meistä</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="#">Yhteystiedot</a>
                      </li>
                      <li class="nav-item">
                        <a href="påsvenska.html" class="nav-link">
                          <img src="images/Sweden.png" width="25" height="15" alt="på svenska" class="flag">
                            på svenska
                        </a>
                      </li>
                    </ul> 
                  </div>  
                </div>
              </nav>
          </div>
        <div class="otsikko">
          <h1>
            Kahvila kanelipuu
          </h1>
          <p>
              Hyvää makua sydämellä leivottuna
          </p>
        </div>
    </header>
    <main>
        <!-- sisällö -->

        <div class="tilaususohjeet">
            <div class="tekstit">
                <h1>
                    Muokkaus
                </h1>
            </div>
        </div>    
<?php
// Tämä lomake on tarkoitettu muokkaamaan tietoja tietokannassa.
// Hakee tietokannan tiedot erillisestä salatusta tiedostosta. 
$initials=parse_ini_file(".ht.asetukset.ini"); 

$muokattava=isset($_GET["muokattava"]) ? $_GET["muokattava"] : ""; //lukee URL-osoitteesta lähetetyn muokattava-parametrin, joka kertoo, minkä tietueen tietoja ollaan muokkaamassa.

if (empty($muokattava)) { //Jos muokattava on tyhjä tai sitä ei ole, käyttäjä ohjataan takaisin haetiedot.php-sivulle.
    header("Location:haetiedot.php");
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
      exit;
  }
//Tämä kysely hakee tietokannasta kaikki kentät tilaukset-taulusta tietylle id:lle, joka saadaan URL-parametrin muokattava avulla.
    $sql="select * from tilaukset where id=?";
    $stmt=mysqli_prepare($yhteys,$sql);//Valmistellaan SQL-lause tietoturvallista suorittamista varten.
    mysqli_stmt_bind_param($stmt,"i", $muokattava);//Tämä liittää muokattava-muuttujan kyselyyn turvallisesti.
    mysqli_stmt_execute($stmt);//Suoritetaan SQL-lause 
    $tulos=mysqli_stmt_get_result($stmt);//ja haetaan tietokannasta tulos.
    if (!$rivi=mysqli_fetch_object($tulos)){//Jos ei löydy riviä (esimerkiksi ei ole olemassa sellaista id:tä),
      header("Location:./tilaukset.html");// käyttäjä ohjataan tilaukset.html-sivulle.
      exit;
  }
//Lomake lähetetään paivita.php-sivulle
?>
<form action='./paivita.php' method="post">
        <div class="form-container">
            <div class="form-group">
            <input type='hidden' id='id' name='id' value='<?php print $rivi->id;?>'><br>
                <label for="nimi">Nimi:</label>
                <input type="text" id="nimi" name="nimi" value='<?php print $rivi->nimi;?>'><br>
              </div>
              <div class="form-group">
                  <label for="osoite">Osoite:</label>
                  <input type="text" id="osoite" name="osoite" value='<?php print $rivi->osoite;?>'><br>
              </div>
              <div class="form-group">
                  <label for="puhelin">Puhelin:</label>
                  <input type="text" id="puhelin" name="puhelin" value='<?php print $rivi->puhelin;?>'><br>
              </div>
              <div class="form-group">
                  <label for="sposti">Sähköposti:</label>
                  <input type="text" id="sposti" name="sposti"  value='<?php print $rivi->sposti;?>'><br>
              </div>
              <div class="form-group">
                  <label for="tilaus">Tilaus:</label>
                  <textarea id="tilaus" name="tilaus"><?php print $rivi->tilaus;?></textarea>
              </div> 
              <div class="form-group">
                  <input type="submit" value="Valmis">
              </div>        
          </div>
      </form>
</main>

<?php
mysqli_close($yhteys);//Sulkee tietokantayhteyden, kun kaikki tarvittavat toiminnot on suoritettu.
?>

<!---FOOTERI-->
<footer>
    <div class="footer-container">
       <div class="Yhteystiedot">
           <b>Yhteystiedot</b><br>
           Kanelikujantie 5<br>
           11300 Hämeenlinna<br>
           <a href="info@kanelipuu.fi">info@kanelipuu.fi</a><br>
           +358 9653585
       </div>
       <div class="aukioloajat">
           <b>Avoinna</b><br>
           Ma - Pe 8 am - 7 pm<br>
           La 9 am - 7 pm<br>
           Sun 9 am - 6 pm
       </div>
       <div class="logo">
           <img src="images/kanelipuu.png" alt="Kanelipuu logo">
       </div>
       <div class="some">
         <img src="images/tiktok-logo.png" alt="TikTok">
         <img src="images/facebook-logo.png" alt="Facebook">
         <img src="images/instagram-logo2.png" alt="Instagram">
       </div>
    </div>

</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script>
      document.addEventListener("DOMContentLoaded", function() {
          var navbarToggler = document.querySelector(".navbar-toggler");
          var navbarCollapse = document.querySelector("#navbarNav");
          var otsikko = document.querySelector(".otsikko");

          navbarCollapse.addEventListener("show.bs.collapse", function () {
              otsikko.style.opacity = "0"; 
          });

          navbarCollapse.addEventListener("hide.bs.collapse", function () {
              otsikko.style.opacity = "1";  
          });
      });
  </script>
  </body>
</html>











