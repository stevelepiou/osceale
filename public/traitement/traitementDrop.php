<?php


$sql = 'SELECT * FROM tache LIMIT 1';

$tableau= $pdo->prepare($sql);
$tableau= $tableau->execute();

echo json_encode($tableau) ;


?>