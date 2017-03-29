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

<style>
tr
  {mso-height-source:auto;}
col
  {mso-width-source:auto;}
br
  {mso-data-placement:same-cell;}
.style53
  {background:#333399;
  mso-pattern:#003366 none;
  color:white;
  font-size:11.0pt;
  font-weight:400;
  font-style:normal;
  text-decoration:none;
  font-family:Calibri, sans-serif;
  mso-font-charset:0;
  mso-style-name:Excel_BuiltIn_Énfasis1;}
.style54
  {color:blue;
  font-size:11.0pt;
  font-weight:400;
  font-style:normal;
  text-decoration:underline;
  text-underline-style:single;
  font-family:Calibri, sans-serif;
  mso-font-charset:0;
  mso-style-name:Hipervínculo;
  mso-style-id:8;}
a:link
  {color:blue;
  font-size:11.0pt;
  font-weight:400;
  font-style:normal;
  text-decoration:underline;
  text-underline-style:single;
  font-family:Calibri, sans-serif;
  mso-font-charset:0;}
a:visited
  {color:#954F72;
  font-size:11.0pt;
  font-weight:400;
  font-style:normal;
  text-decoration:underline;
  text-underline-style:single;
  font-family:Calibri, sans-serif;
  mso-font-charset:0;}
.style0
  {mso-number-format:General;
  text-align:general;
  vertical-align:bottom;
  white-space:nowrap;
  mso-rotate:0;
  mso-background-source:auto;
  mso-pattern:auto;
  color:black;
  font-size:11.0pt;
  font-weight:400;
  font-style:normal;
  text-decoration:none;
  font-family:Calibri, sans-serif;
  mso-font-charset:0;
  border:none;
  mso-protection:locked visible;
  mso-style-name:Normal;
  mso-style-id:0;}
td
  {mso-style-parent:style0;
  padding-top:1px;
  padding-right:1px;
  padding-left:1px;
  mso-ignore:padding;
  color:black;
  font-size:11.0pt;
  font-weight:400;
  font-style:normal;
  text-decoration:none;
  font-family:Calibri, sans-serif;
  mso-font-charset:0;
  mso-number-format:General;
  text-align:general;
  vertical-align:bottom;
  border:none;
  mso-background-source:auto;
  mso-pattern:auto;
  mso-protection:locked visible;
  white-space:nowrap;
  mso-rotate:0;}
.xl79
  {mso-style-parent:style0;
  white-space:normal;}
.xl80
  {mso-style-parent:style0;
  font-weight:700;}
.xl81
  {mso-style-parent:style0;
  border-top:1.0pt solid black;
  border-right:.5pt solid black;
  border-bottom:.5pt solid black;
  border-left:1.0pt solid black;
  white-space:normal;}
.xl82
  {mso-style-parent:style0;
  border-top:.5pt solid black;
  border-right:.5pt solid black;
  border-bottom:.5pt solid black;
  border-left:1.0pt solid black;
  white-space:normal;}
.xl83
  {mso-style-parent:style0;
  border-top:.5pt solid black;
  border-right:1.0pt solid black;
  border-bottom:.5pt solid black;
  border-left:.5pt solid black;
  white-space:normal;}
.xl84
  {mso-style-parent:style0;
  border-top:.5pt solid black;
  border-right:.5pt solid black;
  border-bottom:1.0pt solid black;
  border-left:1.0pt solid black;
  white-space:normal;}
.xl85
  {mso-style-parent:style53;
  color:white;
  border-top:1.0pt solid black;
  border-right:1.0pt solid black;
  border-bottom:.5pt solid black;
  border-left:.5pt solid black;
  background:#333399;
  mso-pattern:#003366 none;
  white-space:normal;}
.xl86
  {mso-style-parent:style0;
  border:.5pt solid black;
  white-space:normal;}
.xl87
  {mso-style-parent:style0;
  border-top:.5pt solid black;
  border-right:.5pt solid black;
  border-bottom:1.0pt solid black;
  border-left:.5pt solid black;
  white-space:normal;}
.xl88
  {mso-style-parent:style0;
  border-top:.5pt solid black;
  border-right:1.0pt solid black;
  border-bottom:1.0pt solid black;
  border-left:.5pt solid black;
  white-space:normal;}
.xl89
  {mso-style-parent:style0;
  font-weight:700;
  white-space:normal;}
.xl90
  {mso-style-parent:style53;
  color:white;
  border-top:1.0pt solid black;
  border-right:.5pt solid black;
  border-bottom:.5pt solid black;
  border-left:1.0pt solid black;
  background:#333399;
  mso-pattern:#003366 none;
  white-space:normal;}
.xl91
  {mso-style-parent:style53;
  color:white;
  text-align:left;
  border-top:1.0pt solid black;
  border-right:.5pt solid black;
  border-bottom:.5pt solid black;
  border-left:.5pt solid black;
  background:#333399;
  mso-pattern:#003366 none;
  white-space:normal;}
.xl92
  {mso-style-parent:style53;
  color:white;
  text-align:left;
  border-top:1.0pt solid windowtext;
  border-right:.5pt solid windowtext;
  border-bottom:.5pt solid windowtext;
  border-left:1.0pt solid windowtext;
  background:#333399;
  mso-pattern:#003366 none;
  white-space:normal;}
.xl93
  {mso-style-parent:style53;
  color:white;
  border-top:1.0pt solid windowtext;
  border-right:.5pt solid windowtext;
  border-bottom:.5pt solid windowtext;
  border-left:.5pt solid windowtext;
  background:#333399;
  mso-pattern:#003366 none;
  white-space:normal;}
.xl94
  {mso-style-parent:style53;
  color:white;
  border-top:1.0pt solid windowtext;
  border-right:1.0pt solid windowtext;
  border-bottom:.5pt solid windowtext;
  border-left:.5pt solid windowtext;
  background:#333399;
  mso-pattern:#003366 none;
  white-space:normal;}
.xl95
  {mso-style-parent:style0;
  border-top:1.0pt solid black;
  border-right:1.0pt solid black;
  border-bottom:.5pt solid black;
  border-left:.5pt solid black;
  background:#C6E0B4;
  mso-pattern:black none;
  white-space:normal;}
.xl96
  {mso-style-parent:style0;
  border-top:.5pt solid black;
  border-right:1.0pt solid black;
  border-bottom:.5pt solid black;
  border-left:.5pt solid black;
  background:#C6E0B4;
  mso-pattern:black none;
  white-space:normal;}
.xl97
  {mso-style-parent:style0;
  text-align:left;
  border-top:.5pt solid black;
  border-right:1.0pt solid black;
  border-bottom:.5pt solid black;
  border-left:.5pt solid black;
  background:#C6E0B4;
  mso-pattern:black none;
  white-space:normal;}
.xl98
  {mso-style-parent:style54;
  color:blue;
  text-decoration:underline;
  text-underline-style:single;
  border-top:.5pt solid black;
  border-right:1.0pt solid black;
  border-bottom:.5pt solid black;
  border-left:.5pt solid black;
  background:#C6E0B4;
  mso-pattern:black none;
  white-space:normal;}
.xl99
  {mso-style-parent:style0;
  mso-number-format:"_\(\0022$ \0022* \#\,\#\#0_\)\;_\(\0022$ \0022* \\\(\#\,\#\#0\\\)\;_\(\0022$ \0022* \\-??_\)\;_\(\@_\)";
  border-top:.5pt solid black;
  border-right:1.0pt solid black;
  border-bottom:.5pt solid black;
  border-left:.5pt solid black;
  background:#FFE699;
  mso-pattern:black none;
  white-space:normal;}
.xl100
  {mso-style-parent:style0;
  mso-number-format:"_\(\0022$ \0022* \#\,\#\#0_\)\;_\(\0022$ \0022* \\\(\#\,\#\#0\\\)\;_\(\0022$ \0022* \\-??_\)\;_\(\@_\)";
  border-top:.5pt solid black;
  border-right:1.0pt solid black;
  border-bottom:.5pt solid black;
  border-left:.5pt solid black;
  background:#C6E0B4;
  mso-pattern:black none;
  white-space:normal;}
.xl101
  {mso-style-parent:style0;
  mso-number-format:"Short Date";
  border-top:.5pt solid black;
  border-right:1.0pt solid black;
  border-bottom:1.0pt solid black;
  border-left:.5pt solid black;
  background:yellow;
  mso-pattern:black none;
  white-space:normal;}
.xl102
  {mso-style-parent:style0;
  text-align:center;
  border:.5pt solid black;
  white-space:normal;}

.normal
  {mso-style-parent:style0;
  text-align:justify;
  border:.5pt solid black;
  white-space:normal;}

</style>

</head>

<body link=blue vlink="#954F72" class=xl79>

<table border=0 cellpadding=0 cellspacing=0 width=2033 style='border-collapse:
 collapse;table-layout:fixed;width:1528pt'>
 <col width=78 style='mso-width-source:userset;mso-width-alt:2852;width:59pt'>
 <col class=xl79 width=180 style='mso-width-source:userset;mso-width-alt:6582;
 width:135pt'>
 <col class=xl79 width=465 style='mso-width-source:userset;mso-width-alt:17005;
 width:349pt'>
 <col class=xl79 width=106 span=2 style='mso-width-source:userset;mso-width-alt:
 3876;width:80pt'>
 <col class=xl79 width=122 style='mso-width-source:userset;mso-width-alt:4461;
 width:92pt'>
 <col class=xl79 width=152 style='mso-width-source:userset;mso-width-alt:5558;
 width:114pt'>
 <col class=xl79 width=149 style='mso-width-source:userset;mso-width-alt:5449;
 width:112pt'>
 <col class=xl79 width=115 style='mso-width-source:userset;mso-width-alt:4205;
 width:86pt'>
 <col class=xl79 width=113 style='mso-width-source:userset;mso-width-alt:4132;
 width:85pt'>
 <col class=xl79 width=117 style='mso-width-source:userset;mso-width-alt:4278;
 width:88pt'>
 <col class=xl79 width=330 style='mso-width-source:userset;mso-width-alt:12068;
 width:248pt'>
 <col class=xl79 width=98 style='mso-width-source:userset;mso-width-alt:3584;
 width:74pt'>
 <col class=xl79 width=297 style='mso-width-source:userset;mso-width-alt:10861;
 width:223pt'>
 <tr height=20 style='height:15.0pt'>
  <td height=20 align=right width=78 style='height:15.0pt;width:59pt'></td>
  <td class=xl79 width=180 style='width:135pt'></td>
  <td class=xl79 width=465 style='width:349pt'></td>
  <td class=xl79 width=106 style='width:80pt'></td>
  <td class=xl79 width=106 style='width:80pt'></td>
  <td class=xl79 width=122 style='width:92pt'></td>
  <td class=xl79 width=152 style='width:114pt'></td>
  <td class=xl79 width=149 style='width:112pt'></td>
  <td class=xl79 width=115 style='width:86pt'></td>
  <td class=xl79 width=113 style='width:85pt'></td>
  <td class=xl79 width=117 style='width:88pt'></td>
  <td class=xl79 width=330 style='width:248pt'></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 style='height:15.0pt'></td>
  <td class=xl80 colspan=2 style='mso-ignore:colspan'>PLAN ANUAL DE
  ADQUISICIONES</td>
  <td class=xl79 width=106 style='width:80pt'></td>
  <td class=xl79 width=106 style='width:80pt'></td>
  <td class=xl79 width=122 style='width:92pt'></td>
  <td class=xl79 width=152 style='width:114pt'></td>
  <td class=xl79 width=149 style='width:112pt'></td>
  <td class=xl79 width=115 style='width:86pt'></td>
  <td class=xl79 width=113 style='width:85pt'></td>
  <td class=xl79 width=117 style='width:88pt'></td>
  <td class=xl79 width=330 style='width:248pt'></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 style='height:15.0pt'></td>
  <td class=xl80></td>
  <td class=xl79 width=465 style='width:349pt'></td>
  <td class=xl79 width=106 style='width:80pt'></td>
  <td class=xl79 width=106 style='width:80pt'></td>
  <td class=xl79 width=122 style='width:92pt'></td>
  <td class=xl79 width=152 style='width:114pt'></td>
  <td class=xl79 width=149 style='width:112pt'></td>
  <td class=xl79 width=115 style='width:86pt'></td>
  <td class=xl79 width=113 style='width:85pt'></td>
  <td class=xl79 width=117 style='width:88pt'></td>
  <td class=xl79 width=330 style='width:248pt'></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 style='height:15.0pt'></td>
  <td class=xl80 colspan=2 style='mso-ignore:colspan'>A. INFORMACIÓN GENERAL DE
  LA ENTIDAD</td>
  <td class=xl79 width=106 style='width:80pt'></td>
  <td class=xl79 width=106 style='width:80pt'></td>
  <td class=xl79 width=122 style='width:92pt'></td>
  <td class=xl79 width=152 style='width:114pt'></td>
  <td class=xl79 width=149 style='width:112pt'></td>
  <td class=xl79 width=115 style='width:86pt'></td>
  <td class=xl79 width=113 style='width:85pt'></td>
  <td class=xl79 width=117 style='width:88pt'></td>
  <td class=xl79 width=330 style='width:248pt'></td>
 </tr>
 <tr height=22 style='mso-height-source:userset;height:16.7pt'>
  <td height=22 style='height:16.7pt'></td>
  <td class=xl81 width=180 style='width:135pt'>Nombre</td>
  <td class=xl95 width=465 style='border-left:none;width:349pt'>INSTITUTO
  DISTRITAL DE RECREACIÓN Y DEPORTE</td>
  <td class=xl79 width=106 style='width:80pt'></td>
  <td class=xl79 width=106 style='width:80pt'></td>
  <td colspan=4 rowspan=5 class=xl102 width=538 style='width:404pt'>El
  principal objetivo del Plan Anual de Adquisiciones es permitir que la entidad
  estatal aumente la probabilidad de lograr mejores condiciones de competencia
  a través de la participación de un mayor número de operadores económicos
  interesados en los procesos de selección que se van a adelantar durante el
  año fiscal, y que el Estado cuente con información suficiente para realizar
  compras coordinadas.<span style='mso-spacerun:yes'> </span></td>
  <td class=xl79 width=113 style='width:85pt'></td>
  <td class=xl79 width=117 style='width:88pt'></td>
  <td class=xl79 width=330 style='width:248pt'></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 style='height:15.0pt'></td>
  <td class=xl82 width=180 style='border-top:none;width:135pt'>Dirección</td>
  <td class=xl96 width=465 style='border-top:none;border-left:none;width:349pt'>Calle
  63 # 59A - 06 Bogotá</td>
  <td class=xl79 width=106 style='width:80pt'></td>
  <td class=xl79 width=106 style='width:80pt'></td>
  <td class=xl79 width=113 style='width:85pt'></td>
  <td class=xl79 width=117 style='width:88pt'></td>
  <td class=xl79 width=330 style='width:248pt'></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 style='height:15.0pt'></td>
  <td class=xl82 width=180 style='border-top:none;width:135pt'>Teléfono</td>
  <td class=xl97 width=465 style='border-top:none;border-left:none;width:349pt'>6605400</td>
  <td class=xl79 width=106 style='width:80pt'></td>
  <td class=xl79 width=106 style='width:80pt'></td>
  <td class=xl79 width=113 style='width:85pt'></td>
  <td class=xl79 width=117 style='width:88pt'></td>
  <td class=xl79 width=330 style='width:248pt'></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 style='height:15.0pt'></td>
  <td class=xl82 width=180 style='border-top:none;width:135pt'>Página web</td>
  <td class=xl98 width=465 style='border-top:none;border-left:none;width:349pt'>www.idrd.gov.co</td>
  <td class=xl79 width=106 style='width:80pt'></td>
  <td class=xl79 width=106 style='width:80pt'></td>
  <td class=xl79 width=113 style='width:85pt'></td>
  <td class=xl79 width=117 style='width:88pt'></td>
  <td class=xl79 width=330 style='width:248pt'></td>
 </tr>
 <tr height=80 style='height:60.0pt'>
  <td height=80 style='height:60.0pt'></td>
  <td class=xl82 width=180 style='border-top:none;width:135pt'>Misión y visión</td>
  <td class=xl96 width=465 style='border-top:none;border-left:none;width:349pt'>MISIÓN:
  Generar y fomentar espacios<span style='mso-spacerun:yes'>  </span>para la
  recreación el deporte, la actividad física<span style='mso-spacerun:yes'> 
  </span>y la sostenibilidad de los parques y escenarios , mejorando la calidad
  de vida , el sentido de pertenencia y la felicidad de los habitantes de
  Bogotá D.C</td>
  <td class=xl79 width=106 style='width:80pt'></td>
  <td class=xl79 width=106 style='width:80pt'></td>
  <td class=xl79 width=113 style='width:85pt'></td>
  <td class=xl79 width=117 style='width:88pt'></td>
  <td class=xl79 width=330 style='width:248pt'></td>
 </tr>
 <tr height=240 style='height:180.0pt'>
  <td height=240 style='height:180.0pt'></td>
  <td class=xl82 width=180 style='border-top:none;width:135pt'>Perspectiva
  estratégica</td>
  <td class=xl96 width=465 style='border-top:none;border-left:none;width:349pt'>1.Mejorar
  la cobertura y las condiciones de infraestructura de los parques y escenarios
  para el uso y disfrute<span style='mso-spacerun:yes'>  </span>de la población
  de Bogotá D.C.<br>
    2.Impulsar<span style='mso-spacerun:yes'>  </span>la<span
  style='mso-spacerun:yes'>  </span>participación<span
  style='mso-spacerun:yes'>  </span>activa<span style='mso-spacerun:yes'> 
  </span>de<span style='mso-spacerun:yes'>  </span>los<span
  style='mso-spacerun:yes'>  </span>habitantes<span style='mso-spacerun:yes'> 
  </span>de<span style='mso-spacerun:yes'>  </span>Bogotá<span
  style='mso-spacerun:yes'>  </span>en<span style='mso-spacerun:yes'> 
  </span>los<span style='mso-spacerun:yes'>  </span>servicios<span
  style='mso-spacerun:yes'>  </span>recreativos y deportivos<span
  style='mso-spacerun:yes'>  </span>ofrecidos<span style='mso-spacerun:yes'> 
  </span>por<span style='mso-spacerun:yes'>  </span>la entidad fomentando<span
  style='mso-spacerun:yes'>  </span>el<span style='mso-spacerun:yes'> 
  </span>buen<span style='mso-spacerun:yes'>  </span>uso y<span
  style='mso-spacerun:yes'>  </span>aprovechamiento<span
  style='mso-spacerun:yes'>  </span>del<span style='mso-spacerun:yes'> 
  </span>tiempo<span style='mso-spacerun:yes'>  </span>libre. <br>
    3.Brindar apoyo a la preparación y participación de los deportistas del
  registro de Bogotá para<span style='mso-spacerun:yes'> 
  </span>posicionarlos<span style='mso-spacerun:yes'>  </span>en las competencias
  nacionales e internacionales.<br>
    4.Fortalecer la eficiencia administrativa como eje<span
  style='mso-spacerun:yes'>  </span>del desarrollo de la entidad .<br>
    Contamos con una única sede</td>
  <td class=xl79 width=106 style='width:80pt'></td>
  <td class=xl79 width=106 style='width:80pt'></td>
  <td class=xl79 width=122 style='width:92pt'></td>
  <td class=xl79 width=152 style='width:114pt'></td>
  <td class=xl79 width=149 style='width:112pt'></td>
  <td class=xl79 width=115 style='width:86pt'></td>
  <td class=xl79 width=113 style='width:85pt'></td>
  <td class=xl79 width=117 style='width:88pt'></td>
  <td class=xl79 width=330 style='width:248pt'></td>
 </tr>
 <tr height=22 style='mso-height-source:userset;height:16.7pt'>
  <td height=22 style='height:16.7pt'></td>
  <td class=xl82 width=180 style='border-top:none;width:135pt'>Información de
  contacto</td>
  <td class=xl96 width=465 style='border-top:none;border-left:none;width:349pt'>MARTHA
  LILIANA GONZALEZ MARTINEZ</td>
  <td class=xl79 width=106 style='width:80pt'></td>
  <td class=xl79 width=106 style='width:80pt'></td>
  <td colspan=4 rowspan=5 class=xl102 width=538 style='width:404pt'>El Plan
  Anual de Adquisiciones es un documento de naturaleza informativa y las
  adquisiciones incluidas en el mismo pueden ser canceladas, revisadas o
  modificadas. Esta información no representa compromiso u obligación alguna
  por parte de la entidad estatal ni la compromete a adquirir los bienes, obras
  y servicios en él señalados.<span style='mso-spacerun:yes'> </span></td>
  <td class=xl79 width=113 style='width:85pt'></td>
  <td class=xl79 width=117 style='width:88pt'></td>
  <td class=xl79 width=330 style='width:248pt'></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 style='height:15.0pt'></td>
  <td class=xl82 width=180 style='border-top:none;width:135pt'>Valor total del
  PAA</td>
  <td class=xl99 width=465 style='border-top:none;border-left:none;width:349pt'>&nbsp;</td>
  <td class=xl79 width=106 style='width:80pt'></td>
  <td class=xl79 width=106 style='width:80pt'></td>
  <td class=xl79 width=113 style='width:85pt'></td>
  <td class=xl79 width=117 style='width:88pt'></td>
  <td class=xl79 width=330 style='width:248pt'></td>
 </tr>
 <tr height=40 style='height:30.0pt'>
  <td height=40 style='height:30.0pt'></td>
  <td class=xl82 width=180 style='border-top:none;width:135pt'>Límite de
  contratación menor cuantía</td>
  <td class=xl100 width=465 style='border-top:none;border-left:none;width:349pt'>&nbsp;</td>
  <td class=xl79 width=106 style='width:80pt'></td>
  <td class=xl79 width=106 style='width:80pt'></td>
  <td class=xl79 width=113 style='width:85pt'></td>
  <td class=xl79 width=117 style='width:88pt'></td>
  <td class=xl79 width=330 style='width:248pt'></td>
 </tr>
 <tr height=40 style='height:30.0pt'>
  <td height=40 style='height:30.0pt'></td>
  <td class=xl82 width=180 style='border-top:none;width:135pt'>Límite de
  contratación mínima cuantía</td>
  <td class=xl100 width=465 style='border-top:none;border-left:none;width:349pt'>&nbsp;</td>
  <td class=xl79 width=106 style='width:80pt'></td>
  <td class=xl79 width=106 style='width:80pt'></td>
  <td class=xl79 width=113 style='width:85pt'></td>
  <td class=xl79 width=117 style='width:88pt'></td>
  <td class=xl79 width=330 style='width:248pt'></td>
 </tr>
 <tr height=40 style='height:30.0pt'>
  <td height=40 style='height:30.0pt'></td>
  <td class=xl84 width=180 style='border-top:none;width:135pt'>Fecha de última
  actualización del PAA</td>
  <td class=xl101 width=465 style='border-top:none;border-left:none;width:349pt'>&nbsp;</td>
  <td class=xl79 width=106 style='width:80pt'></td>
  <td class=xl79 width=106 style='width:80pt'></td>
  <td class=xl79 width=113 style='width:85pt'></td>
  <td class=xl79 width=117 style='width:88pt'></td>
  <td class=xl79 width=330 style='width:248pt'></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 style='height:15.0pt'></td>
  <td class=xl79 width=180 style='width:135pt'></td>
  <td class=xl79 width=465 style='width:349pt'></td>
  <td class=xl79 width=106 style='width:80pt'></td>
  <td class=xl79 width=106 style='width:80pt'></td>
  <td class=xl79 width=122 style='width:92pt'></td>
  <td class=xl79 width=152 style='width:114pt'></td>
  <td class=xl79 width=149 style='width:112pt'></td>
  <td class=xl79 width=115 style='width:86pt'></td>
  <td class=xl79 width=113 style='width:85pt'></td>
  <td class=xl79 width=117 style='width:88pt'></td>
  <td class=xl79 width=330 style='width:248pt'></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 style='height:15.75pt'></td>
  <td class=xl80 colspan=2 style='mso-ignore:colspan'>B. ADQUISICIONES
  PLANEADAS</td>
  <td class=xl79 width=106 style='width:80pt'></td>
  <td class=xl79 width=106 style='width:80pt'></td>
  <td class=xl79 width=122 style='width:92pt'></td>
  <td class=xl79 width=152 style='width:114pt'></td>
  <td class=xl79 width=149 style='width:112pt'></td>
  <td class=xl79 width=115 style='width:86pt'></td>
  <td class=xl79 width=113 style='width:85pt'></td>
  <td class=xl79 width=117 style='width:88pt'></td>
  <td class=xl79 width=330 style='width:248pt'></td>
 </tr>
 <tr height=80 style='height:60.0pt'>
  <td height=80 style='height:60.0pt'></td>
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
 </tr>
 


 @foreach($paas as $paa)  

<tr height=20 style='height:15.0pt'>
  <td height=20 style='height:15.0pt'></td>
  <td width=180 style='width:135pt' class=normal>{{$paa['CodigosU']}}</td>
  <td width=465 style='width:349pt' class=normal>{{$paa['ObjetoContractual']}}</td>
  <td width=106 style='width:80pt' class=normal>{{$paa['FechaInicioProceso']}}</td>
  <td width=106 style='width:80pt' class=normal>{{$paa['DuracionContrato']}}</td>
  <td class=xl79 width=122 style='width:92pt' class=normal>{{$paa->modalidad['Nombre']}}</td>
  <td class=xl79 width=152 style='width:114pt' class=normal>
    <?php $os = array('0'); ?>
    @foreach($paa->componentes as $componente)

        @if (in_array($componente->fuente['Id'], $os, false))
        {{$componente->fuente['nombre']}}
        @endIf

        <?php 
          $IdFue=$componente->fuente['Id'];
          array_push($os,$IdFue);
        ?>
        

    @endforeach
  </td>
  <td class=xl79 width=149 style='width:112pt' class=normal>{{$paa['ValorEstimado']}}</td>
  <td width=115 style='width:86pt' class=normal>{{$paa['ValorEstimadoVigencia']}}</td>
  <td width=113 style='width:85pt' class=normal>{{$paa['VigenciaFutura']}}</td>
  <td width=117 style='width:88pt' class=normal>{{$paa['EstadoVigenciaFutura']}}</td>
  <td  width=330 style='width:248pt' class=normal></td>
 </tr>
      
@endforeach

 



 <tr height=41 style='height:30.75pt'>
  <td height=41 style='height:30.75pt'></td>
  <td class=xl89 width=180 style='width:135pt'>C. NECESIDADES ADICIONALES</td>
  <td colspan=2 style='mso-ignore:colspan'></td>
  <td class=xl79 width=106 style='width:80pt'></td>
  <td class=xl79 width=122 style='width:92pt'></td>
  <td class=xl79 width=152 style='width:114pt'></td>
  <td class=xl79 width=149 style='width:112pt'></td>
  <td class=xl79 width=115 style='width:86pt'></td>
  <td class=xl79 width=113 style='width:85pt'></td>
  <td class=xl79 width=117 style='width:88pt'></td>
  <td class=xl79 width=330 style='width:248pt'></td>
 </tr>
 <tr height=60 style='height:45.0pt'>
  <td height=60 style='height:45.0pt'></td>
  <td class=xl90 width=180 style='width:135pt'>Descripción</td>
  <td class=xl91 width=465 style='border-left:none;width:349pt'>Posibles
  códigos UNSPSC</td>
  <td class=xl85 width=106 style='border-left:none;width:80pt'>Datos de
  contacto del responsable</td>
  <td class=xl79 width=106 style='width:80pt'></td>
  <td class=xl79 width=122 style='width:92pt'></td>
  <td class=xl79 width=152 style='width:114pt'></td>
  <td class=xl79 width=149 style='width:112pt'></td>
  <td class=xl79 width=115 style='width:86pt'></td>
  <td class=xl79 width=113 style='width:85pt'></td>
  <td class=xl79 width=117 style='width:88pt'></td>
  <td class=xl79 width=330 style='width:248pt'></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 style='height:15.0pt'></td>
  <td class=xl82 width=180 style='border-top:none;width:135pt'>&nbsp;</td>
  <td class=xl86 width=465 style='border-top:none;border-left:none;width:349pt'>&nbsp;</td>
  <td class=xl83 width=106 style='border-top:none;border-left:none;width:80pt'>&nbsp;</td>
  <td class=xl79 width=106 style='width:80pt'></td>
  <td class=xl79 width=122 style='width:92pt'></td>
  <td class=xl79 width=152 style='width:114pt'></td>
  <td class=xl79 width=149 style='width:112pt'></td>
  <td class=xl79 width=115 style='width:86pt'></td>
  <td class=xl79 width=113 style='width:85pt'></td>
  <td class=xl79 width=117 style='width:88pt'></td>
  <td class=xl79 width=330 style='width:248pt'></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 style='height:15.0pt'></td>
  <td class=xl82 width=180 style='border-top:none;width:135pt'>&nbsp;</td>
  <td class=xl86 width=465 style='border-top:none;border-left:none;width:349pt'>&nbsp;</td>
  <td class=xl83 width=106 style='border-top:none;border-left:none;width:80pt'>&nbsp;</td>
  <td class=xl79 width=106 style='width:80pt'></td>
  <td class=xl79 width=122 style='width:92pt'></td>
  <td class=xl79 width=152 style='width:114pt'></td>
  <td class=xl79 width=149 style='width:112pt'></td>
  <td class=xl79 width=115 style='width:86pt'></td>
  <td class=xl79 width=113 style='width:85pt'></td>
  <td class=xl79 width=117 style='width:88pt'></td>
  <td class=xl79 width=330 style='width:248pt'></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 style='height:15.0pt'></td>
  <td class=xl82 width=180 style='border-top:none;width:135pt'>&nbsp;</td>
  <td class=xl86 width=465 style='border-top:none;border-left:none;width:349pt'>&nbsp;</td>
  <td class=xl83 width=106 style='border-top:none;border-left:none;width:80pt'>&nbsp;</td>
  <td class=xl79 width=106 style='width:80pt'></td>
  <td class=xl79 width=122 style='width:92pt'></td>
  <td class=xl79 width=152 style='width:114pt'></td>
  <td class=xl79 width=149 style='width:112pt'></td>
  <td class=xl79 width=115 style='width:86pt'></td>
  <td class=xl79 width=113 style='width:85pt'></td>
  <td class=xl79 width=117 style='width:88pt'></td>
  <td class=xl79 width=330 style='width:248pt'></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 style='height:15.0pt'></td>
  <td class=xl82 width=180 style='border-top:none;width:135pt'>&nbsp;</td>
  <td class=xl86 width=465 style='border-top:none;border-left:none;width:349pt'>&nbsp;</td>
  <td class=xl83 width=106 style='border-top:none;border-left:none;width:80pt'>&nbsp;</td>
  <td class=xl79 width=106 style='width:80pt'></td>
  <td class=xl79 width=122 style='width:92pt'></td>
  <td class=xl79 width=152 style='width:114pt'></td>
  <td class=xl79 width=149 style='width:112pt'></td>
  <td class=xl79 width=115 style='width:86pt'></td>
  <td class=xl79 width=113 style='width:85pt'></td>
  <td class=xl79 width=117 style='width:88pt'></td>
  <td class=xl79 width=330 style='width:248pt'></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 style='height:15.75pt'></td>
  <td class=xl84 width=180 style='border-top:none;width:135pt'>&nbsp;</td>
  <td class=xl87 width=465 style='border-top:none;border-left:none;width:349pt'>&nbsp;</td>
  <td class=xl88 width=106 style='border-top:none;border-left:none;width:80pt'>&nbsp;</td>
  <td class=xl79 width=106 style='width:80pt'></td>
  <td class=xl79 width=122 style='width:92pt'></td>
  <td class=xl79 width=152 style='width:114pt'></td>
  <td class=xl79 width=149 style='width:112pt'></td>
  <td class=xl79 width=115 style='width:86pt'></td>
  <td class=xl79 width=113 style='width:85pt'></td>
  <td class=xl79 width=117 style='width:88pt'></td>
  <td class=xl79 width=330 style='width:248pt'></td>
 </tr>

</table>

</body>

</html>
