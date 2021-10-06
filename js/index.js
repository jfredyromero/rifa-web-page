function onlyNumberKey(evt) {
	// Only ASCII character in that range allowed
	var ASCIICode = evt.which ? evt.which : evt.keyCode;
	if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57)) return false;
	return true;
}


document.getElementById("tickets-grid-container").addEventListener("click",function(){

	var iframes = Array.from(document.getElementsByTagName("iframe"));	
	var tickets = Array.from(document.getElementsByName("checkbox-ticket"));
	var inputExtra1 = document.querySelector('input[name="extra1"]');
	var inputAmount = document.querySelector('input[name="amount"]');

	var tickets_values=[];
	var ticket_price = 50000;

	console.clear();

	tickets.forEach(t => {
		if(t.checked == true){
			tickets_values.push(t.value);
			iframes[tickets.indexOf(t)].src = "img/ticket-gold.svg";
		}else{
			iframes[tickets.indexOf(t)].src = "img/ticket-silver.svg";
		}
	});

	inputExtra1.value = tickets_values.join("-");
	inputAmount.value = tickets_values.length * ticket_price;

	console.log(inputExtra1.value);
	console.log(inputAmount.value);


	// inputExtra1 = document.querySelector('input[name="extra1"]');
	// inputAmount = document.querySelector('input[name="amount"]');
	// inputExtra1.value = allValueTickets;
	// inputAmount.value = 50000 * checked_tickets.length;

	// console.log(inputExtra1.value);
	// console.log(inputAmount.value);
	// console.table(svg);

	// var tickets_values = [];
	// tickets_values = tickets.filter(n => n.value == true);
	
	// var tickets_values = tickets.map(function() {
	// 	console.log(this.checked)
	// 	if (this.checked == true){
	// 		console.log(this.checked)
	// 		return this.value;
	// 	}		
	// });

	// var tickets_values = tickets.filter(n => {
	// 	if (n.checked == true){
	// 		return n.value;
	// 	}	
	// });

	// console.table(tickets_values);

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
		let text = payerDocument.value;
		document.querySelector('input[name="extra2"]').value = text;
	})

	let codreferencia = document.querySelector('input[name="codigoReferido"]');
	codreferencia.addEventListener('change', () => {
		let text = codreferencia.value;
		document.querySelector('input[name="extra3"]').value = text;
	})

	let formBoleta = document.querySelector('#form-boleta');
	formBoleta.addEventListener('submit', () => {
		generarCodigoReferencia();
		generarSignature();
	})

	function generarCodigoReferencia() {
		numeroBoleta = document.querySelector('input[name="extra1"]');
		let referenceCode = buyerName.value + "-" + mobilePhone.value + "-" + numeroBoleta.value + "-" + Date.now();
		let hashReferenceCode = CryptoJS.MD5(referenceCode);
		document.querySelector('input[name="referenceCode"]').value = hashReferenceCode;
	}

	function generarSignature() {
		const apiKey = "4Vj8eK4rloUd272L48hsrarnUA";
		const merchanId = "508029";
		const amount = "50000";
		const currency = "COP";
		let referenceCode = document.querySelector('input[name="referenceCode"]').value;
		let signature = CryptoJS.MD5(apiKey + "~" + merchanId + "~" + referenceCode + "~" + amount + "~" + currency);
		document.querySelector('input[name="signature"]').value = signature;
	}

})