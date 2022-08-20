<?php
include "db.php";
$sql = $db->prepare("SELECT * from clien2 where id_clien2=?");
$sql->execute([$_GET['id']]);
$cl = $sql->fetch()

?>
<!doctype html>
<html dir="rtl" lang="ar">

<head>
    <meta charset="utf-8">


    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>fran</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="Wahran-Regular.otf">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>

<body>

    <section class="container">
        <div>
            <h1 align="center" class="text-info"><?= $cl['nom'] ?></h1>
            <table class="table table-striped">
                <tr class="tr">
                    <td>التمن</td>
                    <td>التريخ</td>
                </tr>

                <?php
                include "db.php";
                $sql = $db->prepare("SELECT * from cridi2 where id_clien2=:id");
                $sql->execute([":id" => $_GET['id']]);
                $tab = $sql->fetchAll();
                $somme = 0;
                if ($sql->rowCount() > 0) {
                    foreach ($tab as $val) {
                        
                        if ($val['delet']==0) {
                            $somme += $val['prix'];
                ?>
                            <tr>
                                <td><?= $val['prix'] ?></td>
                                <td><?= $val['datee'] ?></td>
                            </tr>
                        <?php } else {
                            
                            ?>
                            <tr>
                                <td><del><?= $val['prix'] ?></del></td>
                                <td>  <?= $val['datee'] ?></td>
                            </tr>
                <?php }
                    }
                } ?>
                <tr class="tr">
                    <td>المجموع : <?= $somme ?></td>
                    <td><a href="view.php?id=<?=$_GET['idc']?>" class="btn btn-secondary">الرئيسية</a></td>
                </tr>
            </table>
        </div>
        <div class="ajouter">
            <form action="" method="post" class="ajouter">
                <h1 class="text-info">اضافة كريدي </h1>
                <input type="number" class="form-control w-25" value="" name="prix" required>
                <input type="submit" class="btn btn-info w-25" value="اضافة" name="ajouter">
            </form>

        </div>
    </section>

</body>

</html>
<?php

if (isset($_POST['ajouter'])) {
    $sql = $db->prepare("INSERT INTO `cridi2`(`id_clien2`, `id_clien`, `prix`, `datee`) VALUES (?,?,?,?)");
    $sql->execute([$cl['id_clien2'], $_GET['idc'], $_POST['prix'], date("Y-m-d")]);
    $idd = $cl['id_clien2'];
    $iddc= $_GET['idc'];
    header("Location:view2.php?id=$idd &&idc=$iddc");
}


?>