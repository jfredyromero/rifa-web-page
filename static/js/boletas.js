var datos = "";

function refrescar() {
	console.clear();
	var xhttp;

	var tickets = Array.from(document.getElementsByName("checkbox-ticket"));
	var tickets_values = [];

	tickets.forEach((t) => {
		if (t.checked == true) {
			tickets_values.push(t.value);
		}
	});

	datos = tickets_values.join("-");

	document.getElementById("tickets-grid-container").innerHTML = "";

	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("tickets-grid-container").innerHTML = this.responseText;
		}
	};

	var params = new FormData();
	params.append("tickets_ch", datos);

	xhttp.open("POST", "/rifa-web-page/procesos/boletas.php", true);
	xhttp.send(params);
}

window.addEventListener("load", refrescar);
document.getElementById("btnRefresh").addEventListener("click", refrescar);