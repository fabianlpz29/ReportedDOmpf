<?php
require '../Clase-31/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
include './conf.php';

//productos con existencias mayores que 100
$filtro2 = "SELECT * FROM tbl_invesproduct WHERE existencias >= 100";
$resultado = mysqli_query($conexion, $filtro2);

$archivo = 'Productos-existencias-mayor100'.date('Ymd_His').'.pdf';

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