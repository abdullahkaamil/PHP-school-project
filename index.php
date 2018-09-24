<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>MY first PHP project</title>
</head>
<?php
echo "
    <pre>";
print_r($_GET);
echo "</pre>";
if (!isset($_GET['is']))
    $_GET['is'] = '';

switch ($_GET['is']) {
    case 'sil':
        sil();
        listele();
        break;
    case 'yeni':
        yeni();
        break;
    case 'ekle':
        checking();
        listele();
        break;
    case 'degistir':
        form();
        break;
    case 'guncelle':
        guncelle();
        listele();
        break;
    default:
        listele();
}


// update
function guncelle()
{
    $c = mysqli_connect('localhost', 'root', '', 'okul');
    $sql = "UPDATE ogrenci SET adi='{$_GET['ad']}',soyadi='{$_GET['soyad']}' WHERE ono={$_GET['no']};";
    //echo $sql;exit;
    $sonuc = mysqli_query($c, $sql);
    if (mysqli_affected_rows($c) == 0)
        echo "Kayit bulunamadi (no={$_GET['no']})";
    mysqli_close($c);
}
function form()
{
    //update form
    ?>
<body>
<h4>Ogrenci Guncelleme</h4>
<div class='form-group col-md-8'>
<form action=''>
<input type=hidden name=no value='<?php echo $_GET['no']; ?>'>
<input type=hidden name=is value=guncelle>
<table>
    <tr>
        <td>NO</td>
        <td><input disabled name=ogrno type=text value='<?php echo $_GET['no']; ?>'></td>
    </tr>
    <tr>
        <td>AD</td>
        <td><input name=ad type=text value='<?php echo $_GET['ad']; ?>'></td>
        </tr>
    <tr>
        <td>SOYAD</td>
        <td><input name=soyad type=text value='<?php echo $_GET['soyad']; ?>'></td>
    </tr   >
    <tr>
        <td><input name=gonder type=submit value=SAKLA></td>
    </tr>
</table>
</form>
</div>
<?php 
}
    //adding
function ekle()
{
    $c = mysqli_connect('localhost', 'root', '', 'okul');
    $sql = "INSERT INTO ogrenci(ono,adi,soyadi) VALUES(" . $_GET['no'] . ",'" . $_GET['ad'] . "','" . $_GET['soyad'] . "');";
    echo $sql . "<br>";
    $sonuc = mysqli_query($c, $sql) or mysqli_error($c);
    echo $sonuc;
    mysqli_close($c);
    //header("location:index.php");
}

function yeni()
{
    echo "
    <form>
        Yeni Ogrenci
        <input type=hidden name=is value=ekle>
        <div class='form-group row col-md-8'>
            <label for='inputno' class='col-sm-3 col-form-label'>
                NO: </lable>
                <div class='col-sm-10'>
                    <input name=no type=text>
                </div>
        </div>

        <div class='form-group row col-md-8'>
            <label for='inputno' class='col-sm-3 col-form-label'>
                AD: </lable>
                <div class='col-sm-10'>
                    <input name=ad type=text>
                </div>
        </div>

        <div class='form-group row col-md-8'>
            <label for='inputno' class='col-sm-3 col-form-label'> SOYAD: </lable>
                <div class='col-sm-10'>
                    <input name=soyad type=text>
                </div>
        </div>

        <fieldset class='form-group'>
            <div class='row'>
                <legend class='col-form-label col-sm-2 pt-0'>Censiyet</legend>
                <div class='col-sm-5'>
                    <div class='form-check'>
                        <input type=radio name=cinsiyet value=E>
                        <label class='form-check-label' for='gridRadios1'>   Erkek </label>
                    </div>
                    <div class='form-check'>
                        <input type=radio name=cinsiyet value=K>
                        <label class='form-check-label' for='gridRadios1'> Kadin </lable>
                    </div>
                </div>
            </div>
        </fieldset>
        <button type='submit' class='btn btn-primary' name=gonder> Olustur</button>
    </form>";
}
    //detele
function sil()
{
    $c = mysqli_connect('localhost', 'root', '', 'okul'); // VT'ye baglan
    $sql = "DELETE FROM ogrenci WHERE ono=" . $_GET['no'] . ";";
    $sonuc = mysqli_query($c, $sql); // SQL komutunu calistir
    if (!$sonuc) // komutu calistirirken hata olustumu?
    echo "SQL Hatasi:" . mysqli_error($c);
    mysqli_close($c); // VT baglantisini kapat
    //header("location:index.php"); // browser'in ogrenci.php sayfasini yuklemesini sagla
}
   //checking if the student no is exist or not 
function checking()
{
    $c = mysqli_connect('localhost', 'root', '', 'okul');
    if (isset($_GET['no']) && isset($_GET['ad']) && isset($_POST['soyad']));
    {
        $no = $_GET['no'];
        $ad = $_GET['ad'];
        $soyad = $_GET['soyad'];

        $sql = "SELECT* FROM ogrenci where ono = '$no' ";
        $sonuc = mysqli_query($c, $sql);
        if (mysqli_num_rows($sonuc) > 0) {
            echo 'Username already Exists!!';
        } else {
            ekle();
        }
    }
}
    //list after adding the student
function listele()
{
    $baglanti = mysqli_connect('localhost', 'root', '', 'okul');
    if (!$baglanti)
        echo "Baglanti Hatasi:" . mysqli_error($baglanti);
    $kayitKumesi = mysqli_query($baglanti, "SELECT * FROM ogrenci;");
    if (!$kayitKumesi)
        echo "SQL Hatasi:" . mysqli_error($baglanti);
    echo "<br>
    <div class='table-responsive col-md-4 align-middle'>
        <h2>Ogrenci listesi</h2>
        <table class='table table-striped'>
        <thead>
        <tr>
            <th scope='col'>
                   <a href='?orderBy=no'>No</a>
            </th>
            <th scope='col'>
                    <a href='?orderBy=adi'>Adi</a>
            </th>
            <th scope='col'>
                    <a href='?orderBy=soyadi'>Soyadi</a>
            </th>
            <td>Sil</td>
            <td>Degistir</td>
        </tr>
        </thead>
        <br>
        ";
        //sorting the variables 
    $orderBy = array('no', 'adi', 'soyadi');//Start
    $order = 'type';
    if (isset($_GET['orderBy']) && in_array($_GET['orderBy'], $orderBy)) {
        $order = $_GET['orderBy'];
        $sql = "SELECT * FROM ogrenci ORDER BY " . $order;
    }//end 
    while ($kayit = mysqli_fetch_array($kayitKumesi)) {
        echo "
        <tr>
            <td>" . $kayit[0] . "</td>
            <td>" . $kayit[1] . "</td>
            <td>" . $kayit[2] . "</td>
            <td><a href='?is=sil&no=" . $kayit[0] . "'>Sil</a></td>
            <td><a href='?is=degistir&no={$kayit[0]}&ad={$kayit[1]}&soyad={$kayit[2]}'>Degistir</a></td>
        </tr>";
    }
//pagenation 
    if (isset($_GET['pageno'])) {
        $pageno = $_GET['pageno'];
    } else {
        $pageno = 1;
    }
    $no_of_records_per_page = 5;
    $offset = ($pageno - 1) * $no_of_records_per_page;

    $c = mysqli_connect('localhost', 'root', '', 'okul');

    $total_pages_sql = "SELECT COUNT(*) FROM ogrenci";
    $result = mysqli_query($c, $total_pages_sql);
    $total_rows = mysqli_fetch_array($result)[0];
    $total_pages = ceil($total_rows / $no_of_records_per_page);

    $sql = "SELECT * FROM ogrenci LIMIT $offset, $no_of_records_per_page";
    $res_data = mysqli_query($c, $sql);
    while ($row = mysqli_fetch_array($res_data)) {
            //here goes the data
    }
    ?> 
   
        </table>
        <div>
<ul class='pagination'>
<li><a href='?pageno=1'>First</a></li>pageno = <?php echo $pageno; ?>
        <li class='<?php if ($pageno <= 1) {
                        echo 'disabled';
                    } ?>'>
            <a href='<?php if ($pageno <= 1) {
                        echo '#';
                    } else {
                        echo '?pageno=' . $pageno;
                    } ?>''>Prev</a>
        </li>
        <li class='<?php if ($pageno >= $total_pages) {
                        echo 'disabled';
                    } ?>'>
            <a href='<?php if ($pageno >= $total_pages) {
                        echo '#';
                    } else {
                        echo '?pageno=' . $pageno;
                    } ?>>Next</a>
        </li>
        <li><a href='?pageno=<?php echo $total_pages; ?>'>Last</a></li>
    </ul>
</div>
    <a href='?is=yeni' class='btn btn-primary btn-lg active' role='button' aria-pressed='true'>Yeni ogrenci</a></div>
    <?php
    mysqli_close($baglanti);
}
?>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
