<?php  
session_start();
?>
<!DOCTYPE html>

<html lang="en">

	<head>
		<meta charset="UTF-8">
		<title>iReddit</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<script type="text/javascript" src="js/reddit.js"></script>
	</head>


	<body>

		<header class="noselect">
			<table>
				<tr>
					<th style="width: 100%;">
						<div class="header-title">iReddit</div>
					</th>
					<th id="id-header-register-area" style="white-space: nowrap;">
						<?php
						if (isset($_SESSION['name'])) {
							echo "<table class=\"button-custom-blue noselect\" onclick=\"openPostModal()\"><tr><th><div class=\"button-custom-text\">Add Post</div></th></tr></table>";
						} else {
							echo "<table class=\"button-custom-blue noselect\" onclick=\"openRegisterModal()\"><tr><th><div class=\"button-custom-text\">Register</div></th></tr></table>";
						}
						?>
					</th>
					<th id="id-header-login-area">
						<?php
						if (isset($_SESSION['name'])) {
							echo "<table class=\"button-custom-red noselect\" onclick=\"logOut()\"><tr><th><div class=\"button-custom-text\">Log out</div></th></tr></table>";
						} else {
							echo "<table class=\"button-custom-green noselect\" onclick=\"openLoginModal()\"><tr><th><div class=\"button-custom-text\">Login</div></th></tr></table>";
						}
						?>
					</th>
				</tr>
			</table>
		</header>

		<main class="main" id="id-main">
			<table class="main-header noselect">
				<tr>
					<th>
						<div class="main-header-title text-color-gray">#</div><div class="main-header-title" id="id-main-header-title">Hot |</div><div class="main-header-subtitle">All best for you</div>
					</th>
				</tr>
			</table>
			<div id="id-main-posts" class="main-margin">


			</div>
		</main>
		<div class="aside-container">
		<aside>
			<table class="aside-header noselect">
				<tr>
					<th>
						<div class="aside-header-title text-color-gray">#</div><div class="aside-header-title">Nav |</div><div class="aside-header-subtitle">The best navigation</div>
					</th>
				</tr>
			</table>
			<div class="aside-padding">
				<div class="text-link" onclick="loadContent('Hot')">#Hot</div>
				<div class="text-link" onclick="loadContent('New')">#New</div>
				<div class="text-link" onclick="loadContent('Best')">#Best</div>
			</div>
			
		</aside>

		<aside>
			<table class="aside-header noselect">
				<tr>
					<th>
						<div class="aside-header-title text-color-gray">#</div><div class="aside-header-title">Top |</div><div class="aside-header-subtitle">The best ones</div>
					</th>
				</tr>
			</table>
			<div class="aside-padding">
				List of most active users:<br>
				1. Kala<br>
				2. Polo<br>
				3. Marko<br>
				4. Natasha<br>
				5. Oleg<br>
				6. Ivan<br>
				7. Vladimir<br>
				8. Oleg<br>
				9. Natasha<br>
				10. Kostja
			</div>
			
		</aside>

		<aside>
			<table class="aside-header noselect">
				<tr>
					<th>
						<div class="aside-header-title text-color-gray">#</div><div class="aside-header-title">Ad |</div><div class="aside-header-subtitle">Best ads for you</div>
					</th>
				</tr>
			</table>
			<div class="aside-padding">Treehouse! Only 7 small payments of 9.99.</div>
			
		</aside>
		</div>



			<!-- Authorization Modal -->
		<div id="id-modal-login" class="modal">
			<div class="modal-content">
			    <div class="modal-header">Authorization</div>

			    <div class="modal-body">
			    	<div class="modal-marginarea">			    		
				    	<div class="modal-text noselect">Enter your username:</div>
						<input type="text" id="id-modal-login-usernamefield" placeholder="Username" autoComplete="off">

						<div class="modal-text noselect">Enter your password:</div>
						<input type="password" id="id-modal-login-passwordfield" placeholder="Password" autoComplete="off">
			    	</div>

					<table>
						<tr>
							<th>
								<table style="width: 100%; margin: 0;" class="button-custom-green noselect" onclick="login()">
									<tr><th><div class="button-custom-text">Login</div></th></tr>
								</table>
							</th>
						</tr>
					</table>
			    </div>
			</div>
		</div>



			<!-- Registration Modal -->
		<div id="id-modal-register" class="modal">
			<div class="modal-content">
			    <div class="modal-header">Authorization</div>

			    <div class="modal-body">
			    	<div class="modal-marginarea">
			    		<div class="modal-text noselect">Enter your full name:</div>
						<input type="text" id="id-modal-register-fullnamefield" placeholder="Name Last-name" autoComplete="off">

						<div class="modal-text noselect">Enter your E-Mail:</div>
						<input type="text" id="id-modal-register-emailfield" placeholder="E-Mail" autoComplete="off">	

				    	<div class="modal-text noselect">Enter your username:</div>
						<input type="text" id="id-modal-register-usernamefield" placeholder="Username" autoComplete="off">

						<div class="modal-text noselect">Enter your password:</div>
						<input type="password" id="id-modal-register-passwordfield" placeholder="Password" autoComplete="off">
			    	</div>

					<table>
						<tr>
							<th>
								<table style="width: 100%; margin: 0;" class="button-custom-blue noselect" onclick="register()">
									<tr><th><div class="button-custom-text">Register</div></th></tr>
								</table>
							</th>
						</tr>
					</table>
			    </div>
			</div>
		</div>

			<!-- Post Modal -->
		<div id="id-modal-post" class="modal">
			<div class="modal-content">
			    <div class="modal-header">Add Post</div>

			    <div class="modal-body">
			    	<div class="modal-marginarea">			    		
				    	<div class="modal-text noselect">Enter your title:</div>
						<input type="text" id="id-modal-post-titlefield" placeholder="Title" autoComplete="off">

						<div class="modal-text noselect">Enter your text:</div>
						<textarea id="id-modal-post-textfield" placeholder="Text"></textarea>
			    	</div>

					<table>
						<tr>
							<th>
								<table style="width: 100%; margin: 0;" class="button-custom-blue noselect" onclick="post()">
									<tr><th><div class="button-custom-text">Post</div></th></tr>
								</table>
							</th>
						</tr>
					</table>
			    </div>
			</div>
		</div>

			<!-- ErrorMessage Modal -->
		<div id="id-modal-message-error" class="modal-small">
			<div class="modal-content-small">
			    <div class="modal-header">Error-Message</div>

			    <div class="modal-body">
			    	<div class="modal-marginarea">
			    		<div id="id-modal-message-error-text" class="modal-text noselect" style="color: #f55;">Error message</div>
			    	</div>
			    </div>
			</div>
		</div>

			<!-- SucessMessage Modal -->
		<div id="id-modal-message-success" class="modal-small">
			<div class="modal-content-small">
			    <div class="modal-header">Message</div>

			    <div class="modal-body">
			    	<div class="modal-marginarea">
			    		<div id="id-modal-message-success-text" class="modal-text noselect" style="color: #4CAF50;">Message</div>
			    	</div>
			    </div>
			</div>
		</div>


			<!-- Scripts to run -->
		<script>
			prepareModals();
			setEnterKeyFunctionality();
			<?php
			if (isset($_SESSION['name'])) {
				$name = $_SESSION['name'];
				echo "pushMessageSucess('Welcome back, $name')";
			}
			?>

			loadContent("Hot");
		</script>

	</body>

</html>