<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>cinema</title>
        <link rel="stylesheet" href="./style.css">
    </head>
    <body>

<form methode = "GET">
        <input type="search" name = "movie" placeholder= "titre"/>
        <input type="search" name = "genre" placeholder = "genre"/>
        <input type="search" name = "distrib" placeholder = "distribution"/>
        <input type="hidden" name = "hidden"/>
        <input type="submit" value="Envoyer" />
 </form><br>

 <?php

        // gestion de la requette sql 

    $dbh = new PDO("mysql:host=localhost;dbname=cinema", "meriem", "wac");

    $requete = "SELECT titre, distrib.nom, genre.nom AS \"genre\" FROM film LEFT JOIN genre ON film.id_genre = genre.id_genre LEFT JOIN distrib ON film.id_distrib = distrib.id_distrib";

    // $nbr_elem = 0;
    $elem_affiche = 5;

        
    if (isset($_GET["hidden"])) {

        $movie = $_GET["movie"];
        $genre = $_GET["genre"];
        $distrib = $_GET["distrib"];

            
        if (!empty($_GET["movie"])){
            $requete = $requete . " WHERE titre LIKE \"%" . $_GET["movie"] . "%\"";
        }
            
        if (!empty($_GET["genre"])){
            $requete = (strpos($requete, "LIKE")) ? $requete . "  AND genre.nom LIKE \"%" . $_GET["genre"] . "%\"" : $requete . " WHERE genre.nom LIKE \"%" . $_GET["genre"] . "%\"";
        }
            
        if (!empty($_GET["distrib"])) {
            $requete = (strpos($requete, "LIKE")) ? $requete . "  AND distrib.nom LIKE \"%" . $_GET["distrib"] . "%\"" : $requete . " WHERE distrib.nom LIKE \"%" . $_GET["distrib"] . "%\"";
        }

        $all_row = $dbh->query($requete);
        $nbr_elem = $all_row -> rowCount();
        $nombre_page = ceil($nbr_elem / $elem_affiche);
        if (isset($_GET["page"]) && !empty($_GET["page"])) {
            $page = $_GET["page"];
        }
        else {
            $page = 1;
        }
        $offset = ($page-1)*$elem_affiche;

        $by_name = $requete . " ORDER BY titre LIMIT $offset, $elem_affiche";
            
        
        
        $querry = $dbh->query($by_name);
        
        
        // echo $by_name . "<br><br>";
        echo "resultat trouver $nbr_elem  <br><br> nombre de page $nombre_page <br>";
        ?>

<!-- affichage du resultat de recherche -->
<table>
    
    <tr class ="tri">
        <td>titre</td>
        <td>genre</td>
        <td>distribution</td>
    </tr><br><br>
    
    <?php while($resultat = $querry->fetch()){?>
        
        <tr>
            <td><?php echo $resultat["titre"];?><hr></td>
            <td><?php echo $resultat["genre"];?><hr></td>
            <td><?php echo $resultat["nom"];?><hr></td>
        </tr> 
        
        
        
        <?php
            $nbr_elem++;
        }
    }     
    ?>
    </table>
    
    <div>
        <a href="?movie=<?=$movie?>&genre=<?=$genre?>&distrib=<?=$distrib?>&hidden=&page=<?=$page-1?>">previous</a>
        <p><?=$page?></p>
        <a href="?movie=<?=$movie?>&genre=<?=$genre?>&distrib=<?=$distrib?>&hidden=&page=<?=$page+1?>">next</a> 
    </div>        

<footer><a href="accueil.php">retours a l'accueil</a></footer>

    </body>

</html>
