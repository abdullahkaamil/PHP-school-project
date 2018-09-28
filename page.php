<html>
<head>
<link href="../PHP-school-project/css/pagination.css" rel="stylesheet" type="text/css" />
<link href="../PHP-school-project/css/A_green.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
 <title>MY first PHP project</title> </head>
 <body>
<?php
require("../PHP-school-project/function.php");
function connect()
{
    return mysqli_connect('localhost', 'root', '', 'okul'); //sql connect
}

//switching between fucntions
if (!isset($_GET['is']))
    $_GET['is'] = '';
switch ($_GET['is']) {
    case 'detele':
        detele();
        listed();
        break;
    case 'add':
        checking();
        listed();
        break;
    case 'degistir':
        form();
        break;
    case 'update':
        update();
        listed();
        break;
    default:
        listed();
}
// update
function update()
{

    $sql = "UPDATE ogrenci SET adi='{$_GET['ad']}',soyadi='{$_GET['soyad']}' WHERE ono={$_GET['no']};"; //sql update query
    $result = mysqli_query($c, $sql);
    if (mysqli_affected_rows($c) == 0)
        echo "Kayit bulunamadi (no={$_GET['no']})";
    mysqli_close($c);
}
 //checking if the student no is exist or not
function checking()
{
    $c = connect();
    if (isset($_GET['no']) && isset($_GET['ad']) && isset($_POST['soyad']));
    {
        $no = $_GET['no'];
        $ad = $_GET['ad'];
        $soyad = $_GET['soyad'];

        $sql = "SELECT* FROM ogrenci where ono = '$no' ";
        $result = mysqli_query($c, $sql);
        if (mysqli_num_rows($result) > 0) {
            echo 'Username already Exists!!';
        } else {
            add();
        }
    }
}

 //updating form
function form()
{ ?>
<h4>Student update </h4>
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
        <td><input name=gonder type=submit value=UpDate></td>
    </tr>
</table>
</form>
</div>
<?php

}
//adding
function add()
{
    $c = connect();
    $sql = "INSERT INTO ogrenci(ono,adi,soyadi) VALUES(" . $_GET['no'] . ",'" . $_GET['ad'] . "','" . $_GET['soyad'] . "');";
    //echo $sql . "<br>";
    $result = mysqli_query($c, $sql) or mysqli_error($c);
   // echo $result;
    mysqli_close($c);
}
 //detele
function detele()
{
    $c = connect();
    $sql = "DELETE FROM ogrenci WHERE ono=" . $_GET['no'] . ";";
    $result = mysqli_query($c, $sql); // SQL komutunu calistir
    if (!$result) // komutu calistirirken hata olustumu?
    echo "SQL error:" . mysqli_error($c);
    mysqli_close($c); // VT baglantisini kapat
}
//student list
function listed()
{

    $c = connect();
   
    //$result_per_page = 5;
    $sql = "SELECT * FROM ogrenci ";
    //$result = mysqli_query($c, $sql);
  //  $number_of_result = mysqli_num_rows($result);

// sorting the arrays

    if (isset($_GET['order'])) {
        $order = $_GET['order'];
    } else {
        $order = 'ono';
    }
    if (isset($_GET['sort'])) {
        $sort = $_GET['sort'];
    } else {
        $sort = 'DESC';
    }
    if (isset($_GET['sortso'])) {
        $sort1 = $_GET['sortso'];
    } else {
        $sort1 = 'soyadi';
    }
    $c = connect();   
    $result = mysqli_query($c, $sql);
    if ($result->num_rows > 0) {
        $sort == 'ASC' ? $sort = 'DESC' : $sort = 'ASC';
        while ($rows = $result->fetch_assoc()) {
            $ono = $rows['ono'];
            $adi = $rows['adi'];
            $soyadi = $rows['soyadi'];
        }
    }
    echo "
    <div class='table-responsive col-md-9 align-middle'>
        <h2>Student List</h2>
        <form>
        <table class='table table-striped'>
        <thead>
        <tr>
            <th scope='col'>
                   <a href='?order=ono&&sort=$sort'>No</a>
            </th>
            <th scope='col'>
                    <a href='?order=adi&&sort=$sort'>Adi</a>
            </th>
            <th scope='col'>
                    <a href='?order=soyadi&&sort=$sort'>Soyadi</a>
            </th>
           <td>Detele</td>
            <td>UpDate</td>
        </tr>
        </thead>
        <tr>
        <input type=hidden name=is value=add>
       <td>  <input name=no type=text></td>
       <td>  <input name=ad type=text></td>
       <td>  <input name=soyad type=text></td>
       <td> <button type='submit' class='btn btn-primary' name=gonder> SAVE</button> </td>
       <td>&nbsp;</td>
        <br>";
    
    $c = connect(); 
    $page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
    $limit = 5;
         $startpoint = ($page * $limit) - $limit; 
    $sql = "SELECT * FROM ogrenci  order by $order $sort LIMIT " . $startpoint . ',' .$limit;
    $result = mysqli_query($c, $sql);
   // var_dump($result); die;
    while ($row = mysqli_fetch_array($result)) {
        $ono = $row['ono'];
        $adi = $row['adi'];
        $soyadi = $row['soyadi'];
       echo "
    <tr>
        <td>" . $ono . "</td>
        <td>" . $adi . "</td>
        <td>" . $soyadi . "</td>
        <td><a href='?is=detele&no=" . $ono . "'>Delete</a></td>
        <td><a href='?is=degistir&no={$ono}&ad={$adi}&soyad={$soyadi}'>Update</a></td>
    </tr> <br>";
    }
    ?>
    </form>
    </table>

 

</div>
    
<?php 

echo "<div id='pagingg' >";

echo pagination($sql, $limit, $page);
echo "</div>";

    mysqli_close($c);
}
?>
  </body>  
   <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</html>