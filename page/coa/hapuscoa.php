<?php
	$kode_akun = $_GET['kode_akun'];
	$sql = $konektor->query("delete from akun where kode_akun = '$kode_akun'");

	if ($sql) {
		?>
			<script type="text/javascript">
			alert("Data Berhasil Dihapus");
			window.location.href="?page=coa&aksi=backup";
			</script>
		<?php
	}
?>