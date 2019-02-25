
<?php


$dosya = fopen("log.txt", 'a');

fwrite($dosya, $_POST['result']);
fclose($dosya);
echo "$string";
?>
