<?php

require_once '../../../../vendor/autoload.php';
use Mpdf\Mpdf;

$html='
<table><tr><td></td></tr></table>
	<table border=1 width="100%" cellspacing="0" cellpadding="2">
			<tr ><td VALIGN="TOP" width="10"><font size="2">10 ESCALAS </br> GERIATRICAS</font></td></tr>
	</table>

	<table><tr><td></td></tr></table>
	
		<table width="100%">
	  	<tr>
			<td style="text-align: right;" colspan="2"><font size="2">FECHA:</font>
	  	 	
	  	 	</td>
	  	 	<td>
	  	 		<table border="1" width="100" cellspacing="0" cellpadding="2">
	  	 			<tr>
	  	 				<td>
	  	 					<font size="2"><center></center></font>
	  	 				</td>	
	  	 			</tr>	
	  	 		</table>	
	  	 	</td>
	  	  </tr>
	  	  </table>
';

$mpdf = new mPDF(['debug' => true, 'mode' => 'utf-8', 'format' => 'A4-L']);

$mpdf->writeHTML($html);
$mpdf->Output('prueba.pdf', 'I');


