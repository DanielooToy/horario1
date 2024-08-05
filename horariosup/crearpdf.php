<?php
require_once 'C:\xampp\htdocs\aprendiendo\vendor\autoload.inc.php';
use Dompdf\Dompdf;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $mensaje = $_POST['mensaje'];

    // Crear el contenido del PDF
    $html = "
    <html>
    <head><title>PDF generado desde formulario</title></head>
    <body>
        <h1>Formulario PDF</h1>
        <p><strong>Nombre:</strong> $nombre</p>
        <p><strong>Correo electrónico:</strong> $email</p>
        <p><strong>Mensaje:</strong> $mensaje</p>
    </body>
    </html>";

    // Crear instancia de Dompdf
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);

    // Renderizar el PDF
    $dompdf->render();

    // Guardar el PDF en el servidor
    $output = $dompdf->output();
    file_put_contents('formulario.pdf', $output);

    echo "PDF guardado correctamente como formulario.pdf";
}
?>
