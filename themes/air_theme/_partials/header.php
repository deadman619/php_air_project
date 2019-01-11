<header id="header">
				<h1><a href="index.php">aviaSYSTEM</a></h1>
				<nav id="nav">
					<ul>
						<?php if (isset($_SESSION['login'])) {
							$navbar['Admin'] = $navbar['Log In'];
							unset($navbar['Log In']);
							$navbar['Log Out'] = 'logout';
                      		renderNav($navbar);
                      	} else {
							renderNav($navbar);
						} ?>
					</ul>
				</nav>
</header>