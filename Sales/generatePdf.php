<?php
require('./fpdf/fpdf.php');

class PDF extends FPDF {
    // Declare the angle property
    var $angle = 0;

    // Header function
    function Header() {
        // Add a custom background color
        $this->SetFillColor(240, 240, 240);
        $this->Rect(0, 0, 210, 297, 'F');
        
        // Add an image logo
        $this->Image('image.png', 10, 6, 30);

        // Set font for title
        $this->SetFont('Arial', 'B', 16);
        $this->SetTextColor(50, 50, 255);
        $this->Cell(0, 10, 'Heading', 0, 1, 'C');

        // Add a subtitle
        $this->SetFont('Arial', 'I', 12);
        $this->SetTextColor(100, 100, 100);
        $this->Cell(0, 10, 'Subtitle or Tagline Here', 0, 1, 'C');
        
        // Add a line break
        $this->Ln(10);
    }

    // Footer function
    function Footer() {
        // Add a custom background color to the footer
        $this->SetY(-30);
        $this->SetFillColor(220, 220, 220);
        $this->Rect(0, 270, 210, 27, 'F');

        // Set font for footer text
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(50, 50, 255);
        $this->Cell(0, 10, 'Footer Text Here', 0, 1, 'C');

        // Page number
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(150, 150, 150);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    // Watermark function
    function Watermark($text) {
        // Add a semi-transparent watermark
        $this->SetFont('Arial', 'B', 50);
        $this->SetTextColor(200, 200, 200);
        $this->RotatedText(35, 190, $text, 45);
    }

    // Rotated text function
    function RotatedText($x, $y, $txt, $angle) {
        // Rotate the text and output it
        $this->Rotate($angle, $x, $y);
        $this->Text($x, $y, $txt);
        $this->Rotate(0);
    }

    // Rotate function
    function Rotate($angle, $x = -1, $y = -1) {
        if ($x == -1) {
            $x = $this->x;
        }
        if ($y == -1) {
            $y = $this->y;
        }
        if ($this->angle != 0) {
            $this->_out('Q');
        }
        $this->angle = $angle;
        if ($angle != 0) {
            $angle *= M_PI / 180;
            $c = cos($angle);
            $s = sin($angle);
            $cx = $x * $this->k;
            $cy = ($this->h - $y) * $this->k;
            $this->_out(sprintf('q %.3F %.3F %.3F %.3F %.3F %.3F cm 1 0 0 1 %.3F %.3F cm', $c, $s, -$s, $c, $cx, $cy, -$cx, -$cy));
        }
    }
}

// Create a new PDF instance
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

// Add the watermark
$pdf->Watermark('CONFIDENTIAL');

// Set the font for the main content
$pdf->SetFont('Times', '', 12);

// Loop to add lines of text
for($i = 1; $i <= 30; $i++) {
    $pdf->Cell(0, 10, "Printing the line No " . $i, 0, 1, 'C', 1);
}

// Output the PDF
$pdf->Output();
?>
