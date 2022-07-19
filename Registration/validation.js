var forms = document.querySelectorAll('.needs-validation')

//Validation of the form
document.getElementById("sendForm").addEventListener('click', function (event) {
	Array.prototype.slice.call(forms).forEach(function (formx) {
		var idList = Array.from(formx).map(i => i.id);
		idList.forEach(function (objId) {
			document.getElementById(objId).setCustomValidity("");
		});
		var form = $("#registration").serialize();
		$.ajax({
			url: 'validation.php',
			type: 'POST',
			data: form,
			beforeSend: function() {
				$("#sendForm").prop("disabled", true);
			},
			success: function(data) {
				data = JSON.parse(data);
				document.getElementById("errorMessages").innerHTML = data.msg;
				if(data.hasOwnProperty('error'))
				{
					for (var prop in data)
					{
						if((typeof data[prop] == "boolean") && idList.includes(prop) && data[prop])
						{
							document.getElementById(prop).setCustomValidity("Поле пустое");
						}
					}		
					if(data.notEmail)
					{
						document.getElementById('email').setCustomValidity("Почта введена неверно");
					}
					if(data.differentPasswords)
					{
						document.getElementById('password').setCustomValidity("Пароли не совпадают");
						document.getElementById('checkPassword').setCustomValidity("Пароли не совпадают");
					}
				}
				else if(data.hasOwnProperty('usedEmail'))
				{
					document.getElementById('email').setCustomValidity("Пользователь с таким email уже существует");
				}
				else
				{
					document.getElementById('registration').classList.add('successRegistration');
					document.getElementById('sendForm').classList.add('successRegistration');
					document.getElementById('sendForm').classList.remove('btn');
				}
				$("#sendForm").prop("disabled", false);
			}
		})
		if (!formx.checkValidity()) {
			event.preventDefault();
			event.stopPropagation();
		}
		formx.classList.add('was-validated');
	})
})


