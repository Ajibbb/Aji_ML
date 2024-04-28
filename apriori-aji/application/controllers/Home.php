<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'libraries/dompdf/vendor/autoload.php';
use Dompdf\Dompdf;
class Home extends CI_Controller {
	function __construct() {
        parent::__construct();
        if($this->session->userdata('login')!==NULL){
          redirect('apriori');
        }
    }
	public function index(){
        $this->load->view("login");
    }
	public function pdf(){
		$dompdf = new Dompdf();
		$html = '
		<!DOCTYPE html>
		<html>
		<head>
		    <style>
		        body {
		            font-family: Arial, sans-serif;
								margin:0px;
		        }

		        .receipt {
		            width: 58mm;
		            padding: 5px;
		        }

		        .header {
		            text-align: center;
		        }

		        .item {
		            margin-bottom: 5px;
		        }

		        .item-name {
		            font-weight: bold;
		        }

		        .total {
		            text-align: right;
		            margin-top: 10px;
		            border-top: 1px solid #000;
		            padding-top: 5px;
		            font-weight: bold;
		        }
		    </style>
		</head>
		<body>
		    <div class="receipt">
		        <div class="header">
		            <h3>Sample Receipt</h3>
		        </div>
		        <div class="item">
		            <span class="item-name">Item 1:</span> $10
		        </div>
		        <div class="item">
		            <span class="item-name">Item 2:</span> $15
		        </div>
		        <div class="item">
		            <span class="item-name">Item 3:</span> $8
		        </div>
		        <div class="total">
		            Total: $33
		        </div>
		    </div>
		</body>
		</html>
		';
		$dompdf->loadHtml($html);

		// (Optional) Setup the paper size and orientation
		// $dompdf->setPaper('A4', 'portrait');

		// Render the HTML as PDF
		$dompdf->setPaper('58mm');
		$dompdf->render();

		// Output the generated PDF to Browser
		$dompdf->stream('receipt.pdf', ['Attachment' => false]);

	}
}
