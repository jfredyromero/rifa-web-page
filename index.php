<?php
include_once("static/connection/connection.php");
$mysqli = new mysqli($host, $user, $pw, $db);
if ($mysqli->connect_error) {
	exit('Could not connect');
}
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

	<form id="form-boleta" method="post" action="https://sandbox.checkout.payulatam.com/ppp-web-gateway-payu">

		<div class="page-content">

			<div class="first-section">

				<div class="counter-block d-flex-col">
					<div class="mb-1 mt-1 logo"></div>
					<h2 class="titulo mb-1">¡Compra tus Boletas!</h2>

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
						<label for="">Selecciona tu Boleta <span> *</span></label>
						<div class="tickets-grid-container" id="tickets-grid-container">

							<!-- <div class="ticket">
								<svg min-width="175" min-height="117" width="100%" height="100%" viewBox="0 0 175 117"
									fill="none" xmlns="http://www.w3.org/2000/svg">
									<path class="ticket-svg"
										d="M38.8889 29.25H136.111V87.75H38.8889V29.25ZM160.417 58.5C160.417 66.5773 166.946 73.125 175 73.125V102.375C175 110.452 168.471 117 160.417 117H14.5833C6.52908 117 0 110.452 0 102.375V73.125C8.05425 73.125 14.5833 66.5773 14.5833 58.5C14.5833 50.4227 8.05425 43.875 0 43.875V14.625C0 6.54773 6.52908 0 14.5833 0H160.417C168.471 0 175 6.54773 175 14.625V43.875C166.946 43.875 160.417 50.4227 160.417 58.5ZM145.833 26.8125C145.833 22.7739 142.569 19.5 138.542 19.5H36.4583C32.4312 19.5 29.1667 22.7739 29.1667 26.8125V90.1875C29.1667 94.2261 32.4312 97.5 36.4583 97.5H138.542C142.569 97.5 145.833 94.2261 145.833 90.1875V26.8125Z"
										fill="url(#silver)" />
									<defs>
										<linearGradient id="silver" x1="87.5" y1="0" x2="87.5" y2="117"
											gradientUnits="userSpaceOnUse">
											<stop stop-color="#7C7C7C" />
											<stop offset="0.5" stop-color="#D9D9D9" />
											<stop offset="1" stop-color="#6A6A6A" />
										</linearGradient>
										<linearGradient id="gold" x1="87.5" y1="0" x2="87.5" y2="117"
											gradientUnits="userSpaceOnUse">
											<stop stop-color="#95702c" />
											<stop offset="0.5" stop-color="#f8dd57" />
											<stop offset="1" stop-color="#95702c" />
										</linearGradient>
									</defs>
								</svg>
								<h1>0001</h1>
								<input type="checkbox" name="checkbox-ticket" value="0001">
							</div> -->



						</div>
					</div>
				</div>

				<div class="refresh-block">
					<div class="form-item mb-1">
						<div class="bg-gold-gradient">
							<input type="button" id="btnRefresh" class="btn btn-secondary w-100" value="Refrescar Boletas" />
						</div>
					</div>

					<div class="form-item mb-1">
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

					<div class="mb-1 form-item">
						<label for="">Código de Referencia<span> </span></label>
						<input class="form-input" type="text" placeholder="" name="codigoReferido" />
					</div>
				</div>

				<!-- ===================================== -->
				<!-- Datos necesarios para el pago en PayU -->
				<!-- ===================================== -->

				<!-- Aqui va el numero de la boleta. Será un número de 4 digitos -->
				<input name="extra1" type="hidden" value="" />

				<input name="merchantId" type="hidden" value="508029" />

				<input name="accountId" type="hidden" value="512321" />

				<input name="description" type="hidden" value="Hola Mundo" />

				<input name="referenceCode" type="hidden" />

				<input name="extra2" type="hidden" />

				<input name="extra3" type="hidden" />

				<input name="payerFullName" type="hidden" />

				<input name="payerMobilePhone" type="hidden" />

				<!-- Aqui va el precio de la compra. Por ahora es fijo -->
				<input name="amount" type="hidden" value="0" />

				<!-- Aqui van los impuestos. Si se deja vacío sera el 19% -->
				<input name="tax" type="hidden" value="0" />

				<input name="taxReturnBase" type="hidden" value="0" />

				<input name="currency" type="hidden" value="COP" />

				<input name="signature" type="hidden" />

				<input name="test" type="hidden" value="1" />

				<input name="responseUrl" type="hidden" value="http://localhost/rifa-web-page/" />

				<input name="confirmationUrl" type="hidden" value="https://ganatucarro.com/procesos/confirmacion.php" />

				<div class="buy-block">
					<div class="form-item mb-05">
						<input name="Submit" id="btnSend" class="btn btn-primary" type="submit" value="Comprar" />
					</div>

					<div class="control-group mb-05">
						<label class="control control-checkbox">
							Acepto los <a href="#">terminos y condiciones</a>
							<input type="checkbox" required />
							<div class="control_indicator"></div>
						</label>
					</div>

				</div>
			</div>
		</div>
	</form>

	<!-- POPUPS -->
	<!-- Descomentar para probar modal estatico -->
	<!-- <button class="btnOpen" style="padding: 20px;" id="btnOpen">Abrir</button> -->
	<?php
	$banderaPopUp = false;
	if (isset($_GET["extra1"])) {
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

					<div class="bg-close" id="bg-close"></div>
					<div class="card-content">
						<div class="card-header">
							<div class="logo"></div>
							<h2>Resumen de la Transacción</h2>
							<i class="fas fa-2x fa-times" id="btnClose"></i>
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
							<button class="btn btn-primary" id="btnAceptar">Aceptar</button>
						</div>
					</div>
				</div>
				
			</div>
	<?php
		}
	}
	?>
</body>
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
<!-- http://localhost/rifa-web-page/?merchantId=508029&merchant_name=Test+PayU+Test+comercio&merchant_address=Av+123+Calle+12&telephone=7512354&merchant_url=http%3A%2F%2Fpruebaslapv.xtrweb.com&transactionState=4&lapTransactionState=APPROVED&message=APPROVED&referenceCode=c282fec375dee46186dfe728528cf9bf&reference_pol=1401633362&transactionId=495fa735-3e94-4b5b-9613-a5ec4a85e977&description=Compra+de+las+boletas+%230046%2C+%230580%2C+%237100+y+%239445+v%C3%A1lidas+para+sorteo+de+espectacular+veh%C3%ADculo.+La+compra+es+realizada+a+nombre+de+APPROVED&trazabilityCode=CRED+-+777021655&cus=CRED+-+777021655&orderLanguage=es&extra1=0046-0580-7100-9445&extra2=1002970732-APPROVED&extra3=&polTransactionState=4&signature=8eb8054903387db7458cb4d7c9bd938f&polResponseCode=1&lapResponseCode=APPROVED&risk=&polPaymentMethod=10&lapPaymentMethod=VISA&polPaymentMethodType=2&lapPaymentMethodType=CREDIT_CARD&installmentsNumber=1&TX_VALUE=200000.00&TX_TAX=.00&currency=COP&lng=es&pseCycle=&buyerEmail=jhonrom%40unicauca.edu.co&pseBank=&pseReference1=&pseReference2=&pseReference3=&authorizationCode=847072&TX_ADMINISTRATIVE_FEE=.00&TX_TAX_ADMINISTRATIVE_FEE=.00&TX_TAX_ADMINISTRATIVE_FEE_RETURN_BASE=.00&processingDate=2021-10-10 -->

</html>