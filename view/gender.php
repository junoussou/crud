<?php
require_once("controller.php");
ob_start();
$encrypt_key = 'developpement';
$title = "Ajout - Genre";
?>
<h5><a href="index.php?controller=add_content">&#x271A; Ajouter un film</a></h5>
<h5><a href=".">&#x2770; Retour</a></h5>
<form action="index.php" method="post">
    <table>
        <tr>
            <td>
                <?php
                if (isset($_GET["id"])) { ?>
                    <label for="">Nouveau genre</label>
                <?php } else { ?>
                    <label for="">Ajout-genre</label>
                <?php }
                ?>
            </td>
            <td>
                <?php
                if (isset($_GET["id"])) { ?>
                    <input type="text" name="gender" id="" value="<?= dechiffrerAES(htmlspecialchars($_GET['name']), $encrypt_key) ?>" required>
                <?php }
                else {?>
                    <input type="text" name="gender" id="" required>
                <?php }
                ?>
            </td>
            <td>
                <?php
                if (isset($_GET["id"])) { ?>
                    <input type="hidden" name="controller" value="edit_gender">
                    <input type="hidden" name="id" value="<?= dechiffrerAES(htmlspecialchars($_GET['id']), $encrypt_key) ?>">
                    <input type="submit" value="Modifier" name="edit">
                <?php }
                else { ?>
                    <input type="hidden" name="controller" value="add_gender">
                    <input type="submit" value="Ajouter" name="add">
                <?php }
                ?>
            </td>
        </tr>
    </table>
</form>
<table border="1">
    <thead>
        <th colspan="2">#</th>
        <th>Nom</th>
    </thead>
    <tbody>
        <?php
        $sql = new FilmAPI();
        $table = "genre";
        $fields = "*";
        $req = $sql->read($table, $fields);
        $dt = '';
        while ($dt_req = $req->fetch()) {
            $dt .= '<tr>
                        <td>
                            <a href="index.php?controller=del_gender&id=' . replacePLus(chiffrerAES($dt_req["id"], $encrypt_key)) . '">&#x274C;</a>
                        </td>
                        <td>
                            <a href="index.php?controller=edit_gender&id=' . replacePLus(chiffrerAES($dt_req["id"], $encrypt_key)) . '&name='.replacePLus(chiffrerAES($dt_req["nom"], $encrypt_key)) . '">&#x270D;</a>
                        </td>
                        <td>' . $dt_req["nom"] . '</td>
                    </tr>';
        }
        echo $dt;
        ?>
    </tbody>
</table>
<?php
$content = ob_get_clean();
require("template.php");
?>