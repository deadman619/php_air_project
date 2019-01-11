<?php

if (!isset($_GET['page'])) {
	$_GET['page'] = 'home';
}

$routerEngine = $_GET['page'];
if ($routerEngine) {
	switch ($routerEngine) {
		case "home":
			include "themes/$theme/pages/home.php";
			include "themes/$theme/pages/add_testimonial.php";
			include "themes/$theme/_partials/footer.php";
			break;
		case "order":
			include "themes/$theme/pages/order_flight.php";
			break;
		case "details":
			include "themes/$theme/pages/flight_detail.php";
			break;
		case "login":
			if (isset($_SESSION['login'])) {
				include "themes/$theme/pages/management_page.php";
				include "themes/$theme/pages/management_form.php";
			} else {
				include "themes/$theme/pages/login.php";
			}
			break;
		case "logout":
			session_destroy();
			header("Location: index.php");
		default:
			include "themes/$theme/pages/404.php";
	}
} 
