<?php
require_once 'config.php';
require_once 'dosen.php';

try {
    // Mendapatkan jenis permintaan dari URL
    $action = isset($_GET['search']) ? $_GET['search'] : null;

    // Set header untuk respons JSON
    header('Content-Type: application/json');
    
    $response = [
        'status' => 200,
        'message' => 'Success',
        'dataDosen' => getDataDosen($endpoint, $action)
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