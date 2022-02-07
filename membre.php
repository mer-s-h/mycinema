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
    <input type="search" name ="nom" placeholder = "nom"/>
    <input type="search" name ="prenom" placeholder = "prenom"/>
    <input type="hidden" name = "hidden"/>
    <input type="submit" value="Envoyer" />
 </form>

<?php

        // gestion de la requette sql 

    $dbh = new PDO("mysql:host=localhost;dbname=cinema", "meriem", "wac");

    $membre = "SELECT nom, prenom FROM fiche_personne ";

    // $nbr_membre = 0;
    $elem_affiche = 5;

    if (isset($_GET["hidden"])) {

        $nom = $_GET["nom"];
        $prenom = $_GET["prenom"];

        if (!empty($_GET["nom"])) {
            $membre = $membre . "WHERE nom LIKE \"%" . $_GET["nom"] . "%\"";
        }
        if (!empty($_GET["prenom"])) {
            $membre = (strpos ($membre, "LIKE")) ? $membre . " AND prenom LIKE \"%" . $_GET["prenom"] . "%\"" : $membre . " WHERE prenom LIKE \"%" .$_GET["prenom"] . "%\"";
        }

        $all_row = $dbh->query($membre);
        $nbr_membre = $all_row -> rowCount();
        $nombre_page = ceil($nbr_membre / $elem_affiche);
        if (isset($_GET["page"]) && !empty($_GET["page"])) {
            $page = $_GET["page"];
        }
        else {
            $page = 1;
        }
        $offset = ($page-1)*$elem_affiche;

        $order = $membre . " ORDER BY nom LIMIT $offset, $elem_affiche";

        $querry_M = $dbh->query($order);

        echo $order . "<br><br>";
        
    ?>

        <!-- affichage du resultat de recherche -->

         <table>

            <tr class="tri">
                <td>nom</td>
                <td>prenom</td>
            </tr><br><br>

            <?php while ($M_result = $querry_M->fetch()) { ?>

            <tr>
                <td><?php echo $M_result["nom"];?><hr></td>
                <td><?php echo $M_result["prenom"];?><hr></td>
            </tr>
            <?php
                // $nbr_membre++;
                }
                ?>
        </table>

        <div>
            <a href="?nom=<?=$nom?>&prenom=<?=$prenom?>&hidden=&page=<?=$page-1?>">previous</a>
            <p><?=$page?></p>
            <a href="?nom=<?=$nom?>&prenom=<?=$prenom?>&hidden=&page=<?=$page+1?>">next</a> 
        </div>  
    <?php
                // echo "membre trouver $nbr_membre <br><br>";

    }

    ?>


    </body>

    <footer><a href="accueil.php">retours a l'accueil</a></footer>

</html>