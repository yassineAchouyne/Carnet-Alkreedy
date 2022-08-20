<?php
include "db.php";
$sql = $db->prepare("SELECT * from clien where id=?");
$sql->execute([$_GET['id']]);
$cl = $sql->fetch();

$pr = $db->prepare("SELECT SUM(prix) as prix from cridi2 WHERE id_clien=?");
$pr->execute([$_GET['id']]);
$sm = $pr->fetch()['prix'];

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
    <?php if ($cl['group'] == 1) { ?>
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
                    $sql = $db->prepare("SELECT * from cridi where id_clien=:id");
                    $sql->execute([":id" => $_GET['id']]);
                    $tab = $sql->fetchAll();
                    $somme = 0;
                    if ($sql->rowCount() > 0) {
                        foreach ($tab as $val) {
                            $somme += $val['prix'];
                    ?>
                            <tr>
                                <td><?= $val['prix'] ?></td>
                                <td><?= $val['datee'] ?></td>
                            </tr>
                    <?php }
                    } ?>
                    <tr class="tr">
                        <td>المجموع : <?= $somme ?></td>
                        <td><a href="index.php" class="btn btn-secondary">الرئيسية</a></td>
                    </tr>
                    <tr class="tr">
                        <td colspan="2">
                            <form action="" method="post" class="forms">
                                <button class="btn btn-danger" name="delet">مسح التسجيلات</button>
                            </form>

                        </td>
                    </tr>
                </table>
            </div>
            <div class="ajouter">
                <form action="" method="post" class="ajouter f1">
                    <h1 class="text-info">اضافة كريدي </h1>
                    <input type="number" class="form-control w-25" value="" name="prix" required>
                    <input type="submit" class="btn btn-info w-25" value="اضافة" name="ajouter">
                </form>
                <form action="" method="post" class="ajouter f2">
                    <h1 class="text-info">دفع</h1>
                    <input type="number" class="form-control w-25" value="" name="prixp" required>
                    <input type="submit" class="btn btn-info w-25" value="تاكيد" name="payment">
                </form>

            </div>

        </section>
    <?php } else { ?>
        <section class="container">
            <div>
                <?php
                include "db.php";
                $sql = $db->prepare("SELECT * from clien2 where id_clien=?");
                $sql->execute([$_GET['id']]);
                $tab = $sql->fetchAll();
                foreach ($tab as $val) {

                ?>
                    <a href="view2.php?id=<?= $val['id_clien2'] ?>&&idc=<?= $_GET['id'] ?>" ondragend="delet(this.href)" class="btn btn-outline-info btn-lg"><?= $val['nom'] ?></a>
                <?php } ?>
            </div>
            <div>
                <h1 align="center" id="prix">
                    المجموع : <?php echo $sm; ?>
                </h1>
            </div>
            <table class="table table-striped">
                <tr class="tr">

                    <td>
                        <form action="" method="post" class="forms">
                            <button class="btn btn-danger" name="delete">مسح التسجيلات</button>
                        </form>

                    </td>
                    <td>
                        <form action="" method="post" class="forms">
                            <a href="index.php" class="btn btn-secondary">الرئيسية</a>
                        </form>
                    </td>
                </tr>
            </table>
            <div class="ajouter">
                <form action="" method="post" class="ajouter f1">
                    <h1 class="text-info">اضافة عميل جديد مع <span class="nom"><?= $cl['nom'] ?></span></h1>
                    <input type="text" class="form-control w-25" value="" name="nom" required>
                    <input type="submit" class="btn btn-info w-25" value="اضافة" name="ajt">
                </form>
                <form action="" method="post" class="ajouter f3">
                    <h1 class="text-info">دفع</h1>
                    <input type="number" class="form-control w-25" value="" name="prixp" required>
                    <input type="submit" class="btn btn-info w-25" value="تاكيد" name="payment2">
                </form>
                <form action="" method="post" class="ajouter f2">
                    <h1 class="text-info">حدف عميل </h1>
                    <input type="url" class="" id="url" name="url" required>
                    <input type="submit" class="btn btn-info w-25" value="ازالة" name="delett">
                </form>
            </div>
        </section>
        <script>
            function delet(a) {
                var inp = document.getElementById('url')
                inp.value = a
            }
            
        </script>

    <?php } ?>
</body>

</html>
<?php
if (isset($_POST['delett'])) {
    $url = parse_url($_POST['url'], PHP_URL_QUERY);
    parse_str($url, $tab);
    $sql = $db->prepare("DELETE from clien2 where id_clien2=?");
    $sql->execute([$tab['id']]);
    $idd = $cl['id'];
    header("Location:view.php?id=$idd");
}
if (isset($_POST['ajouter'])) {
    $sql = $db->prepare("INSERT INTO `cridi`(`id_clien`, `prix`, `datee`) VALUES (?,?,?)");
    $sql->execute([$cl['id'], $_POST['prix'], date("Y-m-d")]);
    $idd = $cl['id'];
    header("Location:view.php?id=$idd");
}
if (isset($_POST['payment'])) {
    $sql = $db->prepare("INSERT INTO `cridi`(`id_clien`, `prix`, `datee`) VALUES (?,?,?)");
    $sql->execute([$cl['id'], -$_POST['prixp'], date("Y-m-d")]);
    $idd = $cl['id'];
    header("Location:view.php?id=$idd");
}
if (isset($_POST['delet'])) {
    $sql = $db->prepare("DELETE from cridi where id_clien=?");
    $sql->execute([$cl['id']]);
    $idd = $cl['id'];
    header("Location:view.php?id=$idd");
}

if (isset($_POST['ajt'])) {
    $sql = $db->prepare("INSERT INTO `clien2`(`id_clien`, `nom`) VALUES (?,?)");
    $sql->execute([$cl['id'], $_POST['nom']]);
    $idd = $cl['id'];
    header("Location:view.php?id=$idd");
}
if (isset($_POST['payment2'])) {
    $sql = $db->prepare("INSERT INTO `cridi2`(`id_clien2`, `id_clien`, `prix`, `datee`) VALUES (?,?,?,?)");
    $sql->execute([0, $_GET['id'], -$_POST['prixp'], date("Y-m-d")]);

    $sql2 = $db->prepare("UPDATE `cridi2` SET `delet`=? WHERE `id_clien`=?");
    $sql2->execute([1, $_GET['id']]);



    $idd = $cl['id'];
    header("Location:view.php?id=$idd");
}
if (isset($_POST['delete'])) {
    $sql = $db->prepare("DELETE from cridi2 where id_clien=?");
    $sql->execute([$cl['id']]);
    $idd = $cl['id'];
    header("Location:view.php?id=$idd");
}
?>