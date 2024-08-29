<?php
session_start();
include 'includes/config.php';
require_once('tcpdf/tcpdf.php');

if (!isset($_SESSION['username']) || !isset($_GET['order_id'])) {
    header('Location: events.php');
    exit;
}

$order_id = $_GET['order_id'];

// Fetch receipt from database
$stmt = $conn->prepare("SELECT receipt FROM orders WHERE order_id = ?");
$stmt->bind_param("s", $order_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();

if ($order && $order['receipt']) {
    // Extend TCPDF with custom Header and Footer
    class MYPDF extends TCPDF {
        public function Header() {
            $this->SetY(10);
            $this->SetFont('helvetica', 'B', 20);
            $this->SetTextColor(255, 102, 0); // Orange color
            $this->Cell(0, 15, 'ADVAITA', 0, false, 'L', 0, '', 0, false, 'M', 'M');
            
            $this->SetFont('helvetica', '', 12);
            $this->SetTextColor(0);
            $this->SetY(20);
            $this->Cell(0, 10, '2024', 0, false, 'L', 0, '', 0, false, 'M', 'M');
            
            $this->SetY(10);
            $this->SetFont('helvetica', '', 8);
            $this->Cell(0, 10, 'DATE: ' . date('F d, Y H:i:s'), 0, false, 'R', 0, '', 0, false, 'T', 'M');
            
            // Add the new text below the date
            $this->SetY(30);
            $this->SetFont('helvetica', '', 10);
            $this->MultiCell(0, 10, "Payment recorded successfully! Your order is pending admin verification. Once the payment is confirmed, your order will be displayed on your profile.", 0, 'L', 0, 1, '', '', true);
        }
        

        public function Footer() {
            $this->SetY(-20);
            $this->SetFont('helvetica', 'B', 10);
            $this->SetTextColor(255, 102, 0); // Orange color
            $this->Cell(0, 10, '28 AUGUST', 0, false, 'L', 0, '', 0, false, 'T', 'M');
            $this->SetFont('helvetica', '', 10);
            $this->SetTextColor(0);
            $this->Cell(0, 10, 'COLLEGE CAMPUS, UDUPI', 0, false, 'R', 0, '', 0, false, 'T', 'M');
            $this->Ln(5);
            $this->SetFont('helvetica', '', 8);
            $this->Cell(60, 10, 'For More Information:', 0, false, 'L', 0, '', 0, false, 'T', 'M');
            $this->Cell(60, 10, '+91 1234567890', 0, false, 'C', 0, '', 0, false, 'T', 'M');
            $this->Cell(60, 10, '@yourid', 0, false, 'R', 0, '', 0, false, 'T', 'M');
        }
    }

    // Create new PDF document
    $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Advaita 2024');
    $pdf->SetTitle('Receipt for Order ' . $order_id);
    $pdf->SetSubject('Event Purchase Receipt');

    // Set margins
    $pdf->SetMargins(15, 40, 15);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // Add a page
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('helvetica', '', 12);

    // Write receipt content
    $html = '<h1>Receipt for Order: ' . $order_id . '</h1>';
    $html .= '<pre>' . htmlspecialchars($order['receipt'], ENT_QUOTES, 'UTF-8') . '</pre>';
    $pdf->writeHTML($html, true, false, true, false, '');

    // Close and output PDF document
    $pdf->Output('receipt_' . $order_id . '.pdf', 'D');
} else {
    echo "Receipt not found.";
}

$conn->close();
?>