<?php
require_once 'config.php';

// Fungsi untuk mendapatkan semua data dosen
function getDataDosen($endpoint, $action = null) {
    $query = "
    PREFIX all:<http://www.semanticweb.org/aditf/ontologies/2024/4/main-ontology-jejaring-semantik#>
    PREFIX d:<http://www.semanticweb.org/mak/ontologies/2024/4/jartik#>
    PREFIX k:<http://www.semanticweb.org/kenneth/ontologies/2024/4/mahasiswa#>
    PREFIX c:<http://www.semanticweb.org/crims/ontologies/2024/4/nilaijartik#>
        SELECT ?nip ?namaDosen ?statusKeaktifanDosen ?unitKerjaDosen ?namaMahasiswa ?namaMatkul ?namaKegiatan ?hariJadwal ?statusKemahasiswaan ?ipkMahasiswa ?nim ?semester ?kodeMatkul ?bobotSKS ?kategori ?pencapaian ?tingkatan ?tahun ?jamJadwal ?ruanganJadwal
        WHERE {
            ?dosen d:nip ?nip ;
                   d:namaDosen ?namaDosen ;
                   d:statusKeaktifanDosen ?statusKeaktifanDosen ;
                   d:unitKerjaDosen ?unitKerjaDosen ;
                   d:mengajar ?mhs ;
                   d:mengampu ?mk ;
                   all:membimbing ?prs ;
                   d:menghadiri ?jdwl ;
                   all:mengisi ?nilai .
            ?mhs k:namaMahasiswa ?namaMahasiswa;
                 k:nim ?nim;
                 k:statusKemahasiswaan ?statusKemahasiswaan;
                 k:semester ?semester.
            ?mk all:namaMatkul ?namaMatkul;
                all:kodeMatkul ?kodeMatkul;
                all:bobotSKS ?bobotSKS.
            ?prs all:namaKegiatan ?namaKegiatan.
            ?jdwl all:hariJadwal ?hariJadwal.
            ?nilai c:ipkMahasiswa ?ipkMahasiswa.
            FILTER (
                regex(str(?nip), '$action', 'i') ||
                regex(str(?namaDosen), '$action', 'i') ||
                regex(str(?statusKeaktifanDosen), '$action', 'i') ||
                regex(str(?unitKerjaDosen), '$action', 'i') ||
                regex(str(?namaMahasiswa), '$action', 'i') ||
                regex(str(?namaMatkul), '$action', 'i') ||
                regex(str(?namaKegiatan), '$action', 'i') ||
                regex(str(?hariJadwal), '$action', 'i') ||
                regex(str(?statusKemahasiwaan), '$action', 'i') ||
                regex(str(?ipkMahasiswa), '$action', 'i') ||
                regex(str(?nim), '$action', 'i') ||
                regex(str(?semester), '$action', 'i') ||
                regex(str(?kodeMatkul), '$action', 'i') ||
                regex(str(?bobotSKS), '$action', 'i') 
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
            'namaMahasiswa' => $row->namaMahasiswa->getValue(),
            'nim' => $row->nim->getValue(),
            'statusKemahasiswaan' => $row->statusKemahasiswaan->getValue(),
            'semester' => $row->semester->getValue(),
            'namaMatkul' => $row->namaMatkul->getValue(),
            'kodeMatkul' => $row->kodeMatkul->getValue(),
            'bobotSKS' => $row->bobotSKS->getValue(),
            'namaKegiatan' => $row->namaKegiatan->getValue(),
            'hariJadwal' => $row->hariJadwal->getValue(),
            'ipkMahasiswa' => $row->ipkMahasiswa->getValue(),
        ];
    }

    return $data;
}
?>
