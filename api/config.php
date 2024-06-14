<?php
// Include library EasyRDF untuk mengakses data RDF
require_once '../vendor/autoload.php';
use EasyRdf\Sparql\Client;

// Buat koneksi ke server SPARQL menggunakan EasyRDF
$endpoint = new Client('http://localhost:3030/jartik2');
?>