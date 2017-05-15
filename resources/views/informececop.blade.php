<?php
header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"); 
header("Content-Disposition: attachment; filename= Prueba.xls"); 
header("Content-Transfer-Encoding: binary"); 
header("Pragma: no-cache"); 
header("Expires: 0");

?>
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>


</head>

<body link=blue vlink="#954F72" class=xl79>

<table border=0 cellpadding=0 cellspacing=0 width=2033 style='border-collapse:
 collapse;table-layout:fixed;width:1528pt'>


 <tr height=80 style='height:60.0pt'>
  <td class=xl92 width=180 style='width:135pt'>Códigos UNSPSC</td>
  <td class=xl93 width=465 style='border-left:none;width:349pt'>Descripción</td>
  <td class=xl93 width=106 style='border-left:none;width:80pt'>Fecha estimada
  de inicio de proceso de selección</td>
  <td class=xl93 width=106 style='border-left:none;width:80pt'>Duración
  estimada del contrato</td>
  <td class=xl93 width=122 style='border-left:none;width:92pt'>Modalidad de
  selección<span style='mso-spacerun:yes'> </span></td>
  <td class=xl93 width=152 style='border-left:none;width:114pt'>Fuente de los
  recursos</td>
  <td class=xl93 width=149 style='border-left:none;width:112pt'>Valor total
  estimado</td>
  <td class=xl93 width=115 style='border-left:none;width:86pt'>Valor estimado
  en la vigencia actual</td>
  <td class=xl93 width=113 style='border-left:none;width:85pt'>¿Se requieren
  vigencias futuras?</td>
  <td class=xl93 width=117 style='border-left:none;width:88pt'>Estado de
  solicitud de vigencias futuras</td>
  <td class=xl94 width=330 style='border-left:none;width:248pt'>Datos de
  contacto del responsable</td>
  <td height=80 style='height:60.0pt'></td>
 </tr>
 


 @foreach($paas as $paa)  

<tr height=20 style='height:15.0pt'>
  <td width=180 style='width:135pt' class=normal>
    <?php echo  str_replace ( "," , ";" , $paa['CodigosU'] ) ?>
  </td>
  <td width=465 style='width:349pt' class=normal>{{$paa['ObjetoContractual']}}</td>
  <td width=106 style='width:80pt' class=normal>{{$paa['FechaInicioProceso']}}</td>
  <td width=106 style='width:80pt' class=normal>{{$paa['DuracionContrato']}}</td>
  <td class=xl79 width=122 style='width:92pt' class=normal>{{$paa->modalidad['Codigo']}}</td>
  <td class=xl79 width=152 style='width:114pt' class=normal>5
    <!--<?php $os = array('0'); ?>
    @foreach($paa->componentes as $componente)

        @if (in_array($componente->fuente['Id'], $os, false))
        {{$componente->fuente['nombre']}}
        @endIf

        <?php 
          //$IdFue=$componente->fuente['Id'];
          //array_push($os,$IdFue);
        ?>

    @endforeach-->
  </td>
  <td class=xl79 width=149 style='width:112pt' class=normal>{{$paa['ValorEstimado']}}</td>
  <td width=115 style='width:86pt' class=normal>{{$paa['ValorEstimadoVigencia']}}</td>
  <td width=113 style='width:85pt' class=normal><?php if($paa['VigenciaFutura']=="No"){ echo "0";}else{echo "1";}?></td>
  <td width=117 style='width:88pt' class=normal>{{$paa['EstadoVigenciaFutura']}}</td>
  <td  width=330 style='width:248pt' class=normal></td>
  <td height=20 style='height:15.0pt'></td>
 </tr>
      
@endforeach

 

</table>

</body>

</html>
