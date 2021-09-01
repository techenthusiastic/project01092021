<?php
require_once('fpdf.php');
class HelloPDF {
// Properties
	public $rectAbvImgL;
	public $rectBlwImgL;
	public $pageWidth;
	public $pathToImage;
	public $imgLength;
	public $pathToImage2;
	public $imgLength2;
	public $belowText;
	public $fontSize;
	function setDefaultValues($text){
		$this->rectAbvImgL=15;
		$this->rectBlwImgL=15;
		$this->pageWidth=297;
		$this->pathToImage='image2.png';
		$this->imgLength=60;
		$this->pathToImage2='image3.png';
		$this->imgLength2=40;
		$this->belowText=$text;	
		$this->fontSize=19;
	}
	// Methods
	function generatePDF(){
		$rectAbvImgL=$this->rectAbvImgL;
		$rectBlwImgL=$this->rectBlwImgL;
		$pageWidth=$this->pageWidth;
		$pathToImage=$this->pathToImage;
		$imgLength=$this->imgLength;
		$pathToImage2=$this->pathToImage2;
		$imgLength2=$this->imgLength2;
		$belowText=$this->belowText;
		$fontSize=$this->fontSize;
		// 
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
		$dataLen=$this->getTextualHeight($belowText,$fontSize);
	// var_dump($dataLen);
		$pdf->Rect(0,$ttlLenConvered,$pageWidth,$dataLen+20,'F');
		$pdf->Multicell(0,10,$belowText,0,"C");
	// var_dump($pdf->getX());
	// var_dump($pdf->getY());

	// Get Output
		$filename='forceDownload';
		$pdf->Output('I', $filename.'.pdf');
	}
	// 
	function getTextualHeight($belowText,$fontSize){
		$pdf = new FPDF('P','mm','A4');
		$pdf->AddPage();
		$bfr=$pdf->getY();
		$pdf->SetMargins(2,0,2);
		$pdf->SetFont('Helvetica','',$fontSize);
		$pdf->Multicell(0,10,$belowText,0,"C");
		$aftr=$pdf->getY();
		return $aftr-$bfr;
	}
	// Main Function
	function main($text){
		$this->setDefaultValues($text);
		$this->generatePDF();
	}
}
try {
	if (!isset($_GET['text'])||is_null($_GET['text'])||empty($_GET['text'])) {
		$text=file_get_contents('text');
	}else{
		$text=$_GET['text'];
	}
	$newPDF = new HelloPDF();
	$newPDF->main($text);
} catch (Exception $e) {
	var_dump($e);
}
?>
