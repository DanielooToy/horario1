<?php
require_once 'dompdf/autoload.inc.php'; // Asegúrate de proporcionar la ruta correcta al archivo autoload.inc.php de dompdf

use Dompdf\Dompdf;

// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Aquí puedes incluir tu HTML
    $html = '<h1>Ejemplo de PDF generado con dompdf</h1><p>Este es un PDF generado desde HTML utilizando la biblioteca dompdf en PHP.</p>';

    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);

    // Renderiza el HTML como PDF
    $dompdf->render();

    // Guarda el PDF en un archivo en el servidor
    $archivo_pdf = 'archivo.pdf';
    file_put_contents($archivo_pdf, $dompdf->output());

    echo 'PDF generado: <a href="'.$archivo_pdf.'" target="_blank">'.$archivo_pdf.'</a>';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar PDF con dompdf</title>
</head>
<body>

<h2>Generar PDF</h2>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <button type="submit">Generar PDF</button>
</form>

</body>
</html>
