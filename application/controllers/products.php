<?php defined('SYSPATH') OR die('No direct access allowed.');
class Products_Controller extends Controller {

	function index()
	{
		$cats = new Category_Model();
		$cats = $cats->find_all();
		
		echo "<ul>";
		foreach($cats as $c) {
			echo "<li>$c->title";
			if(count($c->products)) {
				echo "<ul>";
				foreach($c->products as $p) {
					echo "<li>$p->title</li>";
				}
				echo "</ul>";
			}
			echo "</li>";
		}	
		echo "</ul>";
	}

	public function edit($id = 0) {
		$post = new Validation($_POST);	
		$post->add_rules('title','required');
		#$post->add_rules('category','required');
	
		$product = new Product_Model($id);
		
		if($post->validate()) {
			$product = new Product_Model($post->id);
			$product->title = $post->title;
			$product->description = $post->description;
			$product->category_id = $post->category;
			$product->save();
			$product->reload();
		}
		elseif($post->errors()) {
			print_r($post->errors());
		}

		$cats = new Category_Model();
		$cats = $cats->find_all();
		$cats_select = array();
		foreach($cats as $c) {
			$cats_select[$c->id] = $c->title;
		}	

		print form::open(NULL,array('method' => 'post'),array('id' => $product->id));
		print form::label('category','Категория:')."<br/>"; 
		print form::dropdown('category',$cats_select,$product->category)."<br/>"; 
		print form::label('title','Название:')."<br/>"; 
		print form::input('title',$product->title)."<br/>"; 
		print form::label('description','Описание:')."<br/>"; 
		print form::textarea('description',$product->description)."<br/>"; 
		print form::submit('submit','Сохранить')."<br/>"; 
		print form::close();
	}

	function del($id = 0) {
		$product = new Product_Model($id);
		if($product)
			$product->delete();
	}
	
} 
