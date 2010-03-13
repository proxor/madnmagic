<?php defined('SYSPATH') OR die('No direct access allowed.');
class Categories_Controller extends Controller {

	function index()
	{
		$cats = new Category_Model();
		$cats = $cats->find_all();
		foreach($cats as $c) {
			echo "<li>$c->title</li>";
		}	
	}

	public function edit($id = 0) {
		$post = new Validation($_POST);	
		$post->add_rules('title','required');
	
		$cat = new Category_Model($id);
		
		if($post->validate()) {
			$cat = new Category_Model($post->id);
			$cat->title = $post->title;
			$cat->description = $post->description;
			$cat->save();
			$cat->reload();
		}
		elseif($post->errors()) {
			print_r($post->errors());
		}
		print form::open(NULL,array('method' => 'post'),array('id' => $cat->id));
		print form::label('title','Название:')."<br/>"; 
		print form::input('title',$cat->title)."<br/>"; 
		print form::label('description','Описание:')."<br/>"; 
		print form::textarea('description',$cat->description)."<br/>"; 
		print form::submit('submit','Сохранить')."<br/>"; 
		print form::close();
	}

	function del($id = 0) {
		$cat = new Category_Model($id);
		if($cat)
			$cat->delete();
	}
	
} 
