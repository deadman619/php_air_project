<?php session_start();
require "config/config.php";
require 'inc/functions.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<?php require "themes/$theme/_partials/head.php"; ?>
</head>
	<body>

		<?php require "themes/$theme/_partials/header.php";
		require 'config/router.php'; ?>
	</body>

	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script>
    $(document).ready(function() {
        $('.modal').on('click', function() {
            $('#dialog').dialog({width: 600});
        });
    });

	</script>
</html>