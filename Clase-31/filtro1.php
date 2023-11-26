<?php
require '../Clase-31/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
include './conf.php';

//productos que vencen en el mes actual
$filtro1 = "SELECT * FROM tbl_invesproduct WHERE MONTH(vencimiento) = MONTH(CURDATE()) AND YEAR(vencimiento) = YEAR(CURDATE())";
$resultado = mysqli_query($conexion, $filtro1);

$archivo = 'Producto-vencido-mesactual'.date('Ymd_His').'.pdf';

$html = '<table border="1" cellspacing="0" cellpadding="5">
                <tr>
                    <th>ID</th>
                    <th>Producto</th>
                    <th>Proveedor</th>
                    <th>Existencias</th>
                    <th>Bodegas</th>
                    <th>Precio</th>
                    <th>Vencimiento</th>
                    <th>Introduccion</th>
                </tr>';

while ($fila = mysqli_fetch_assoc($resultado)) {
    $html .= '<tr>';
    $html .= '<td>' . $fila['id'] . '</td>';
    $html .= '<td>' . $fila['producto'] . '</td>';
    $html .= '<td>' . $fila['proveedor'] . '</td>';
    $html .= '<td>' . $fila['existencias'] . '</td>';
    $html .= '<td>' . $fila['bodegas'] . '</td>';
    $html .= '<td>' . $fila['precio'] . '</td>';
    $html .= '<td>' . $fila['vencimiento'] . '</td>';
    $html .= '<td>' . $fila['introduccion'] . '</td>';
    $html .= '</tr>';
}

$dompdf = new Dompdf();
$html .= '</table>';

$dompdf->loadHtml($html);

$dompdf->render();

$dompdf->stream($archivo);
?>