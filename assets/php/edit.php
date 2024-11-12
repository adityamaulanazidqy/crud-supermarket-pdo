<?php
require_once 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $result = $pdo->prepare("SELECT * FROM barang WHERE id = :id");
    $result->bindParam(':id', $id);
    $result->execute();

    if ($result && $result->rowCount() > 0) {
        $row = $result->fetch(PDO::FETCH_ASSOC);
    } else {
        echo "Data tidak ditemukan.";
        exit();
    }
}

if (isset($_POST['update'])) {
    $nama_produk = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $jumlah = $_POST['jumlah'];

    // $query = "UPDATE barang SET nama_produk='$nama_produk', harga='$harga', jumlah='$jumlah' WHERE id='$id'";
    $result = $pdo->prepare("UPDATE barang SET nama_produk = :nama_produk, harga = :harga, jumlah = :jumlah WHERE id = :id");
    $result->bindParam(':nama_produk', $nama_produk);
    $result->bindParam(':harga', $harga);
    $result->bindParam(':jumlah', $jumlah);
    $result->bindParam(':id', $id);

    if ($result->execute()) {
        header("Location: ../../index.php"); // Arahkan kembali setelah berhasil
        exit();
    } else {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Edit Produk</title>
</head>

<body>
    <div class="container">
        <h1>Edit Produk</h1>
        <form action="" method="POST">
            <input type="text" name="nama_produk" value="<?php echo $row['nama_produk']; ?>" required>
            <input type="number" name="harga" value="<?php echo $row['harga']; ?>" required>
            <input type="number" name="jumlah" value="<?php echo $row['jumlah']; ?>" required>
            <button type="submit" name="update">Update Produk</button>
        </form>
    </div>
</body>

</html>