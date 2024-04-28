<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include ("libraries/autoload.php");
use GroceryCrud\Core\GroceryCrud;
class Apriori extends CI_Controller {
    var $footer = [];
    var $menu = [];
	function __construct() {
        parent::__construct();
        $database   = include ('database.php'); //config database Grocery
        $config     = include ('config.php'); //config library Grocery
        $this->crud = new GroceryCrud($config, $database); //initialize Grocery
    		$this->crud->unsetBootstrap();
    		$this->crud->unsetExport();
    		$this->crud->unsetPrint();
    
	}
    public function index(){
        $var['menu'] = $this->menu;
        $var['module'] = "apriori/dashboard";
        $var['var_module'] = array();
        $var['content_title'] = "";
        $var['breadcrumb'] = array(
                "Home"=>"",
                "Dashboard"=>"active"
        );
        $this->load->view('main',$var);

    }
	public function process($page="dataset")
	{
      $var['menu'] = $this->menu;
      $var['module'] = "apriori/process";
    	$var['var_module'] = array("page"=>$page);
      $var['content_title'] = "Metode Apriori";
    	$var['breadcrumb'] = array(
    			"Home"=>"",
    			"Apriori, Data Mining"=>"active"
    	);
	    $this->load->view('main',$var);
	}

  function dataset(){
    $var = array();
    $this->crud->setTable('dataset_aji');
		$this->crud->setSubject('Dataset');
    $output = $this->crud->render();
    if ($output->isJSONResponse) {
        header('Content-Type: application/json; charset=utf-8');
        echo $output->output;
        exit;
    }
    $var['menu'] = $this->menu;
		$var['gcrud'] = 1;
		$var['content_title'] = "Dataset";
		$var['breadcrumb'] = array(
			"Dataset"=>""
		);
    $var['css_files']       = $output->css_files;
    $var['js_files']        = $output->js_files;
    $var['output']          = $output->output;
    $this->load->view('main', $var);
  }
}
