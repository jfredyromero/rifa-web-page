function onlyNumberKey(evt) {
	// Only ASCII character in that range allowed
	var ASCIICode = evt.which ? evt.which : evt.keyCode;
	if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57)) return false;
	return true;
}

var revancha_price = document.getElementById("precioRevancha").innerHTML;
var tickets_values = [];
var inputAmount = document.querySelector('input[name="amount"]');
var inputExtra1 = document.querySelector('input[name="extra1"]');
var ticket_price = document.getElementById('precio').innerHTML;
var spanAmount = document.getElementById("price");

document.getElementById("tickets-grid-container").addEventListener("click", function () {

	var svg = Array.from(document.getElementsByTagName("path"));
	var tickets = Array.from(document.getElementsByName("checkbox-ticket"));

	// Funciona para resetear. No borrar
	tickets_values = [];
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

	spanAmount.textContent = "$ "+inputAmount.value; 

});

document.addEventListener("DOMContentLoaded", () => {

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

	function boletasRevancha() {
		var spanAmountRevancha = document.getElementById("priceRevancha");
		spanAmountRevancha.textContent = "$ "+inputAmount.value;
		spanAmountTotal = inputAmount.value;
		let boletas = "";
		tickets_values.forEach(t => {
			boletas += `<div class="ticket">
							<svg min-width="175" min-height="117" width="50%" viewBox="0 0 175 117"fill="none" xmlns="http://www.w3.org/2000/svg">
								<path class="ticket-svg-revancha"
									d="M38.8889 29.25H136.111V87.75H38.8889V29.25ZM160.417 58.5C160.417 66.5773 166.946 73.125 175 73.125V102.375C175 110.452 168.471 117 160.417 117H14.5833C6.52908 117 0 110.452 0 102.375V73.125C8.05425 73.125 14.5833 66.5773 14.5833 58.5C14.5833 50.4227 8.05425 43.875 0 43.875V14.625C0 6.54773 6.52908 0 14.5833 0H160.417C168.471 0 175 6.54773 175 14.625V43.875C166.946 43.875 160.417 50.4227 160.417 58.5ZM145.833 26.8125C145.833 22.7739 142.569 19.5 138.542 19.5H36.4583C32.4312 19.5 29.1667 22.7739 29.1667 26.8125V90.1875C29.1667 94.2261 32.4312 97.5 36.4583 97.5H138.542C142.569 97.5 145.833 94.2261 145.833 90.1875V26.8125Z"
									fill="url(#gold)" />
								<defs>
								<linearGradient id="gold" x1="87.5" y1="0" x2="87.5" y2="117" gradientUnits="userSpaceOnUse">
									<stop stop-color="#95702c" />
									<stop offset="0.5" stop-color="#f8dd57" />
									<stop offset="1" stop-color="#95702c" />
								</linearGradient>
								<linearGradient id="red" x1="256" y1="0" x2="256" y2="512" gradientUnits="userSpaceOnUse">
									<stop stop-color="#8D1D10" />
									<stop offset="0.5" stop-color="#F75A48" />
									<stop offset="1" stop-color="#8D1D10" />
								</linearGradient>
								</defs>
							</svg>
							<h1 class="ticket-popup-number">${t}</h1>
							<input type="checkbox" name="checkbox-ticket-revancha" value="${t}">
						</div>`;
		});
		let div = document.createElement('div');
		div.className = "tickets-container-popup";
		div.id = "tickets-container-popup";
		div.innerHTML = boletas;
		document.getElementById('card-info-boletas').innerHTML = "";
		document.getElementById('card-info-boletas').append(div);
		let ticketsRevancha = [];
		let numeroRevanchas;
		document.getElementById("tickets-container-popup").addEventListener("click", function () {
			let svg = Array.from(document.getElementsByClassName("ticket-svg-revancha"));
			let tickets = Array.from(document.getElementsByName("checkbox-ticket-revancha"));
			ticketsRevancha = [];
			numeroRevanchas = 0;
			tickets.forEach(t => {
				if (t.checked == true) {
					ticketsRevancha.push('R' + t.value);
					numeroRevanchas++;
					svg[tickets.indexOf(t)].setAttribute("fill", "url(#red)");
				} else {
					ticketsRevancha.push(t.value);
					svg[tickets.indexOf(t)].setAttribute("fill", "url(#gold)");
				}
			});
			
			let total = parseFloat(numeroRevanchas * revancha_price) + parseFloat(spanAmountTotal);
			spanAmountRevancha.textContent = "$ "+ total;
			inputExtra1.value = ticketsRevancha.join("-");
			inputAmount.value = total;
		});

	}
	
	let formBoleta = document.querySelector('#form-boleta');
	formBoleta.addEventListener('submit', (e) => {
		e.preventDefault();
		if (inputExtra1.value == "") {
			Swal.fire({
				title: 'Oops',
				text: "Debe seleccionar al menos una boleta!",
				icon: 'warning',
				confirmButtonColor: '#3085d6',
				confirmButtonText: 'Ok'
			});
			return false;
		}else{
			boletasRevancha();
			generarCodigoReferencia();
			generarDescripcion();
			$("#card-popup-revancha").fadeIn("slow");
		}
	})

	function generarCodigoReferencia() {
		numeroBoleta = document.querySelector('input[name="extra1"]');
		let referenceCode = buyerName.value + "-" + numeroBoleta.value + "-" + Date.now();
		document.querySelector('input[name="referenceCode"]').value = referenceCode;
	}

	function generarDescripcion() {
		let nombre = buyerName.value;
		let boletas = [];
		for (let ticket of tickets_values) {
			boletas.push(" #" + ticket);
		}
		let description = "";
		if (boletas.length > 1) {
			last_boletas = boletas.pop();
			description = `Compra de los cupos${boletas} y${last_boletas} válidos. La compra es realizada a nombre de ${nombre}`;
		} else {
			description = `Compra del cupo${boletas} válido. La compra es realizada a nombre de ${nombre}`;
		}
		document.querySelector('input[name="description"]').value = description;
	}

})