<?php
require('fpdf/fpdf.php');

$data = json_decode(file_get_contents('php://input'), true);

$items = $data['items'];
$grandTotal = $data['grandTotal'];
$customerName = $data['customerName'];
$phoneNumber = $data['phoneNumber'];

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Header
$pdf->Cell(0, 10, 'Order Summary', 0, 1, 'C');
$pdf->Ln(10);

// Customer Details
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Customer Name: ' . $customerName, 0, 1);
$pdf->Cell(0, 10, 'Phone Number: ' . $phoneNumber, 0, 1);
$pdf->Cell(0, 10, 'Date: ' . date('Y-m-d'), 0, 1);
$pdf->Cell(0, 10, 'Time: ' . date('H:i:s'), 0, 1);
$pdf->Ln(10);

// Table Header
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(30, 10, 'Product ID', 1);
$pdf->Cell(40, 10, 'Serial Number', 1);
$pdf->Cell(30, 10, 'Quantity', 1);
$pdf->Cell(40, 10, 'Selling Price', 1);
$pdf->Cell(30, 10, 'Discount (%)', 1);
$pdf->Cell(30, 10, 'Total Price', 1);
$pdf->Ln();

// Table Data
$pdf->SetFont('Arial', '', 12);
foreach ($items as $item) {
    $pdf->Cell(30, 10, $item['product_id'], 1);
    $pdf->Cell(40, 10, $item['serial_number'], 1);
    $pdf->Cell(30, 10, $item['quantity'], 1);
    $pdf->Cell(40, 10, $item['selling_price'], 1);
    $pdf->Cell(30, 10, $item['discount'], 1);
    $pdf->Cell(30, 10, number_format($item['total_price'], 2), 1);
    $pdf->Ln();
}

// Grand Total
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Grand Total: ' . number_format($grandTotal, 2), 0, 1, 'R');

$pdf->Output('D', 'order_summary.pdf');
?>
