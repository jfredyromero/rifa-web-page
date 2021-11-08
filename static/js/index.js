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
		if(tickets_values.length > 2){
			document.getElementById("card-popup-revancha").firstElementChild.classList.remove("modal-lg");
			document.getElementById("card-popup-revancha").firstElementChild.classList.add("modal-xl");
		}else{
			document.getElementById("card-popup-revancha").firstElementChild.classList.add("modal-lg");
			document.getElementById("card-popup-revancha").firstElementChild.classList.remove("modal-xl");
		}
		let boletas = "";
		tickets_values.forEach(t => {
			boletas += `<div class="ticket-modal" data-checked="false">
							<img src="static/img/ticket-gold.svg"></img>
							<h2 class="ticket-value">${t}</h2>
						</div>`;
		});
		let div = document.createElement('div');
		div.className = "tickets-container-popup";
		div.id = "tickets-container-popup";
		div.innerHTML = boletas;
		document.getElementById('card-info-boletas').innerHTML = "";
		document.getElementById('card-info-boletas').append(div);
		document.querySelectorAll(".ticket-modal").forEach(m => {
			m.addEventListener("click", (event)=>{
				if(m.dataset.checked === "false"){
					m.dataset.checked = "true";
				}else{
					m.dataset.checked = "false";
				}
			});
		});
		let ticketsRevancha = [];
		let numeroRevanchas;
		document.getElementById("tickets-container-popup").addEventListener("click", function () {
			let tickets = document.querySelectorAll(".ticket-modal");
			ticketsRevancha = [];
			numeroRevanchas = 0;
			tickets.forEach(t => {
				if (t.dataset.checked == "true") {
					ticketsRevancha.push('R' + t.querySelector('.ticket-value').innerHTML);
					numeroRevanchas++;
					t.querySelector('img').src = "static/img/ticket-red.svg";
				} else {
					ticketsRevancha.push(t.querySelector('.ticket-value').innerHTML);
					t.querySelector('img').src = "static/img/ticket-gold.svg";
				}
			});
			
			let total = parseFloat(numeroRevanchas * revancha_price) + parseFloat(spanAmountTotal);
			spanAmountRevancha.textContent = "$ "+ total;
			inputExtra1.value = ticketsRevancha.join("-");
			inputAmount.value = total;
		});

	}

	document.getElementById('btnContinuar').addEventListener("click", ()=>{
		document.getElementById('form-boleta').submit();
	});
	
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
			let myModalEl = document.querySelector('#card-popup-revancha');
    		let modal = bootstrap.Modal.getOrCreateInstance(myModalEl); // Returns a Bootstrap modal instance
    		modal.show();
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