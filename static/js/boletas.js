var datos = "";
function refrescar() {
	var xhttp;

	var tickets = Array.from(document.getElementsByName("checkbox-ticket"));
	var tickets_values = [];
	var inpSearch = document.getElementById("inpSearch");

	tickets.forEach((t) => {
		if (t.checked == true) {
			tickets_values.push(t.value);
		}
	});

	datos = tickets_values.join("-");

	document.getElementById("tickets-grid-container").innerHTML = '';
	document.getElementById("loader-container").innerHTML = '<div class="loader"></div>'

	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("tickets-grid-container").innerHTML = this.responseText;
			document.getElementById("loader-container").innerHTML = ''
		}
	};

	var params = new FormData();
	params.append("tickets_ch", datos);
	params.append("inpSearch", inpSearch.value);

	xhttp.open("POST", "procesos/boletas.php", true);
	xhttp.send(params);
}

window.addEventListener("load", refrescar);
document.getElementById("btnRefresh").addEventListener("click", refrescar);
document.getElementById("btnSearch").addEventListener("click",refrescar);
