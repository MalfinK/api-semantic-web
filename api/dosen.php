<?php
// Include library EasyRDF untuk mengakses data RDF
require_once '../vendor/autoload.php';
use EasyRdf\Sparql\Client;

// Buat koneksi ke server SPARQL menggunakan EasyRDF
$endpoint = new Client('http://localhost:3030/jartik');

// Fungsi untuk mendapatkan semua data dosen
function getDataDosen($endpoint, $action = null) {
    $query = "
        PREFIX ex: <http://www.semanticweb.org/mak/ontologies/2024/4/jartik#>
        SELECT ?nip ?namaDosen ?statusKeaktifanDosen ?unitKerjaDosen
        WHERE {
            ?dosen ex:nip ?nip ;
                   ex:namaDosen ?namaDosen ;
                   ex:statusKeaktifanDosen ?statusKeaktifanDosen ;
                   ex:unitKerjaDosen ?unitKerjaDosen .
            FILTER (
                regex(str(?nip), '$action', 'i') ||
                regex(str(?namaDosen), '$action', 'i') ||
                regex(str(?statusKeaktifanDosen), '$action', 'i') ||
                regex(str(?unitKerjaDosen), '$action', 'i')
            )
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

try {
    // Mendapatkan jenis permintaan dari URL
    $action = isset($_GET['search']) ? $_GET['search'] : null;

    // Set header untuk respons JSON
    header('Content-Type: application/json');
    
    $response = [
        'dataDosen' => getDataDosen($endpoint, $action)
    ];

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            // Tampilkan data dosen
            echo json_encode($response);
            break;
        default:
            // Tanggapi permintaan tidak dikenal
            http_response_code(400);
            echo json_encode(['error' => 'Unsupported request method']);
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
