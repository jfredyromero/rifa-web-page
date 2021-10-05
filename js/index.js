document.addEventListener("DOMContentLoaded", ()=>{

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
	buyerName.addEventListener('change', ()=>{
		let text = buyerName.value;
		document.querySelector('input[name="payerFullName"]').value = text;
	})

  	let mobilePhone = document.querySelector('input[name="mobilePhone"]');
	mobilePhone.addEventListener('change', ()=>{
		let text = mobilePhone.value;
		document.querySelector('input[name="payerMobilePhone"]').value = text;
	})

	let formBoleta = document.querySelector('#form-boleta');
	formBoleta.addEventListener('submit', ()=>{
  	  	generarCodigoReferencia();
		generarSignature();
	})
  
	function generarCodigoReferencia(){
		numeroBoleta = document.querySelector('input[name="extra1"]');
    	let referenceCode = buyerName.value + "-" + mobilePhone.value + "-" + numeroBoleta.value;
      	let hashReferenceCode = CryptoJS.MD5(referenceCode);
		document.querySelector('input[name="referenceCode"]').value = hashReferenceCode;
	}

	function generarSignature(){
		const apiKey = "4Vj8eK4rloUd272L48hsrarnUA";
		const merchanId = "508029";
		const amount = "50000";
		const currency = "COP";
		let referenceCode = document.querySelector('input[name="referenceCode"]').value;
		let signature = CryptoJS.MD5(apiKey + "~" + merchanId + "~" + referenceCode + "~" + amount + "~" + currency);
    	document.querySelector('input[name="signature"]').value = signature;
	}

})