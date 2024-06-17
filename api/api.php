<?php
require_once 'config.php';
require_once 'dosen.php';

try {
    // Mendapatkan jenis permintaan dari URL
    $action = isset($_GET['search']) ? $_GET['search'] : null;
    $action = strtolower($action);

    // Set header untuk respons JSON
    header('Content-Type: application/json');
    header("Access-Control-Allow-Origin: *");
    // header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");

    // Inisialisasi variabel response
    $dosen = new Dosen();
    
    $response = [
        'status' => 200,
        'message' => 'Success',
        'dataAllDosen' => $dosen->getAllDosen($endpoint, $action),
        'dataDosenMahasiswa' => $dosen->getDosenMahasiswa($endpoint, $action),
        'dataDosenMatakuliah' => $dosen->getDosenMatakuliah($endpoint, $action),
        'dataDosenPrestasi' => $dosen->getDosenPrestasi($endpoint, $action),
        'dataDosenOrganisasi' => $dosen->getDosenOrganisasi($endpoint, $action),
        'dataDosenJadwal' => $dosen->getDosenJadwal($endpoint, $action),
        'dataDosenNilai' => $dosen->getDosenNilai($endpoint, $action),
    ];

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            // Tampilkan data dosen
            http_response_code(200);
            // echo json_encode($response, JSON_PRETTY_PRINT); // Tampilkan dengan format JSON yang lebih mudah dibaca
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