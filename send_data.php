
<?php


$file = fopen("log.txt", 'a');
$fileInfo = fopen("log_with_info.txt", 'a');
$name = $_POST['name'];
$mail = $_POST['mail'];

fwrite($fileInfo, "$name,$mail,$_POST[result]");
fwrite($file, $_POST['result']);
fclose($file);
fclose($fileInfo);

echo "$string";
?>
