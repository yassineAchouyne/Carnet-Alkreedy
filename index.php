<!doctype html>
<html dir="rtl" lang="ar">

<head>
    <meta charset="utf-8">

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>fran</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="Wahran-Regular.otf">
    <script src="https://kit.fontawesome.com/ee309550fb.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>

<body>
    <section class="container">
        <div>
            <?php
            include "db.php";
            $sql = $db->prepare("SELECT * from clien");
            $sql->execute();
            $tab = $sql->fetchAll();
            foreach ($tab as $val) {

            ?>

                <a href="view.php?id=<?= $val['id'] ?>" class="btn btn-outline-info btn-lg" ondragend="delet(this.href)"><?= $val['nom'] ?></a>
            <?php } ?>
        </div>
        <div class="ajouter">
            <form action="" method="post" class="ajouter f1">
                <h1 class="text-info">اضافة عميل جديد</h1>
                <input type="text" class="form-control w-auto" value="" name="nom" required>
                <select name="group" id="" class="form-select w-auto">
                    <option value="1">شخص واحد</option>
                    <option value="2">مجموعة اشخاص</option>
                </select>
                <input type="submit" class="btn btn-info w-auto" value="اضافة" name="ajouter">
            </form>
            <form action="" method="post" class="ajouter f2">
                <h1 class="text-info">حدف عميل </h1>
                <input type="hidden" class="" id="url" name="url" required>
                <!-- <div id="delet">
                    <button><i class="fa-solid fa-trash-can"></i></button>
                </div> -->
                
                <input type="submit" class="btn btn-info w-auto" value="ازالة" name="delet">
            </form>
        </div>

    </section>
    <script>
        function delet(a) {
            var inp = document.getElementById('url')
            var del=document.getElementById('delet')
            inp.value = a
            // del.innerHTML="<i class='fa-solid fa-trash-can text-danger' onclick='fileDelet()'></i>"
        }
        // function fileDelet(){
        //     window.location.href="delet.php"
        // }
    </script>
</body>

</html>
<?php
if (isset($_POST['delet'])) {
    $url = parse_url($_POST['url'], PHP_URL_QUERY);
    parse_str($url, $tab);
    $sql = $db->prepare("DELETE from clien where id=?");
    $sql->execute([$tab['id']]);
    header("Location:index.php");
}
if (isset($_POST['ajouter'])) {
    $sql = $db->prepare("INSERT INTO `clien`( `nom`, `group`) VALUES (?,?)");
    $sql->execute([$_POST['nom'], $_POST['group']]);
    header("Location:index.php");
}


?>