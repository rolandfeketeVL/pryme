var togglePassword = document.getElementById("toggle-password");

if (togglePassword) {
	togglePassword.addEventListener('click', function() {
		let x = document.getElementById("inputPasswordZ");
		if (x.type === "password") {
			x.type = "text";
		} else {
			x.type = "password";
		}
	});
}