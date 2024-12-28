<?php
require_once("controller.php");
ob_start();
$encrypt_key = 'developpement';
$title = "Modifier - " . dechiffrerAES($_GET['title'], $encrypt_key);
?>
<form action="index.php" method="post">
    <table>
        <tr>
            <td><label for="">Identifiant Unique</label></td>
            <td>
                <input type="text" required disabled value="<?= htmlspecialchars($_GET['id']) ?>">
                <input type="hidden" name="id" id="" value="<?= dechiffrerAES(htmlspecialchars($_GET['id']), $encrypt_key) ?>">
            </td>
        </tr>
        <tr>
            <td><label for="">Titre</label></td>
            <td>
                <input type="text" name="title" id="" required
                    value="<?= dechiffrerAES($_GET['title'], $encrypt_key) ?>">
            </td>
        </tr>
        <tr>
            <td><label for="">Description</label></td>
            <td>
                <textarea name="description" id="" cols="60"
                    rows="10"><?= dechiffrerAES($_GET['descr'], $encrypt_key) ?></textarea>
            </td>
        </tr>
        <tr>
            <td><label for="">Langue</label></td>
            <td>
                <select name="lang" id="">
                    <option selected disabled></option>
                    <option value="FR - fr" <?php if ($_GET['lang'] == 'FR - fr') { ?>
                            selected <?php } ?>>Francais
                    </option>
                    <option value="EN - en" <?php if ($_GET['lang'] == 'EN - en') { ?>
                            selected <?php } ?>>Anglais
                    </option>
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
                    $dt = '<option selected disabled></option>';
                    ;
                    while ($dt_req = $req->fetch()) {
                        if (htmlspecialchars($_GET['genre']) ==  $dt_req['id']) {
                            $dt .= '<option value="' . $dt_req['id'] . '" selected>' . $dt_req['nom'] . '</option>';
                        } else {
                            $dt .= '<option value="' . $dt_req['id'] . '">' . $dt_req['nom'] . '</option>';
                        }
                    }
                    echo $dt;
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td><label for="">Date de sortie</label></td>
            <td>
                <input type="date" name="date_de_sortie" id="" required
                    value="<?= dechiffrerAES($_GET['out_date'], $encrypt_key) ?>">
            </td>
        </tr>
        <tr>
            <td><label for="">Box Office</label></td>
            <td>
                <input type="text" name="box_office" id="" required value="<?= dechiffrerAES($_GET['box'], $encrypt_key) ?>">
            </td>
        </tr>
        <tr>
            <td><label for="">Durée</label></td>
            <td>
                <input type="text" name="duree" id="" required value="<?= dechiffrerAES($_GET['duree'], $encrypt_key) ?>">
            </td>
        </tr>
        <tr>
            <td><label for="">Nombre d'étoiles</label></td>
            <td>
                <input type="text" name="nombre_etoiles" id="" value="<?= dechiffrerAES($_GET['stars'], $encrypt_key) ?>">
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="hidden" name="controller" value="edit_content">
                <input type="submit" value="Modifier" name="update">
            </td>
        </tr>
    </table>
</form>
<?php
$content = ob_get_clean();
require("template.php");
?>