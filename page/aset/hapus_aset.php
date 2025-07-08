<?php
	$kode_aset = $_GET['kode_aset'];
	$sql = $konektor->query("DELETE FROM aset WHERE kode_aset = '$kode_aset'");

	if ($sql) {
		?>
			<script type="text/javascript">
			alert("Data Berhasil Dihapus");
			window.location.href="?page=aset";
			</script>
		<?php
	}
?>