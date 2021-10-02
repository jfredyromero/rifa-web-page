var inpCelular = document.getElementById("inpCelular");
var flag = 0;

inpCelular.addEventListener("keyup", function () {
  var tel = inpCelular.value;

  if (tel.length > 0 && tel.length < 3) {
    flag = 0;
  }

  if (tel.length > 3 && tel.length < 7) {
    flag = 1;
  }

  if (tel.length == 3 && flag == 0) {
    tel = tel + "-";
    inpCelular.value = tel;
    flag = 1;
  }

  if (tel.length == 7 && flag == 1) {
    tel = tel + "-";
    inpCelular.value = tel;
    flag = 2;
  }
});

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
