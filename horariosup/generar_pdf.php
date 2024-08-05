<?php
// Incluir la biblioteca TCPDF
require_once('../library/tcpdf.php');

// Crear una instancia de TCPDF
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Establecer la información del documento
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nombre del autor');
$pdf->SetTitle('Título del PDF');
$pdf->SetSubject('Asunto del PDF');
$pdf->SetKeywords('TCPDF, PDF, ejemplo, generación');

// Establecer el encabezado y pie de página
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
$pdf->setFooterData(array(0,64,0), array(0,64,128));

// Establecer las fuentes
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Establecer la fuente predeterminada
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Establecer los márgenes
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Establecer el espacio entre páginas
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Establecer el modo de subconjunto de fuentes
$pdf->setFontSubsetting(true);

// Establecer la fuente
$pdf->SetFont('helvetica', '', 12, '', true);

// Agregar una página
$pdf->AddPage();

// Contenido del PDF
$html = <<<EOD
<h1>Ejemplo de PDF generado con TCPDF</h1>
<p>Este es un ejemplo básico de cómo generar un PDF utilizando TCPDF en PHP.</p>
<p>Puedes agregar tu propio contenido aquí.</p>
EOD;

// Escribir el contenido HTML en el PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Cerrar y generar el PDF
$pdf->Output('ejemplo_pdf.pdf', 'I');