<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PdfController extends Controller
{
	public static function call()
	{
		return new PdfController;
	}

	public function createPdf($name = 'pdf', $html = ''){
		
		require_once '../vendor/mpdf/mpdf/mpdf.php';
		
		$mpdf = new \mPDF ('utf-8', 'Letter', 0, '', 0, 0, 0, 0, 0, 0);
		$mpdf->SetDisplayMode('fullpage');
		 
		$mpdf->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list
		 
		$mpdf->WriteHTML($html);
		$mpdf->Output($name.'.pdf','I');
	}

}
