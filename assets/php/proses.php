<?php
include 'config.php';

if (isset($_POST['submit'])) {
    $nama_produk = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $jumlah = $_POST['jumlah'];

    $stmt = $pdo->prepare("INSERT INTO barang (nama_produk, harga, jumlah) VALUES (:nama, :harga, :jumlah)");
    $stmt->bindParam(':nama', $nama_produk);
    $stmt->bindParam(':harga', $harga);
    $stmt->bindParam(':jumlah', $jumlah);

    if ($stmt->execute()) {
        header("Location: ../../index.php");
        exit();
    } else {
        echo "Error: " . $e->getMessage();
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    // $query = "DELETE FROM barang WHERE id='$id'";
    $stmt = $pdo->prepare("DELETE FROM barang WHERE id = :id");
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        // Mengupdate ID setelah penghapusan
        $result = $pdo->prepare("SELECT * FROM barang ORDER BY id");

        $counter = 1;
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $updateQuery = $pdo->prepare("UPDATE barang SET id='$counter' WHERE id=" . $row['id']);
            $counter++;
        }

        header("Location: ../../index.php"); // Arahkan kembali setelah berhasil
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
