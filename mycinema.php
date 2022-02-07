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

 <form methode = "GET">
    <input type="search" name ="nom" placeholder = "nom"/>
    <input type="search" name ="prenom" placeholder = "prenom"/>
    <input type="hidden" name = "cache"/>
    <input type="submit" value="Envoyer" />
 </form>

<?php

        // gestion de la requette sql 

    $dbh = new PDO("mysql:host=localhost;dbname=cinema", "meriem", "wac");

    $requete = "SELECT titre, distrib.nom, genre.nom AS \"genre\" FROM film LEFT JOIN genre ON film.id_genre = genre.id_genre LEFT JOIN distrib ON film.id_distrib = distrib.id_distrib";

    $membre = "SELECT nom, prenom FROM fiche_personne ";

    $nbr_elem = 0;
    $nbr_membre = 0;
        
    if (isset($_GET["hidden"])) {
            
        if (!empty($_GET["movie"])){
            $requete = $requete . " WHERE titre LIKE \"%" . $_GET["movie"] . "%\"";
        }
            
        if (!empty($_GET["genre"])){
            $requete = (strpos($requete, "LIKE")) ? $requete . "  AND genre.nom LIKE \"%" . $_GET["genre"] . "%\"" : $requete . " WHERE genre.nom LIKE \"%" . $_GET["genre"] . "%\"";
        }
            
        if (!empty($_GET["distrib"])) {
            $requete = (strpos($requete, "LIKE")) ? $requete . "  AND distrib.nom LIKE \"%" . $_GET["distrib"] . "%\"" : $requete . " WHERE distrib.nom LIKE \"%" . $_GET["distrib"] . "%\"";
        }

        $by_name = $requete . " ORDER BY titre";
            
        $querry = $dbh->query($by_name);
            
        echo $by_name . "<br><br>";
            
    }
        
    if (isset($_GET["cache"])) {

        if (!empty($_GET["nom"])) {
            $membre = $membre . "WHERE nom LIKE \"%" . $_GET["nom"] . "%\"";
        }
        if (!empty($_GET["prenom"])) {
            $membre = (strpos ($membre, "LIKE")) ? $membre . " AND prenom LIKE \"%" . $_GET["prenom"] . "%\"" : $membre . " WHERE prenom LIKE \"%" .$_GET["prenom"] . "%\"";
        }

        $order = $membre . " ORDER BY nom";

        $querry_M = $dbh->query($order);

        echo $order . "<br><br>";
    }
        
        
    ?>

        <!-- affichage du resultat de recherche -->
    <div>
        <table>
        
            <tr class ="tri">
                <td>titre</td>
                <td>genre</td>
                <td>distribution</td>
            </tr><br><br>

            <?php while($resultat = $querry->fetch()){?>

                <tr>
                    <td><?php echo $resultat["titre"];?></td>
                    <td><?php echo $resultat["genre"];?></td>
                    <td><?php echo $resultat["nom"];?></td>
                </tr> 
            
        </table><br>

    </div>
    <?php
                $nbr_elem++;
            }

    echo "resultat trouver $nbr_elem <br><br>";
    ?>

    </div>

         <table>

            <tr>
                <td>nom</td>
                <td>prenom</td>
            </tr><br><br>

            <?php while ($M_result = $querry_M->fetch()) { ?>

            <tr>
                <td><?php echo $M_result["nom"];?></td>
                <td><?php echo $M_result["prenom"];?></td>
            </tr>
            <?php
                $nbr_membre++;
                }
                echo "membre trouver $nbr_membre <br><br>";
            ?>

        </table>

                <!-- // pagination
                
                // $nbr_elem = $querry -> rowCount();
                // $nombre_page = ceil($nbr_elem / $elem_affiche);
                // $page = $_GET["page"];
                // $debut = ($page-1)*$nbr_elem;
                // $movie = $_GET["movie"];
                // $genre = $_GET["genre"];
                // $distrib = $_GET["distrib"];
                
                // for ($i=1; $i <= $nombre_page ; $i++) { 
                //     echo "<a href=\"?page=$i\">$i</a>";
                
                    // if ($i != $page) {
                    //     echo "<a href=\"movie=$movie&genre=$genre&distrib=$distrib&hidden=&page=$i";
                    // }
                    // else{
                    //     echo "<a>$i</a>";
                    // }
                // } -->
                


    </body>

</html>