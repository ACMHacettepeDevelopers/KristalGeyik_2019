<?php
echo "Hello World";
if(isset($_GET['electronic'])){
    $data = $_GET['electronic'];
}else{
    $data = 'no data found';
}
print_r($_GET);
echo "$data";
?>
