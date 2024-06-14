<?php
require_once 'config.php';

// Fungsi untuk mendapatkan semua data dosen
function getDataDosen($endpoint, $action = null) {
    $query = "
    PREFIX all:<http://www.semanticweb.org/aditf/ontologies/2024/4/main-ontology-jejaring-semantik#>
    PREFIX d:<http://www.semanticweb.org/mak/ontologies/2024/4/jartik#>
    PREFIX k:<http://www.semanticweb.org/kenneth/ontologies/2024/4/mahasiswa#>
        SELECT ?nip ?namaDosen ?statusKeaktifanDosen ?unitKerjaDosen ?namaMahasiswa
        WHERE {
            ?dosen d:nip ?nip ;
                   d:namaDosen ?namaDosen ;
                   d:statusKeaktifanDosen ?statusKeaktifanDosen ;
                   d:unitKerjaDosen ?unitKerjaDosen ;
                   d:mengajar ?mhs ;
                   d:mengampu ?mk ;
                   d:membimbing ?prs ;
                   d:membina ?org ;
                   d:menghadiri ?jdwl ;
                   d:mengisi ?nilai ;
                   d:menyusun ?jdwl2.
            ?mhs k:namaMahasiswa ?namaMahasiswa.
            FILTER (
                regex(str(?nip), '$action', 'i') ||
                regex(str(?namaDosen), '$action', 'i') ||
                regex(str(?statusKeaktifanDosen), '$action', 'i') ||
                regex(str(?unitKerjaDosen), '$action', 'i') ||
                regex(str(?namaMahasiswa), '$action', 'i')
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
            'unitKerjaDosen' => $row->unitKerjaDosen->getValue(),
            'namaMahasiswa' => $row->namaMahasiswa->getValue()
        ];
    }

    return $data;
}
?>
