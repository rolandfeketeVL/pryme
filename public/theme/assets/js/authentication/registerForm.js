var togglePassword = document.getElementById("toggle-password");

if (togglePassword) {
	togglePassword.addEventListener('click', function() {
		let x = document.getElementById("registration_form_plainPassword");
		if (x.type === "password") {
			x.type = "text";
		} else {
			x.type = "password";
		}
	});
}