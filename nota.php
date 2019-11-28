<?php  include 'koneksi.php';
session_start();

if (!isset($_SESSION["pelanggan"]) OR empty($_SESSION["pelanggan"]) ) 
{
	echo "<script>alert('Silahkan Login');</script>";
	echo "<script>location='login.php';</script>";
}

$id_halaman=$_GET['id']; ?>
<!DOCTYPE html>
<html>
<head>
	<title>nota pembelian</title>
	<link rel="stylesheet" href="admin/assets/css/bootstrap.css">
</head>
<body>
	<!---- Navbar ---->
<nav class="navbar navbar-default">
	<div class="container">
		<ul class="nav navbar-nav">
			<li><a href="index.php">Home</a></li>
			<li><a href="keranjang.php">Keranjang</a></li>
			<?php if (isset($_SESSION['pelanggan'])): ?>
				<li><a href="logout.php">Logout</a></li>
			<?php else: ?>
				<li><a href="login.php">Login</a></li>
			<?php endif ?>
			<li><a href="checkout.php">Checkout</a></li>
			<li><a href="about.php">About</a></li>
		</ul>
	</div>
</nav>

<section class="konten">
	<div class="container">
		
		<h2>Nota Pembelian</h2>

<?php 
$ambil= $koneksi->query("SELECT * FROM pembelian JOIN pelanggan 
	ON pembelian.id_pelanggan = pelanggan.id_pelanggan 
	WHERE pembelian.id_pembelian = '$_GET[id]'");
$detail = $ambil-> fetch_assoc();
?>

<?php 
$idpelangganyangbeli=$detail["id_pelanggan"];
$idplangganyanglogin=$_SESSION["pelanggan"]["id_pelanggan"];

if ($idpelangganyangbeli!==$idplangganyanglogin) {
	echo "<script>alert('Data terproteksi');</script>";
	echo "<script>location='riwayat.php';</script>";
	exit();
}

 ?>

<div class="row">
	<div class="col-md-4">
		<h3>Pembelian</h3>
		<strong>No. Pembelian : <?php echo $detail['id_pembelian']; ?></strong><br>
		Tanggal <?php echo $detail['tanggal_pembelian']; ?><br>
		Total pembelian : Rp. <?php echo number_format($detail['total_pembelian']); ?>
	</div>
	<div class="col-md-4">
		<h3>Pelanggan</h3>
		<strong><?php echo $detail['nama_pelanggan']; ?></strong><br>
		<p>
			<?php echo $detail['telphone_pelanggan']; ?><br>
			<?php echo $detail['email_pelanggan']; ?>
		</p>
	</div>
	<div class="col-md-4">
		<h3>Kota tujuan</h3>
		<strong><?php echo $detail['nama_kota']; ?></strong><br>
		Ongkos kirim : Rp. <?php echo number_format($detail['tarif']); ?><br> 
		Alamat penerima :<?php echo $detail['alamat_pengiriman']; ?><br>
	</div> 
</div>

<table class="table table-bordered">
	<thead>
		<tr>
			<th>No</th>
			<th>Nama Produk</th>
			<th>Harga</th>
			<th>Berat</th>
			<th>Jumlah</th>
			<th>Subberat</th>
			<th>Subtotal</th>
		</tr>
	</thead>
	<tbody>
		<?php $nomor=1; ?>
		<?php $ambil=$koneksi->query("SELECT * FROM pembelian_produk WHERE id_pembelian='$_GET[id]'"); ?>
		<?php while($pecah = $ambil->fetch_assoc()){ ?>
		<tr>
			<td><?php echo $nomor; ?></td>
			<td><?php echo $pecah['nama']; ?></td>
			<td><?php echo $pecah['harga']; ?></td>
			<td><?php echo number_format($pecah['berat']); ?> Gram</td>
			<td><?php echo $pecah['jumlah']; ?></td>
			<td><?php echo number_format($pecah['subberat']); ?> Gram</td>
			<td>Rp. <?php echo number_format($pecah['subharga']); ?></td>
			
		</tr>
		<?php $nomor++; ?>
		<?php } ?>
	</tbody>
</table>
<div class="row">
	<div class="col-md-7">
		<div class="alert alert-info">
			<p>
				Silahkan melakukan pembayaran sebesar Rp. <?php echo number_format($detail['total_pembelian']); ?>ke <br>
				<strong>BANK MANDIRI 131-000705-9308 AN. CUCUM SUMINAR</strong>
			</p>
			<!-- <a href="print.php?id=<?php echo $id;?>" >print</a> -->
			
		</div>
		<a href="print.php?id=<?php echo $id_halaman;?>" class="btn btn-primary">Print</a>
	</div>
</div>


	</div>
</section>
<!-- <script>
		window.print();
	</script> -->
</body>
</html>
