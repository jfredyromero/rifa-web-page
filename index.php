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

	<!-- Bootstrap -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

	<link rel="stylesheet" href="static/css/main.css" />
	<link rel="stylesheet" href="static/css/checkbox.css" />
	<title>Gana tu Carro</title>
	<!-- Favicon -->
	<link rel="shortcut icon" type="image/png" href="/static/img/logo.png" />
</head>

<body>

	<form id="form-boleta" method="post" action="procesos/validacion.php">
		<div class="page-content">
			<div class="first-section">
				<div class="counter-block d-flex flex-column align-items-center">
					<div class="logo">
						<img src="static/img/logo.png" alt="logo">
					</div>
					<h2 class="titulo fw-2 mb-3">¡Compra tus Cupos!</h2>
					<!-- <div class="mb-3 clock-counter d-flex flex-row align-items-center">
						<div class="time-interval-container d-flex flex-column justify-content-center align-items-center">
							<h1 id="dias">--</h1>
							<h2>Dias</h2>
						</div>
						<div class="line"></div>
						<div class="time-interval-container d-flex flex-column justify-content-center align-items-center">
							<h1 id="horas">--</h1>
							<h2>Horas</h2>
						</div>
						<div class="line"></div>
						<div class="time-interval-container d-flex flex-column justify-content-center align-items-center">
							<h1 id="minutos">--</h1>
							<h2>Min</h2>
						</div>
						<div class="line"></div>
						<div class="time-interval-container d-flex flex-column justify-content-center align-items-center">
							<h1 id="segundos">--</h1>
							<h2>Seg</h2>
						</div>
					</div> -->
				</div>
				<div class="tickets-block">
					<div class="mb-3 form-item">
						<label for="">Selecciona tus Cupos <span> *</span></label>
						<span id="avisoTicketComprado" class="text-danger mb-1"></span>
						<div class="form-search mb-3">
							<input class="form-input" id="inpSearch" type="number" placeholder="Busca tu cupo..." min="0" max="9999" onKeyPress="if(this.value.length==4) return false;">
							<input type="button" class="btn btn-primary ms-3" id="btnSearch" value="Buscar">
						</div>
						<div class="tickets-grid-container" id="tickets-grid-container">
							<!-- //TICKETS -->
						</div>
						<div class="loader-container" id="loader-container"></div>
					</div>
				</div>
				<div class="refresh-block">
					<div class="form-item mb-3">
						<div class="bg-gold-gradient">
							<input type="button" id="btnRefresh" class="btn btn-secondary w-100" value="Refrescar Cupos" />
						</div>
					</div>
					<div class="form-item mb-3 f-al-l">
						<h2 class="fw-2">Valor a pagar: <span id="price" class="fw-2">$ 0</span></h2>
					</div>
				</div>
			</div>
			<span class="line-section"></span>
			<div class="second-section">
				<div class="form-block">
					<div class="mb-3 form-item">
						<label for="">Nombre Completo<span> *</span></label>
						<input class="form-input" type="text" placeholder="Nombre" name="buyerFullName" required />
					</div>
					<div class="mb-3 form-item">
						<label for="">Número de Identificación<span> *</span></label>
						<input class="form-input" type="text" placeholder="1060400300" onkeypress="return onlyNumberKey(event)" name="payerDocument" required />
					</div>
					<div class="mb-3 form-item">
						<label for="">Celular<span> *</span></label>
						<input class="form-input" id="inpCelular" type="tel" placeholder="3101234567" maxlength="12" name="mobilePhone" required />
					</div>
					<div class="mb-5 form-item">
						<label for="">Correo Electrónico<span> *</span></label>
						<input class="form-input" type="email" placeholder="ejemplo@gmail.com" name="buyerEmail" required />
					</div>
				</div>
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
					<div class="form-item mb-2">
						<input name="Submit" id="btnSend" class="btn btn-primary" type="submit" value="Comprar" />
					</div>

					<div class="control-group mb-1">
						<label class="control control-checkbox">
							Acepto los <a target="_blank" href="static/conditions/TERMINOS Y CONDICIONES BMW.pdf">términos y condiciones</a>
							<input type="checkbox" required />
							<div class="control_indicator"></div>
						</label>
					</div>

				</div>
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

	<!-- Modales -->

	<?php
	$banderaPopUp = false;
	if (isset($_GET["id_transaccion"])) {
		$id_transaccion = $_GET["id_transaccion"];
		$comprador_nombre = $_GET["comprador_nombre"];
		$comprador_cedula = $_GET["comprador_cedula"];
		$numero_boleta = $_GET["numero_boleta"];
	?>
		<!-- Modal Codigo QR -->
		<div class="modal fade" id="card-popup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
				<div class="modal-content">
					<div class="modal-header d-flex justify-content-between align-items-center">
						<img src="static/img/logo.png" width="100px" alt="logo">
						<h2 class="modal-title" id="exampleModalLabel">Cupo Gana tu Carro</h2>
						<button type="button" class="btn-close m-0" data-bs-dismiss="modal" aria-label="Close">
							<i class="fas fa-times fa-2x"></i>
						</button>
					</div>
					<div class="modal-body">

						<div class="ticket-modal">
							<img src="static/img/ticket-gold.svg"></img>
							<h1 class="ticket-value"><?php echo $numero_boleta; ?></h1>
						</div>
						<div class="card-info-transaction">
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
					</div>
					<div class="modal-footer d-flex justify-content-center align-items-center">
						<button class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
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

		<!-- Modal Resumen -->
		<div class="modal fade" id="card-popup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">	
				<div class="modal-content">
					<div class="modal-header d-flex justify-content-between align-items-center">
						<img src="static/img/logo.png" width="100px" alt="logo">
						<h2 class="modal-title" id="exampleModalLabel">Resumen Transacción</h2>
						<button type="button" class="btn-close m-0" data-bs-dismiss="modal" aria-label="Close">
							<i class="fas fa-times fa-2x"></i>
						</button>
					</div>
					<div class="modal-body">
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
									<td>CUS </td>
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
							<tr>
								<label for="">En caso de no encontrar el correo de confirmación, revisa el spam <span> *</span></label>
							</tr>
						</table>
						</div>
					</div>
					<div class="modal-footer d-flex justify-content-center align-items-center">
						<button class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
					</div>
				</div>
			</div>
		</div>

	<?php
		}
	}
	?>
	<!-- Modal Revancha -->
	<div class="modal fade" id="card-popup-revancha" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
			<div class="modal-content">
				<div class="modal-header d-flex justify-content-between align-items-center">
					<img src="static/img/logo.png" width="100px" alt="logo">
					<h2 class="modal-title" id="exampleModalLabel">¿Te vas a ir sin tu revancha?</h2>
					<button type="button" class="btn-close m-0" data-bs-dismiss="modal" aria-label="Close">
						<i class="fas fa-times fa-2x"></i>
					</button>
				</div>
				<div class="modal-body">
					<div class="card-info-revancha">
						<div class="card-info-premio">
							<a href="https://instagram.com/ganatucarro?utm_medium=copy_link" target="_blank">
								<img src="static/img/gift.svg" alt="triangle with all three sides equal" width="40%" height="auto" />
							</a>
							<br>
							<h4>Selecciona tu revancha y participa por un BMW.</h4>
							<h4>Son $25.000 pesos más por cada una. Animate!</h4>
						</div>
						<div id="card-info-boletas">
						</div>
					</div>
				</div>
				<div class="modal-footer d-flex align-items-center justify-content-between">
					<h2 class="fw-2">Valor a pagar: <span id="priceRevancha" class="fw-2"></span></h2>
					<button class="btn btn-primary" id="btnContinuar">Continuar</button>
				</div>
			</div>
		</div>
	</div>
	<span id="precio" style="display: none;"><?php echo $price; ?></span>
	<span id="precioRevancha" style="display: none;"><?php echo $priceRevancha; ?></span>
	<span id="fecha_sorteo" style="display: none;"><?php echo $fecha_sorteo; ?></span>
	<span id="fecha_sorteo_countdown" style="display: none;"><?php echo $fecha_sorteo_countdown; ?></span>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<!-- <script src="static/js/countdown.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/core.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/md5.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- SweetAlert2 -->
<!-- <script src="sweetalert2.all.min.js"></script> -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Fontawesome -->
<script src="https://kit.fontawesome.com/981ff97f79.js" crossorigin="anonymous"></script>
<!-- Scrips internos -->
<script src="static/js/index.js"></script>
<script src="static/js/boletas.js"></script>
<script src="static/js/ticketDisponible.js"></script>
<?php
if ($banderaPopUp) {
?>
	<script src="static/js/abrirModal.js"></script>
<?php
}
?>

</html>