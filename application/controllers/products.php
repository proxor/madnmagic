<?php defined('SYSPATH') OR die('No direct access allowed.');
class Products_Controller extends Controller {

	function index()
	{
		$cats = new Category_Model();
		$cats = $cats->find_all();
		foreach($cats as $c) {
			echo "<li>$c->title</li>";
		}	
	}

	public function edit($id = 0) {
		print form::open(NULL,array('method' => 'post'));
		print form::label('title','Название'); 
		print form::text('title'); 
		print form::label('title','Описание'); 
		print form::close();
	}

	function del() {
		echo "Error: not yet implemented";
	}
	
} 
