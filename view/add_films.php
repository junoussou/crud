<?php
require_once("controller.php");
ob_start();
$title = "Nouveu film";
?>
<form action="index.php" method="post">
    <table>
        <tr>
            <td><label for="">Titre</label></td>
            <td>
                <input type="text" name="title" id="" required>
            </td>
        </tr>
        <tr>
            <td><label for="">Description</label></td>
            <td>
                <textarea name="description" id="" cols="60" rows="10"></textarea>
            </td>
        </tr>
        <tr>
            <td><label for="">Langue</label></td>
            <td>
                <select name="lang" id="">
                    <option selected disabled></option>
                    <option value="FR - fr">Francais</option>
                    <option value="EN - en">Anglais</option>
                </select>
            </td>
        </tr>
        <tr>
            <td><label for="">Genre</label></td>
            <td>
                <?php
                $sql = new FilmAPI();
                $table = "genre";
                $fields = "*";
                $req = $sql->read($table, $fields);
                ?>
                <select name="genre" id="">
                    <?php
                    $dt = '<option selected disabled></option>';;
                    while ($dt_req = $req->fetch()) {
                        $dt .= '<option value="' . $dt_req['id'] . '">' . $dt_req['nom'] . '</option>';
                    }
                    echo $dt;
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td><label for="">Date de sortie</label></td>
            <td>
                <input type="date" name="date_de_sortie" id="" required>
            </td>
        </tr>
        <tr>
            <td><label for="">Box Office</label></td>
            <td>
                <input type="text" name="box_office" id="" required>
            </td>
        </tr>
        <tr>
            <td><label for="">Durée (minutes)</label></td>
            <td>
                <input type="text" name="duree" id="" required>
            </td>
        </tr>
        <tr>
            <td><label for="">Nombre d'étoiles</label></td>
            <td>
                <input type="text" name="nombre_etoiles" id="">
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="hidden" name="controller" value="add_content">
                <input type="submit" value="Enregistrer" name="save">
            </td>
        </tr>
    </table>
</form>
<?php
$content = ob_get_clean();
require("./template.php");
?>