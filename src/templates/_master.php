<!doctype html>
<html lang="en">
<?php Session::load('_head'); ?>

<body>

	<?php Session::load('_navbar'); ?>
	<main id="mainel">
		<?php
		Session::load(Session::currentScript());
		?>
	</main>
	<?php Session::load('_footer'); ?>


	<script>
		// Import FingerprintJS and load it
		AOS.init();
		const fpPromise = import('https://openfpcdn.io/fingerprintjs/v3')
			.then(FingerprintJS => FingerprintJS.load());

		// Get the visitor identifier when you need it.
		fpPromise
			.then(fp => fp.get())
			.then(result => {
				// This is the visitor identifier
				const visitorId = result.visitorId;
				console.log(visitorId);

				// Set the cookie with the fingerprint
				setCookie('fingerprint', visitorId, 1); // Set cookie for 1 day
			})
			.catch(error => {
				console.error("Error loading FingerprintJS:", error);
			});

		// Define the setCookie function to actually set the cookie
		function setCookie(name, value, days) {
			const d = new Date();
			d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000)); // Set expiry time in milliseconds
			const expires = "expires=" + d.toUTCString();
			document.cookie = name + "=" + value + ";" + expires + ";path=/";
		}
			// $(document).ready(function() {
			// 	// Function to check if element is in viewport
			// 	function isInViewport(element) {
			// 		const rect = element.getBoundingClientRect();
			// 		return (
			// 			rect.top >= 0 &&
			// 			rect.left >= 0 &&
			// 			rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
			// 			rect.right <= (window.innerWidth || document.documentElement.clientWidth)
			// 		);
			// 	}

			// 	// Elements to animate
			// 	const elements = $('.animate__animated');

			// 	// Scroll event to trigger animation
			// 	$(window).on('scroll', function() {
			// 		elements.each(function() {
			// 			if (isInViewport(this) && !$(this).hasClass('animate__fadeIn')) {
			// 				// Add animation class when element is visible
			// 				$(this).addClass('animate__fadeIn');
			// 			}
			// 		});
			// 	});

			// 	// Initial check when page is loaded
			// 	$(window).trigger('scroll');
			// });
	</script>

	<!-- If your site uses HTTPS, you may want to add the Secure flag in the cookie so that it can only be transmitted over secure connections. You can do this by appending ; Secure to the cookie string: -->

	<!-- //todo:document.cookie = name + "=" + value + ";" + expires + ";path=/; Secure"; -->

	<!-- To mitigate cross-site request forgery (CSRF) risks, you can add SameSite attribute to restrict how cookies are sent. You can use: -->

	<!-- todo:document.cookie = name + "=" + value + ";" + expires + ";path=/; SameSite=Lax"; -->