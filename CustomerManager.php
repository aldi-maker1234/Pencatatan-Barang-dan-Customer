<?php
class CustomerManager {
    private $dataFile = 'customers.json';
    private $customerList = [];

    public function __construct() {
        if (file_exists($this->dataFile)) {
            $data = file_get_contents($this->dataFile);
            $this->customerList = json_decode($data, true) ?? [];
        }
    }

    // Menambahkan Customer
    public function tambahCustomer($nama, $email, $telepon) {
        $id = uniqid(); // Generate unique ID
        $customer = [
            'id' => $id,
            'nama' => $nama,
            'email' => $email,
            'telepon' => $telepon
        ];
        $this->customerList[] = $customer;
        $this->simpanData();
    }

    // Mendapatkan Semua Customer
    public function getCustomer() {
        return $this->customerList;
    }

    // Menghapus Customer Berdasarkan ID
    public function hapusCustomer($id) {
        $this->customerList = array_filter($this->customerList, function($customer) use ($id) {
            return $customer['id'] !== $id;
        });
        $this->simpanData();
    }

    // Fungsi untuk menyimpan data
    private function simpanData() {
        file_put_contents($this->dataFile, json_encode($this->customerList, JSON_PRETTY_PRINT));
    }
}
?>
