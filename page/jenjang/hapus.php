<?php
	$kode_jenjang = $_GET['kode_jenjang'];
	$sql = $konektor->query("delete from master_jenjang where kode_jenjang = '$kode_jenjang'");

	if ($sql) {
		?>
			<script type="text/javascript">
			alert("Data Berhasil Dihapus");
			window.location.href="?page=jenjang&aksi=backup";
			</script>
		<?php
	}
?>