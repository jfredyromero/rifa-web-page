function onlyNumberKey(evt) {
	// Only ASCII character in that range allowed
	var ASCIICode = evt.which ? evt.which : evt.keyCode;
	if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57)) return false;
	return true;
}

var tickets_values = [];
var inputAmount = document.querySelector('input[name="amount"]');
var inputExtra1 = document.querySelector('input[name="extra1"]');
var spanAmount = document.getElementById("price");

document.getElementById("tickets-grid-container").addEventListener("click", function () {

	var svg = Array.from(document.getElementsByTagName("path"));
	var tickets = Array.from(document.getElementsByName("checkbox-ticket"));

	tickets_values = [];
	var ticket_price = 65000;

	tickets.forEach(t => {
		if (t.checked == true) {
			tickets_values.push(t.value);
			svg[tickets.indexOf(t)].setAttribute("fill", "url(#gold)");
		} else {
			svg[tickets.indexOf(t)].setAttribute("fill", "url(#silver)");
		}
	});

	inputExtra1.value = tickets_values.join("-");
	inputAmount.value = tickets_values.length * ticket_price;

	console.clear();
	console.log(inputExtra1.value);

	spanAmount.textContent = "$ "+inputAmount.value; 

});

document.addEventListener("DOMContentLoaded", () => {

	var inpCelular = document.getElementById("inpCelular");
	var flag = 0;

	// inpCelular.addEventListener("keyup", function () {
	//   var tel = inpCelular.value;

	//   if (tel.length > 0 && tel.length < 3) {
	//     flag = 0;
	//   }

	//   if (tel.length > 3 && tel.length < 7) {
	//     flag = 1;
	//   }

	//   if (tel.length == 3 && flag == 0) {
	//     tel = tel + "-";
	//     inpCelular.value = tel;
	//     flag = 1;
	//   }

	//   if (tel.length == 7 && flag == 1) {
	//     tel = tel + "-";
	//     inpCelular.value = tel;
	//     flag = 2;
	//   }
	// });

	const countdown = () => {
		const tiempoObjetivo = new Date("Jan 1, 2022 00:00:00").getTime();
		const tiempoActual = new Date().getTime();
		const tiempoRestante = tiempoObjetivo - tiempoActual;

		const segundos = 1000;
		const minutos = segundos * 60;
		const horas = minutos * 60;
		const dias = horas * 24;

		const textoDias = Math.floor(tiempoRestante / dias);
		const textoHoras = Math.floor((tiempoRestante % dias) / horas);
		const textoMinutos = Math.floor((tiempoRestante % horas) / minutos);
		const textoSegundos = Math.floor((tiempoRestante % minutos) / segundos);

		document.getElementById("dias").innerHTML = textoDias;
		document.getElementById("horas").innerHTML = textoHoras;
		document.getElementById("minutos").innerHTML = textoMinutos;
		document.getElementById("segundos").innerHTML = textoSegundos;
	};

	setInterval(countdown, 1000);

	let buyerName = document.querySelector('input[name="buyerFullName"]');
	buyerName.addEventListener('change', () => {
		let text = buyerName.value;
		document.querySelector('input[name="payerFullName"]').value = text;
	})

	let mobilePhone = document.querySelector('input[name="mobilePhone"]');
	mobilePhone.addEventListener('change', () => {
		let text = mobilePhone.value;
		document.querySelector('input[name="payerMobilePhone"]').value = text;
	})

	let payerDocument = document.querySelector('input[name="payerDocument"]');
	payerDocument.addEventListener('change', () => {
		let text = payerDocument.value + "-" + buyerName.value;
		document.querySelector('input[name="extra2"]').value = text;
	})

	// let codigoReferido = document.querySelector('input[name="codigoReferido"]');
	// codigoReferido.addEventListener('change', () => {
	// 	let text = codigoReferido.value;
	// 	document.querySelector('input[name="extra3"]').value = text;
	// })

	let formBoleta = document.querySelector('#form-boleta');
	formBoleta.addEventListener('submit', (e) => {
		
		if (inputExtra1.value == "") {
			e.preventDefault();
			Swal.fire({
				title: 'Oops',
				text: "Debe seleccionar al menos una boleta!",
				icon: 'warning',
				confirmButtonColor: '#3085d6',
				confirmButtonText: 'Ok'
			});
			return false;
		}else{
			generarCodigoReferencia();
			// generarSignature();
			generarDescripcion();
			return true;
		}
	})

	function generarCodigoReferencia() {
		numeroBoleta = document.querySelector('input[name="extra1"]');
		let referenceCode = buyerName.value + "-" + numeroBoleta.value + "-" + Date.now();
		document.querySelector('input[name="referenceCode"]').value = referenceCode;
	}

	// function generarSignature() {
	// 	const apiKey = "4Vj8eK4rloUd272L48hsrarnUA";
	// 	const merchanId = "508029";
	// 	const amount = inputAmount.value;
	// 	const currency = "COP";
	// 	let referenceCode = document.querySelector('input[name="referenceCode"]').value;
	// 	let signature = CryptoJS.MD5(apiKey + "~" + merchanId + "~" + referenceCode + "~" + amount + "~" + currency);
	// 	document.querySelector('input[name="signature"]').value = signature + "";
	// }

	function generarDescripcion() {
		let nombre = buyerName.value;
		let boletas = [];
		for (let ticket of tickets_values) {
			boletas.push(" #" + ticket);
		}
		let description = "";
		if (boletas.length > 1) {
			last_boletas = boletas.pop();
			description = `Compra de las boletas${boletas} y${last_boletas} válidas para sorteo de espectacular vehículo. La compra es realizada a nombre de ${nombre}`;
		} else {
			description = `Compra de la boleta${boletas} válida para sorteo de espectacular vehículo. La compra es realizada a nombre de ${nombre}`;
		}
		document.querySelector('input[name="description"]').value = description;
	}

})