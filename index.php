<?php
// Variables del ambiente
include_once("static/variables/variables.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="static/css/main.css" />
	<link rel="stylesheet" href="static/css/checkbox.css" />
	<title>Gana tu Carro</title>
</head>

<body>

	<form id="form-boleta" method="post" action="procesos/validacion.php">
		<!-- <form id="form-boleta" method="post" action="https://sandbox.checkout.payulatam.com/ppp-web-gateway-payu/"> -->

		<div class="page-content">

			<div class="first-section">

				<div class="counter-block d-flex-col">
					<div class="logo">
						<img src="static/img/logo.png" alt="logo">
					</div>



					<h2 class="titulo mb-1">¡Compra tus Membresias!</h2>

					<div class="clock-counter mb-1 d-flex-row">
						<div class="time-interval-container d-flex-col">
							<h1 id="dias">00</h1>
							<h2>Dias</h2>
						</div>
						<div class="line"></div>
						<div class="time-interval-container d-flex-col">
							<h1 id="horas">00</h1>
							<h2>Horas</h2>
						</div>
						<div class="line"></div>
						<div class="time-interval-container d-flex-col">
							<h1 id="minutos">00</h1>
							<h2>Min</h2>
						</div>
						<div class="line"></div>
						<div class="time-interval-container d-flex-col">
							<h1 id="segundos">00</h1>
							<h2>Seg</h2>
						</div>
					</div>
				</div>

				<div class="tickets-block">
					<div class="mb-1 form-item">
						<label for="">Selecciona tu Membresía <span> *</span></label>
						<div class="form-search mb-1">
							<input class="form-input" id="inpSearch" type="number" placeholder="Busca tu boleta..." min="0" max="9999" onKeyPress="if(this.value.length==4) return false;">
							<input type="button" class="btn btn-primary ms-1" id="btnSearch" value="Buscar">
							<!-- <button class="btn btn-primary ms-1" id="btnSearch">Buscar</button> -->
						</div>

						<div class="tickets-grid-container" id="tickets-grid-container">
							<!-- //TICKETS -->
						</div>

						<div class="loader-container" id="loader-container"></div>


					</div>
				</div>

				<div class="refresh-block">
					<div class="form-item mb-1">
						<div class="bg-gold-gradient">
							<input type="button" id="btnRefresh" class="btn btn-secondary w-100" value="Refrescar Membresias" />
						</div>
					</div>

					<div class="form-item mb-1 f-al-l">
						<h2>Valor a pagar: <span id="price" class="fw-1">$ 0</span></h2>
					</div>
				</div>
			</div>

			<span class="line-section"></span>

			<div class="second-section">
				<div class="form-block">
					<div class="mb-1 form-item">
						<label for="">Nombre Completo<span> *</span></label>
						<input class="form-input" type="text" placeholder="Nombre" name="buyerFullName" required />
					</div>

					<div class="mb-1 form-item">
						<label for="">Número de Identificación<span> *</span></label>
						<input class="form-input" type="text" placeholder="1060400300" onkeypress="return onlyNumberKey(event)" name="payerDocument" required />
					</div>

					<div class="mb-1 form-item">
						<label for="">Celular<span> *</span></label>
						<input class="form-input" id="inpCelular" type="tel" placeholder="3101234567" maxlength="12" name="mobilePhone" required />
					</div>

					<div class="mb-1 form-item">
						<label for="">Correo Electrónico<span> *</span></label>
						<input class="form-input" type="email" placeholder="ejemplo@gmail.com" name="buyerEmail" required />
					</div>
					<br>
				</div>

				<!-- ===================================== -->
				<!-- Datos necesarios para el pago en PayU -->
				<!-- ===================================== -->

				<?php
				if (isset($_GET["extra3"])) {
				?>
					<input name="extra3" type="hidden" value="<?php echo $_GET["extra3"]; ?>" />
				<?php
				} else {
				?>
					<input name="extra3" type="hidden" />
				<?php
				}
				?>

				<input name="extra1" type="hidden" />

				<input name="description" type="hidden" value="" />

				<input name="referenceCode" type="hidden" />

				<input name="extra2" type="hidden" />

				<input name="payerFullName" type="hidden" />

				<input name="payerMobilePhone" type="hidden" />

				<input name="amount" type="hidden" />

				<div class="buy-block">
					<div class="form-item mb-05">
						<input name="Submit" id="btnSend" class="btn btn-primary" type="submit" value="Comprar" />
					</div>

					<div class="control-group mb-05">
						<label class="control control-checkbox">
							Acepto los <a target="_blank" href="<?php $dominio?>/rifa-web-page/static/conditions/TERMINOS Y CONDICIONES BMW.pdf">términos y condiciones</a>
							<input type="checkbox" required />
							<div class="control_indicator"></div>
						</label>
					</div>

				</div>

				<!-- <div class="gift-container mt-1 mb-1">
					<div class="bg-gold-gradient-circle">
						<div class="bg-dark-circle">
							<a href="https://instagram.com/ganatucarro?utm_medium=copy_link" target="_blank">
								<svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="none">
									<path d="M32 448c0 17.7 14.3 32 32 32h160V320H32v128zm256 32h160c17.7 0 32-14.3 32-32V320H288v160zm192-320h-42.1c6.2-12.1 10.1-25.5 10.1-40 0-48.5-39.5-88-88-88-41.6 0-68.5 21.3-103 68.3-34.5-47-61.4-68.3-103-68.3-48.5 0-88 39.5-88 88 0 14.5 3.8 27.9 10.1 40H32c-17.7 0-32 14.3-32 32v80c0 8.8 7.2 16 16 16h480c8.8 0 16-7.2 16-16v-80c0-17.7-14.3-32-32-32zm-326.1 0c-22.1 0-40-17.9-40-40s17.9-40 40-40c19.9 0 34.6 3.3 86.1 80h-86.1zm206.1 0h-86.1c51.4-76.5 65.7-80 86.1-80 22.1 0 40 17.9 40 40s-17.9 40-40 40z" fill="url(#gift-gold)"></path>
									<defs>
										<linearGradient id="gift-gold" x1="256" y1="0" x2="256" y2="512" gradientUnits="userSpaceOnUse">
											<stop stop-color="#95702c" />
											<stop offset="0.5" stop-color="#f8dd57" />
											<stop offset="1" stop-color="#95702c" />
										</linearGradient>
									</defs>
								</svg>
							</a>
						</div>
					</div>
				</div> -->
				<div class="gift-container">
					<div class="semicirculo-fondo">
						<div class="semicirculo">
							<a href="https://instagram.com/ganatucarro?utm_medium=copy_link" target="_blank">
								<svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="none">
									<path d="M32 448c0 17.7 14.3 32 32 32h160V320H32v128zm256 32h160c17.7 0 32-14.3 32-32V320H288v160zm192-320h-42.1c6.2-12.1 10.1-25.5 10.1-40 0-48.5-39.5-88-88-88-41.6 0-68.5 21.3-103 68.3-34.5-47-61.4-68.3-103-68.3-48.5 0-88 39.5-88 88 0 14.5 3.8 27.9 10.1 40H32c-17.7 0-32 14.3-32 32v80c0 8.8 7.2 16 16 16h480c8.8 0 16-7.2 16-16v-80c0-17.7-14.3-32-32-32zm-326.1 0c-22.1 0-40-17.9-40-40s17.9-40 40-40c19.9 0 34.6 3.3 86.1 80h-86.1zm206.1 0h-86.1c51.4-76.5 65.7-80 86.1-80 22.1 0 40 17.9 40 40s-17.9 40-40 40z" fill="url(#gift-gold)"></path>
									<defs>
										<linearGradient id="gift-gold" x1="256" y1="0" x2="256" y2="512" gradientUnits="userSpaceOnUse">
											<stop stop-color="#95702c" />
											<stop offset="0.5" stop-color="#f8dd57" />
											<stop offset="1" stop-color="#95702c" />
										</linearGradient>
									</defs>
								</svg>
							</a>
						</div>
					</div>
				</div>
				

			</div>
		</div>


	</form>

	<!-- POPUPS -->

	<?php
	$banderaPopUp = false;
	if (isset($_GET["id_transaccion"])) {
		$id_transaccion = $_GET["id_transaccion"];
		$comprador_nombre = $_GET["comprador_nombre"];
		$comprador_cedula = $_GET["comprador_cedula"];
		$numero_boleta = $_GET["numero_boleta"];
	?>
		<div class="card-popup" id="card-popup">
			<div class="container-flex">
				<div class="bg-close"></div>
				<div class="card-content sc-100">
					<div class="card-header">
						<div class="logo">
							<img src="static/img/logo.png" alt="logo">
						</div>
						<h2 class="me-1">Membresía Gana tu Carro</h2>
						<i class="fas fa-2x fa-times btn-close"></i>
					</div>
					<div class="card-info-transaction virtual-ticket">
						<div class="ticket mb-1">
							<svg min-width="175" min-height="117" width="100%" height="100%" viewBox="0 0 175 117" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path class="ticket-svg" d="M38.8889 29.25H136.111V87.75H38.8889V29.25ZM160.417 58.5C160.417 66.5773 166.946 73.125 175 73.125V102.375C175 110.452 168.471 117 160.417 117H14.5833C6.52908 117 0 110.452 0 102.375V73.125C8.05425 73.125 14.5833 66.5773 14.5833 58.5C14.5833 50.4227 8.05425 43.875 0 43.875V14.625C0 6.54773 6.52908 0 14.5833 0H160.417C168.471 0 175 6.54773 175 14.625V43.875C166.946 43.875 160.417 50.4227 160.417 58.5ZM145.833 26.8125C145.833 22.7739 142.569 19.5 138.542 19.5H36.4583C32.4312 19.5 29.1667 22.7739 29.1667 26.8125V90.1875C29.1667 94.2261 32.4312 97.5 36.4583 97.5H138.542C142.569 97.5 145.833 94.2261 145.833 90.1875V26.8125Z" fill="url(#gold)" />
								<defs>
									<linearGradient id="silver" x1="87.5" y1="0" x2="87.5" y2="117" gradientUnits="userSpaceOnUse">
										<stop stop-color="#7C7C7C" />
										<stop offset="0.5" stop-color="#D9D9D9" />
										<stop offset="1" stop-color="#6A6A6A" />
									</linearGradient>
									<linearGradient id="gold" x1="87.5" y1="0" x2="87.5" y2="117" gradientUnits="userSpaceOnUse">
										<stop stop-color="#95702c" />
										<stop offset="0.5" stop-color="#f8dd57" />
										<stop offset="1" stop-color="#95702c" />
									</linearGradient>
								</defs>
							</svg>
							<h1><?php echo $numero_boleta; ?></h1>
						</div>

						<table>
							<tr>
								<th>Nombre</th>
								<td><?php echo $comprador_nombre; ?></td>
							</tr>
							<tr>
								<th>Cedula</th>
								<td><?php echo $comprador_cedula; ?></td>
							</tr>
							<tr>
								<th>ID Transacción</th>
								<td><?php echo $id_transaccion; ?></td>
							</tr>
						</table>
					</div>



					<div class="card-footer mt-1">
						<button class="btn btn-primary btnAceptar">Aceptar</button>
					</div>
				</div>
			</div>
		</div>
		<?php
		$banderaPopUp = true;
	} else if (isset($_GET['signature'])) {
		$ApiKey = "4Vj8eK4rloUd272L48hsrarnUA";
		$merchant_id = $_GET['merchantId'];
		$referenceCode = $_GET['referenceCode'];
		$TX_VALUE = $_GET['TX_VALUE'];
		$New_value = number_format($TX_VALUE, 1, '.', '');
		$currency = $_GET['currency'];
		$transactionState = $_GET['transactionState'];
		$firma_cadena = "$ApiKey~$merchant_id~$referenceCode~$New_value~$currency~$transactionState";
		$firmacreada = md5($firma_cadena);
		$firma = $_GET['signature'];
		$reference_pol = $_GET['reference_pol'];
		$cus = $_GET['cus'];
		$description = $_GET['description'];
		$pseBank = $_GET['pseBank'];
		$lapPaymentMethod = $_GET['lapPaymentMethod'];
		$transactionId = $_GET['transactionId'];

		// Se comparan las firmas por seguridad
		if (strtoupper($firma) == strtoupper($firmacreada)) {

			// Solo entra si la transacción es exitosa
			if ($_GET['transactionState'] == 4) {
				$estadoTx = "Transacción aprobada";
			} else if ($_GET['transactionState'] == 6) {
				$estadoTx = "Transacción rechazada";
			} else if ($_GET['transactionState'] == 104) {
				$estadoTx = "Error";
			} else if ($_GET['transactionState'] == 7) {
				$estadoTx = "Transacción pendiente";
			} else {
				$estadoTx = $_GET['mensaje'];
			}
			$banderaPopUp = true;
		?>
			<div class="card-popup" id="card-popup">

				<div class="container-flex">

					<div class="bg-close"></div>
					<div class="card-content sc-80">
						<div class="card-header">
							<div class="logo">
								<img src="static/img/logo.png" alt="logo">
							</div>
							<h2>Resumen de la Transacción</h2>
							<i class="fas fa-2x fa-times btn-close"></i>
						</div>
						<div class="card-info-transaction">
							<table>
								<?php
								$comprador_datos = explode("-", $_GET['extra2']);
								$comprador_nombre = $comprador_datos[1];
								$comprador_cedula = $comprador_datos[0];
								?>
								<tr>
									<th>Nombre</th>
									<td><?php echo $comprador_nombre; ?></td>
								</tr>
								<tr>
									<th>Cédula</th>
									<td><?php echo $comprador_cedula; ?></td>
								</tr>
								<tr>
									<th>Estado de la transaccion</th>
									<td><?php echo $estadoTx; ?></td>
								</tr>
								<tr>
									<th>ID de la transaccion</th>
									<td><?php echo $transactionId; ?></td>
								</tr>
								<tr>
									<th>Referencia de la venta</th>
									<td><?php echo $reference_pol; ?></td>
								</tr>
								<tr>
									<th>Referencia de la transaccion</th>
									<td><?php echo $referenceCode; ?></td>
								</tr>
								<?php
								if ($pseBank != null) {
								?>
									<tr>
										<td>cus </td>
										<td><?php echo $cus; ?> </td>
									</tr>
									<tr>
										<td>Banco </td>
										<td><?php echo $pseBank; ?> </td>
									</tr>
								<?php
								}
								?>
								<tr>
									<th>Valor total</th>
									<td>$<?php echo number_format($TX_VALUE); ?></td>
								</tr>
								<tr>
									<th>Moneda</th>
									<td><?php echo $currency; ?></td>
								</tr>
								<tr>
									<th>Descripción</th>
									<td><?php echo ($description); ?></td>
								</tr>
								<tr>
									<th>Entidad</th>
									<td><?php echo ($lapPaymentMethod); ?></td>
								</tr>
							</table>
						</div>
						<div class="card-footer">
							<button class="btn btn-primary btnAceptar">Aceptar</button>
						</div>

					</div>
				</div>

			</div>
	<?php
		}
	}
	?>
	<div class="card-popup" id="card-popup-revancha">
		<div class="container-flex">
			<div class="bg-close"></div>
			<div class="card-content" style="width:auto">
				<div class="card-header">
					<div class="logo">
						<img src="static/img/logo.png" alt="logo">
					</div>
					<h1>¿Te vas a ir sin tu revancha?</h1>
					<i class="fas fa-2x fa-times btn-close"></i>
				</div>
				<div class="card-info-revancha">
					<div class="card-info-premio">
						<a href="https://instagram.com/ganatucarro?utm_medium=copy_link" target="_blank">
							<svg width="40%" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="none">
								<path d="M32 448c0 17.7 14.3 32 32 32h160V320H32v128zm256 32h160c17.7 0 32-14.3 32-32V320H288v160zm192-320h-42.1c6.2-12.1 10.1-25.5 10.1-40 0-48.5-39.5-88-88-88-41.6 0-68.5 21.3-103 68.3-34.5-47-61.4-68.3-103-68.3-48.5 0-88 39.5-88 88 0 14.5 3.8 27.9 10.1 40H32c-17.7 0-32 14.3-32 32v80c0 8.8 7.2 16 16 16h480c8.8 0 16-7.2 16-16v-80c0-17.7-14.3-32-32-32zm-326.1 0c-22.1 0-40-17.9-40-40s17.9-40 40-40c19.9 0 34.6 3.3 86.1 80h-86.1zm206.1 0h-86.1c51.4-76.5 65.7-80 86.1-80 22.1 0 40 17.9 40 40s-17.9 40-40 40z" fill="url(#red)"></path>
								<defs>
									<linearGradient id="red" x1="256" y1="0" x2="256" y2="512" gradientUnits="userSpaceOnUse">
										<stop stop-color="#8D1D10" />
										<stop offset="0.5" stop-color="#F75A48" />
										<stop offset="1" stop-color="#8D1D10" />
									</linearGradient>
								</defs>
							</svg>
						</a>
						<br>
						<h2>Selecciona tu revancha y participa por un BMW.</h2>
						<h2>Son $25.000 pesos más por cada una. Animate!</h2>
					</div>
					<div id="card-info-boletas">
					</div>
				</div>
				<div class="card-footer-revancha">
					<div>
						<h2>Valor a pagar: <span id="priceRevancha" class="fw-1">$ 0</span></h2>
					</div>
					<button class="btn btn-primary" id="btnAceptar">Continuar</button>
				</div>
			</div>
		</div>
	</div>
	<span id="precio" style="display: none;"><?php echo $price; ?></span>
	<span id="precioRevancha" style="display: none;"><?php echo $priceRevancha; ?></span>
	<span id="fecha_sorteo" style="display: none;"><?php echo $fecha_sorteo; ?></span>
	<span id="fecha_sorteo_countdown" style="display: none;"><?php echo $fecha_sorteo_countdown; ?></span>
</body>
<script src="static/js/countdown.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/core.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/md5.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- SweetAlert2 -->
<!-- <script src="sweetalert2.all.min.js"></script> -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Fontawesome -->
<script src="https://kit.fontawesome.com/981ff97f79.js" crossorigin="anonymous"></script>
<!-- Scrips internos -->
<script src="static/js/modal.js"></script>
<script src="static/js/index.js"></script>
<script src="static/js/boletas.js"></script>
<?php
if ($banderaPopUp) {
?>
	<script src="static/js/abrirModal.js"></script>
<?php
}
?>

</html>