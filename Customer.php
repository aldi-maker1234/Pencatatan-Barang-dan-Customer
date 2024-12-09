<?php
class Customer {
    public $id;
    public $nama;
    public $email;
    public $telepon;

    public function __construct($id, $nama, $email, $telepon) {
        $this->id = $id;
        $this->nama = $nama;
        $this->email = $email;
        $this->telepon = $telepon;
    }
}
?>
