<?php
// 
$rectAbvImgL=15;
$rectBlwImgL=15;
$pageWidth=297;
$pathToImage='image2.png';
$imgLength=60;
$pathToImage2='image3.png';
$imgLength2=40;
$belowText=file_get_contents('text');
$fontSize=19;
function generatePDF(){
	global $rectAbvImgL,$rectBlwImgL,$pageWidth,$pathToImage,$imgLength,$pathToImage2,$imgLength2,$belowText,$fontSize;
	$pdf = new FPDF('P','mm','A4');
	$pdf->AddPage();
	// Set Top Rectange - Above Image
	$pdf->SetFillColor(0,0,0);
	$pdf->Rect(0,0,$pageWidth,$rectAbvImgL,'F');
	// $pdf->SetXY(15,15);
	$pdf->Image($pathToImage,0,$rectAbvImgL,$pageWidth,$imgLength);
	// Set Top Rectange - Below Image
	$pdf->SetFillColor(254, 0, 0);
	$pdf->Rect(0,$rectAbvImgL+$imgLength,$pageWidth,$rectBlwImgL,'F');
	// Maintain Border
	$pdf->Image($pathToImage2,0,$rectAbvImgL+$imgLength+$rectBlwImgL+1,0,$imgLength2);
	// 
	$ttlLenConvered=$rectAbvImgL+$imgLength+$rectBlwImgL+$imgLength2+4;
	$pdf->SetXY(0,$ttlLenConvered+10);
	$pdf->SetMargins(2,0,2);
	$pdf->SetFont('Helvetica','',$fontSize);
	$pdf->SetFillColor(196, 245, 113);
	$pdf->SetTextColor(0,0,0);
	$dataLen=getTextualHeight($belowText,$fontSize);
	// var_dump($dataLen);
	$pdf->Rect(0,$ttlLenConvered,$pageWidth,$dataLen+20,'F');
	$pdf->Multicell(0,10,$belowText,0,"C");
	// var_dump($pdf->getX());
	// var_dump($pdf->getY());
	
	// Get Output
	$filename='forceDownload';
	$pdf->Output('I', $filename.'.pdf');
}
function getTextualHeight($belowText,$fontSize){
	$pdf = new FPDF('P','mm','A4');
	$pdf->AddPage();
	$bfr=$pdf->getY();
	$pdf->SetMargins(2,0,2);
	$pdf->SetFont('Helvetica','',$fontSize);
	$pdf->Multicell(0,10,$belowText,0,"C");
	$aftr=$pdf->getY();
	// var_dump($aftr);
	// var_dump($bfr);
	// $pdf->Output();
	return $aftr-$bfr;
}
generatePDF();
?>