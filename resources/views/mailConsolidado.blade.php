<html>

<center><h1>PLAN ANUAL DE ADQUISICIONES  - IDRD </h1></center>

<h2>{{ $mensaje }}</h2>
<h2>Usuario Operario: {{$personaOperativo["Primer_Apellido"]." ".$personaOperativo["Segundo_Apellido"]." ".$personaOperativo["Primer_Nombre"]." ".$personaOperativo["Segundo_Nombre"]}}</h2>
<h3>Área: <strong>{{ $area["nombre"] }}</strong> </h3>
<br><br>

<h2>Usuario Consolidador: {{$personaConsolidador["Primer_Apellido"]." ".$personaConsolidador["Segundo_Apellido"]." ".$personaConsolidador["Primer_Nombre"]." ".$personaConsolidador["Segundo_Nombre"]}}</h2>
<h3>Sub Dirección: <strong>{{ $area->subdirecion["nombre"] }}</strong> </h3>
<br><br>

<p>Notificación del módulo del plan anual de adquisiciones, por favor no conteste este correo no tendrá respuesta, solamente es un correo informativo.</a> </p>
</html>
