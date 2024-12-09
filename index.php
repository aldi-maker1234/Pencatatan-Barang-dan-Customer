<?php 
require_once 'Barang.php';
require_once 'BarangManager.php';
require_once 'CustomerManager.php';

$customerManager = new CustomerManager();
$barangManager = new BarangManager();

// Menangani form tambah barang
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    // Validasi input
    if (is_numeric($harga) && is_numeric($stok) && $harga > 0 && $stok >= 0) {
        $barangManager->tambahBarang($nama, $harga, $stok);
        header('Location: index.php'); // Redirect untuk mencegah resubmission
        exit; // Pastikan untuk menghentikan eksekusi setelah redirect
    } else {
        echo "<script>alert('Harga dan stok harus berupa angka positif.');</script>";
    }
}

if (isset($_GET['hapus_barang'])) {
    $id = $_GET['hapus_barang'];
    $barangManager->hapusBarang($id);
    header('Location: index.php'); // Redirect setelah menghapus
    exit; // Pastikan untuk menghentikan eksekusi setelah redirect
}
// Handle Tambah Customer
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $telepon = $_POST['telepon'];
    $customerManager->tambahCustomer($nama, $email, $telepon);
    header('Location: index.php');
    exit;
}

// Handle Hapus Customer
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $customerManager->hapusCustomer($id);
    header('Location: index.php');
    exit;
}

$customerList = $customerManager->getCustomer();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencatatan Barang dan Pencatatan Customer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        table, th, td{
            text-align: center;
            padding: 15px
        }
        .btn {
            text-decoration: none;
            padding: 5px 10px;
            color: white;
            border-radius: 5px;
        }
        .btn-add {
            background-color: #4CAF50; /* Green */
        }
        .btn-add:hover{
            background-color: #507847;
            color: #f8fcf7;
        }
        .btn-delete {
            background-color: #f44336; /* Red */
        }
        .btn-delete:hover{
            background-color: #a33a33;
        }
        input[type="text"],
    input[type="email"],
    input[type="number"] {
        width: 300px; /* Lebar kotak input */
        padding: 5px; /* Jarak dalam kotak input */
        border: 1px solid #ccc; /* Warna dan ukuran border */
        border-radius: 5px; /* Membuat sudut border melengkung */
    }

    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="number"]:focus {
        border-color: #15eaed; /* Warna border saat input aktif */
        outline: none; /* Menghilangkan outline default */
    }
    h1{
        text-align: center;
    }
    h2{
        text-align: center;
    }
    </style>
</head>
<body>
    <div class="container">
        <h1>Pencatatan Barang</h1>
        <form method="POST" action="">
            <div>
                <br><label for="nama">Nama Barang:</label><br>
                <br><input type="text" name="nama" id="nama" required><br>
            </div>
            <div>
                <br><label for="harga">Harga Barang:</label><br>
                <br><input type="number" name="harga" id="harga" required>
            </div>
            <div>
                <br><label for="stok">Stok Barang:</label><br>
                <br><input type="number" name="stok" id="stok" required>
            </div>
            <br><button type="submit" name="tambah" class="btn btn-add">Tambah Barang</button>
        </form>

        <br><h2>Daftar Barang</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($barangManager->getBarang() as $barang): ?>
                    <tr>
                        <td><?= htmlspecialchars($barang['id']) ?></td>
                        <td><?= htmlspecialchars($barang['nama']) ?></td>
                        <td><?= htmlspecialchars($barang['harga']) ?></td>
                        <td><?= htmlspecialchars($barang['stok']) ?></td>
                        <td>
                        <a href="?hapus_barang=<?= htmlspecialchars($barang['id']) ?>" class="btn btn-delete">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
            <br><h1>Pencatatan Customer</h1>

<form method="POST">
    <br><label for="nama">Nama:</label><br>
    <br><input type="text" id="nama" name="nama" required><br><br>

    <br><label for="email">Email:</label><br>
    <br><input type="email" id="email" name="email" required><br><br>

    <br><label for="telepon">Telepon:</label><br>
    <br><input type="text" id="telepon" name="telepon" required><br><br>

    <br><button type="submit" name="tambah" class="btn btn-add">Tambah Customer:</button>
</form>

<h2>Daftar Customer</h2>
<table>
    <thead>
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Telepon</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($customerList)) : ?>
            <tr>
                <td colspan="4" style="text-align: center;">Tidak ada data.</td>
            </tr>
        <?php else : ?>
            <?php foreach ($customerList as $customer) : ?>
                <tr>
                    <td><?= htmlspecialchars($customer['nama']); ?></td>
                    <td><?= htmlspecialchars($customer['email']); ?></td>
                    <td><?= htmlspecialchars($customer['telepon']); ?></td>
                    <td>
                        <a href="?hapus=<?= htmlspecialchars($customer['id']) ?>" class="btn btn-delete">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
        </div>
    </body>
</html>