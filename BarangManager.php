<?php 
class BarangManager {
    private $dataFile = 'data.json';
    private $barangList = [];

    public function __construct() { 
        if (file_exists($this->dataFile)) {
            $data = file_get_contents($this->dataFile);
            $this->barangList = json_decode($data, true) ?? [];
        }
    }    

    // Menambahkan Barang
    public function tambahBarang($nama, $harga, $stok) {
        $id = uniqid(); // Generate uniq id
        $barang = new Barang($id, $nama, $harga, $stok);
        $this->barangList[] = $barang;
        $this->simpanData();
    }

    // Mendapatkan Semua Barang
    public function getBarang(){
        return $this->barangList;
    }

    // Menghapus Barang Berdasarkan ID
    public function hapusBarang($id){
        $this->barangList = array_filter($this->barangList, function($barang) use ($id) {
            return $barang['id'] !== $id;
        });
        $this->simpanData(); // Memanggil fungsi simpanData dengan tanda kurung ()
    }

    // Fungsi untuk menyimpan data
    private function simpanData() {
        file_put_contents($this->dataFile, json_encode($this->barangList, JSON_PRETTY_PRINT));
    }
}
?>