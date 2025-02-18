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

        <div class="tilausohjeet">
            <div class="tekstit">
                <h1>
                  
                Tilaukset
              </h1>
          </div>
     </div>    
 <?php
 // TULOSTAA LOMAKKEEN TIEDOT

// Hakee tietokannan tiedot erillisestä salatusta tiedostosta
$initials=parse_ini_file(".ht.asetukset.ini"); 

try{
  $yhteys=mysqli_connect($initials["databaseserver"], $initials["username"], $initials["password"], $initials["database"]); 

  //Tarkista onko yhteys onnistunut
  if (mysqli_connect_errno()){
    throw new Exception("Yhteysvirhe: " . mysqli_connect_error());
  }
}
catch(Exception $e){
    header("Location:../html/yhteysvirhe.html");
    exit;
}

$tulos=mysqli_query($yhteys, "select * from tilaukset");

print "<div class='container mt-4'>";
print "<table class='table table-bordered'>";
print "<thead class='table-light'>";
print "<tr><th>Id</th><th>Nimi</th><th>Osoite</th><th>Puhelin</th><th>Sähköposti</th><th>Tiedot</th><th>Toiminnot</th></tr>";
print "</thead>";
print "<tbody>";

while ($rivi = mysqli_fetch_object($tulos)) {
  print "<tr>";
  print "<td>{$rivi->id}</td>";
  print "<td>{$rivi->nimi}</td>";
  print "<td>{$rivi->osoite}</td>";
  print "<td>{$rivi->puhelin}</td>";
  print "<td>{$rivi->sposti}</td>";
  print "<td>{$rivi->tilaus}</td>";
  print "<td>
      <a href='./poista.php?poistettava=".$rivi->id."'>Poista</a><br>
      <a href='./muokkaa.php?muokattava=".$rivi->id."'>Muokkaa</a><br>
        </td>";
  print "</tr>";
}

print "</tbody>";
print "</table>";
print "</div>";


$ok=mysqli_close($yhteys);

?>
</main>

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
