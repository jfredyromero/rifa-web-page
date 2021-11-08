let countdown = () => {
    let fechaSorteo = document.getElementById('fecha_sorteo_countdown').innerHTML;
    let tiempoObjetivo = new Date(fechaSorteo).getTime();
    let tiempoActual = new Date().getTime();
    let tiempoRestante = tiempoObjetivo - tiempoActual;

    let segundos = 1000;
    let minutos = segundos * 60;
    let horas = minutos * 60;
    let dias = horas * 24;

    let textoDias = Math.floor(tiempoRestante / dias);
    let textoHoras = Math.floor((tiempoRestante % dias) / horas);
    let textoMinutos = Math.floor((tiempoRestante % horas) / minutos);
    let textoSegundos = Math.floor((tiempoRestante % minutos) / segundos);

    document.getElementById("dias").innerHTML = textoDias;
    document.getElementById("horas").innerHTML = textoHoras;
    document.getElementById("minutos").innerHTML = textoMinutos;
    document.getElementById("segundos").innerHTML = textoSegundos;
}

document.addEventListener("DOMContentLoaded",function () {
    // countdown();  
});  

// setInterval(countdown, 1000);