<?php
require_once("../../../js/lib/mpdf60/mpdf.php");

$html='
<style>
	.th{
	   background: #99e6ff;
	   color: #000000;
	}

</style>
<table border="1" width="700" cellspacing="0" cellpadding="2"> 
           <tr>
              <th class="th"><center><h5>ESTABLECIMIENTO<h5></th>
              <th class="th"><center><h5>NOMBRE<h5></center></th>
              <th class="th"><center><h5>APELLIDO<h5></center></th>
              <th class="th "><center><h5>SEXO(M-F)<h5></center><div>
              <th class="th"><center><h5>EDAD <h5></center></th>
              <th class="th"><center><h5>N° HISTORIA CLÍNICA <h5></center></th>
              
              </div>
               
               </th>           
              </font>
              </tr>
            </center>
            <tr>
              <td class=""><center><H6>HOSPITAL GENERAL SANTO DOMINGO<H6></center></td>
              <td class=""><center><H6>RICARDO RAFAEL<H6></center></td>
              <td class=""><center><H6>REAL SIMALEZA<H6></center></td>
              <td class=""><center><H6>M<H6></center></td>
              <td class=""><center><H6>23<H6></center></td>
              <td class=""><center><H6>1724066897<H6></center></td>   
            </tr>  
</table>
<br>
<table border="1" width="700" cellspacing="0" cellpadding="2">
	<tr>
		<th  class="th"><H4><b>1. RESUMEN DE CUADTRO CLINICIO</b><h4></th>	
	</tr>
	<tr>
		<td height="270">

		</td>
	</tr>
</table><br>
<table border="1" width="700" cellspacing="0" cellpadding="2">
	<tr>
		<th  class="th"><H4><b>2. RESUMEN DE EVOLUVIÓN Y COMPLICACIONES</b><h4></th>	
	</tr>
	<tr>
		<td height="270">

		</td>
	</tr>
</table><br>
<table border="1" width="700" cellspacing="0" cellpadding="2">
	<tr>
		<th  class="th"><H4><b>3. HALLASZGO RELEVANTES DE EXÁMENES Y PROCEDIMIENTOS DIAGNÓSTICOS</b><h4></th>	
	</tr>
	<tr>
		<td height="270">

		</td>
			<H6>SNS-MSP / HCU-form.006 / 2008 </H6>
	</tr>
</table>

';

$mpdf= new mPDF('c','A4');
$mpdf->SetHTMLHeader('<div> <IMG SRC="img/msp.jpg" WIDTH=75 HEIGHT=35> <H4>HOSPITAL GENERAL SANTODOMINGO </H4>');
$mpdf->writeHTML($html);
$mpdf->SetHTMLFooter ('<h6>SNS-MSP / HCU-form.006 / 2008 </h6>');
$mpdf->Output('epicrisis','I');

?>