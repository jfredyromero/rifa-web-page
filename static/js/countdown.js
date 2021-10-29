const countdown = () => {
    const fechaSorteo = document.getElementById('fechaSorteo').innerHTML;
    const tiempoObjetivo = new Date(fechaSorteo).getTime();
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