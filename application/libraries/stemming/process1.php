<?php
require_once('stemming.php')
?>

<?php
if (isset($_POST['kata'])) {
    $teksAsli = $_POST['kata'];
    echo $teksAsli;
    echo "<br>";
    $length = strlen($teksAsli);
    //echo $length;
    $pattern = '[A-Za-z]';
    $kata = '';
    if (eregi($pattern, $teksAsli)) {
        $kata = $teksAsli;
        $stemming = stemming($kata);//Memasukkan kata ke fungsi Algoritma
        echo $stemming;
        echo "</br>";
        $kata = '';
    }
}

?>