<?php
require_once 'config.php';

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
?>
