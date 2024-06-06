<?php
// Include library EasyRDF untuk mengakses data RDF
require_once '../vendor/autoload.php';
use EasyRdf\Sparql\Client;

// Buat koneksi ke server SPARQL menggunakan EasyRDF
$endpoint = new Client('http://localhost:3030/jartik');

// Fungsi untuk mendapatkan semua data dosen
function getDataDosen($endpoint) {
    $query = "
        PREFIX ex: <http://www.semanticweb.org/mak/ontologies/2024/4/jartik#>
        SELECT ?nip ?namaDosen ?statusKeaktifanDosen ?unitKerjaDosen
        WHERE {
            ?dosen ex:nip ?nip ;
                   ex:namaDosen ?namaDosen ;
                   ex:statusKeaktifanDosen ?statusKeaktifanDosen ;
                   ex:unitKerjaDosen ?unitKerjaDosen .
        }
    ";

    $result = $endpoint->query($query);

    $data = [];
    foreach ($result as $row) {
        $data[] = [
            'nip' => $row->nip->getValue(),
            'namaDosen' => $row->namaDosen->getValue(),
            'statusKeaktifanDosen' =>$row->statusKeaktifanDosen->getValue(),
            'unitKerjaDosen' => $row->unitKerjaDosen->getValue()
        ];
    }

    return $data;
}

// Fungsi untuk mendapatkan data dosen berdasarkan status keaktifan
function getDataDosenByActivate($endpoint, $activateStatus) {
    // print_r($activateStatus);
    $query = "
        PREFIX ex: <http://www.semanticweb.org/mak/ontologies/2024/4/jartik#>
        SELECT ?nip ?namaDosen ?statusKeaktifanDosen ?unitKerjaDosen
        WHERE {
            ?dosen ex:nip ?nip ;
                   ex:namaDosen ?namaDosen ;
                   ex:statusKeaktifanDosen ?statusKeaktifanDosen ;
                   ex:unitKerjaDosen ?unitKerjaDosen .
        FILTER(regex(str(?statusKeaktifanDosen), '$activateStatus', 'i'))
        }
    ";

    $result = $endpoint->query($query);

    $data = [];
    foreach ($result as $row) {
        $data[] = [
            'nip' => $row->nip->getValue(),
            'namaDosen' => $row->namaDosen->getValue(),
            'statusKeaktifanDosen' => $row->statusKeaktifanDosen->getValue(),
            'unitKerjaDosen' => $row->unitKerjaDosen->getValue()
        ];
    }

    return $data;
}

try {
    // Mendapatkan jenis permintaan dari URL
    $action = isset($_GET['action']) ? $_GET['action'] : null;

    // Set header untuk respons JSON
    header('Content-Type: application/json');

    // Menangani permintaan berdasarkan jenisnya
    switch ($action) {
        case 'getDataDosen':
            $data = getDataDosen($endpoint);
            echo json_encode($data);
            break;
        case 'getDataDosenByActivate':
            $activateStatus = isset($_GET['status']) ? $_GET['status'] : null;
            if ($activateStatus === null) {
                throw new Exception('Status keaktifan tidak disediakan.');
            }
            $data = getDataDosenByActivate($endpoint, $activateStatus);
            echo json_encode($data);
            break;
        default:
            throw new Exception('Action tidak valid.');
    }
} catch (EasyRdf\Exception $e) {
    // Tangani kesalahan EasyRdf dengan menangkap dan mencetak pesan kesalahan
    http_response_code(400);
    echo json_encode(['error' => 'EasyRdf exception: ' . $e->getMessage()]);
} catch (Exception $e) {
    // Tangani kesalahan umum dengan menangkap dan mencetak pesan kesalahan
    http_response_code(400);
    echo json_encode(['error' => 'General exception: ' . $e->getMessage()]);
}
?>
