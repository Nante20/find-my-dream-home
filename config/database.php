<?php
$host = 'localhost';
$dbname = 'find_my_dream_home';
$username = 'root';
$password = 'nata';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
    die("Erreur connexion BDD : " . $e->getMessage());
}
