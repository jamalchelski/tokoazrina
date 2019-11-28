<?php 
session_start();
include 'koneksi.php';

if (empty($_SESSION['keranjang']) OR !isset($_SESSION['keranjang']))
 {
  echo "<script>alert('anda harus memilih produk terlebih dahulu');</script>";
  echo "<script>location='index.php';</script>";
  
 }

 ?>
 <!DOCTYPE html>
<html>
<head>
	<title>keranjang</title>
	<link rel="stylesheet" href="admin/assets/css/bootstrap.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<section class="konten">
	<div class="container">
		<h1>Keranjang belanja</h1>
		<hr>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>No</th>
					<th>Produk</th>
					<th>Harga </th>
					<th>Jumlah</th>
					<th>Subharga </th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php $nomor=1; ?>
				<?php foreach ($_SESSION ['keranjang'] as $id_produk => $jumlah): ?> 
				<?php 
				$ambil = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'");
				$pecah = $ambil->fetch_assoc();

				 ?>	
				<tr>
					<td><?php echo $nomor; ?></td>
					<td><?php echo $pecah['nama_produk']; ?></td>
					<td>Rp. <?php echo number_format($pecah['harga_produk']); ?></td>
					<td><?php echo $jumlah; ?></td>
					<td>Rp. <?php echo number_format($pecah['harga_produk']*$jumlah); ?></td>
					<td>
						<a href="hapuskeranjang.php?id=<?php echo $id_produk; ?>" class="btn btn-danger btn-x5">Hapus</a>
					</td>
				</tr>
				<?php $nomor++; ?>
			<?php endforeach ?>
			</tbody>
		</table>
		<a href="index.php" class="btn btn-default">Lanjutkan belanja</a>
		<a href="checkout.php" class="btn btn-primary">Checkout</a>
		

	</div>
</section>
</body>
</html>
