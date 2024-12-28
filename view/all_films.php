<?php
require_once("controller.php");
ob_start();
$title = "Acceuil - Tous les films";
$encrypt_key = 'developpement';
$sql = new FilmAPI();
?>
<h5><a href="index.php?controller=add_content">&#x271A; Ajouter Film</a></h5>
<h5><a href="index.php?controller=add_gender">&#x271A; Ajouter Genre</a></h5>
<form action="index.php" method="post">
    <table>
        <tr>
            <td>
                <input type="text" name="search" placeholder="Rechercher..." required>
            </td>
            <td>
                <input type="hidden" name="controller" value="view_all">
                <input type="submit" name="research" value="Rechercher">
            </td>
        </tr>
    </table>
</form>
<?php
if (isset($_POST['research'])) {
    extract($_POST); ?>
    <table border="1">
        <thead>
            <th colspan="2"></th>
            <th>Titre</th>
            <th>Description</th>
            <th>Langue</th>
            <th>Durée</th>
        </thead>
        <tbody>
            <?php
            $search = htmlspecialchars($search);
            $table = "cinema";
            $fields = "*";
            $condition = "id = ? OR
                          titre LIKE CONCAT('%', ?, '%') OR 
                          langue LIKE CONCAT('%', ?, '%') OR 
                          genre IN (SELECT id FROM genre WHERE nom LIKE CONCAT ('%', ?, '%'))";
            $data = array($search, $search, $search, $search);
            $req = $sql->search($table, $fields, $condition, $data);
            $dt = '';
            while ($dt_req = $req->fetch()) {
                $dt .= '<tr>
                <td>
                    <a href="index.php?controller=del_content&id=' . replacePLus(chiffrerAES($dt_req["id"], $encrypt_key)) . '">&#x274C;</a>
                </td>
                <td>
                    <a href="index.php?controller=edit_content&id=' . replacePLus(chiffrerAES($dt_req["id"], $encrypt_key)) . '&title=' . replacePLus(chiffrerAES($dt_req["titre"], $encrypt_key)) . '&descr=' . replacePLus(chiffrerAES($dt_req["description"], $encrypt_key)) . '&lang=' . $dt_req["langue"] . '&genre=' . $dt_req["genre"] . '&out_date=' . chiffrerAES($dt_req["date_de_sortie"], $encrypt_key) . '&box=' . replacePLus(chiffrerAES($dt_req["box_office"], $encrypt_key)) . '&duree=' . replacePLus(chiffrerAES($dt_req["duree"], $encrypt_key)) . '&stars=' . replacePLus(chiffrerAES($dt_req["nombre_etoiles"], $encrypt_key)) . '">&#x270D;</a>
                </td>
                <td>' . $dt_req["titre"] . '</td>
                <td>' . $dt_req["description"] . '</td>
                <td>' . $dt_req["langue"] . '</td>
                <td>' . $dt_req["duree"] . '</td>
            </tr>';
            }
            echo $dt;
            ?>
        </tbody>
    </table>
<?php }
else { ?>
    <table border="1">
        <thead>
            <th colspan="2"></th>
            <th>Titre</th>
            <th>Description</th>
            <th>Langue</th>
            <th>Durée</th>
        </thead>
        <tbody>
            <?php
                $table = "cinema";
                $fields = "*";
                $req = $sql->read($table, $fields);
                $dt = '';
                while ($dt_req = $req->fetch()) {
                    $dt .= '<tr>
                        <td>
                            <a href="index.php?controller=del_content&id=' . replacePLus(chiffrerAES($dt_req["id"], $encrypt_key)) . '">&#x274C;</a>
                        </td>
                        <td>
                            <a href="index.php?controller=edit_content&id=' . replacePLus(chiffrerAES($dt_req["id"], $encrypt_key)) . '&title=' . replacePLus(chiffrerAES($dt_req["titre"], $encrypt_key)) . '&descr=' . replacePLus(chiffrerAES($dt_req["description"], $encrypt_key)) . '&lang=' . $dt_req["langue"] . '&genre=' . $dt_req["genre"] . '&out_date=' . chiffrerAES($dt_req["date_de_sortie"], $encrypt_key) . '&box=' . replacePLus(chiffrerAES($dt_req["box_office"], $encrypt_key)) . '&duree=' . replacePLus(chiffrerAES($dt_req["duree"], $encrypt_key)) . '&stars=' . replacePLus(chiffrerAES($dt_req["nombre_etoiles"], $encrypt_key)) . '">&#x270D;</a>
                        </td>
                        <td>' . $dt_req["titre"] . '</td>
                        <td>' . $dt_req["description"] . '</td>
                        <td>' . $dt_req["langue"] . '</td>
                        <td>' . $dt_req["duree"] . '</td>
                    </tr>';
                }
                echo $dt;
                ?>
        </tbody>
    </table>
<?php }
?>
<?php
$content = ob_get_clean();
require("./template.php");
?>