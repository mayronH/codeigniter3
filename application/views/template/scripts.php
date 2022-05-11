<!-- Bootstrap core JavaScript
			================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
<script src="<?php echo base_url(); ?>public/js/bootstrap.min.js"></script>

<?php
if (isset($scripts)) {
	foreach ($scripts as $script_name) {
		$href = base_url() . "public/js/" . $script_name;
?>

		<script src="<?= $href ?>"></script>
<?php
	}
}
?>
</body>

</html>