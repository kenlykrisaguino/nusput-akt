<?php
	$kode_transaksi = $_GET['kode_transaksi'];
	$sql = $konektor->query("delete from master_transaksi where kode_transaksi = '$kode_transaksi'");

	if ($sql) {
		?>
			<script type="text/javascript">
			alert("Data Berhasil Dihapus");
			window.location.href="?page=master_transaksi&aksi=backup";
			</script>
		<?php
	}
?>