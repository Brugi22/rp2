<?php 

class _404Controller extends BaseController
{
	public function index() 
	{
        $this->registry->template->show( '404_index' );
	}
}; 
