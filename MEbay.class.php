<?php

class MEbay extends Module {
	
	public $set;
	
	public function __construct( $set ) {
		
		$this->set	= $set;
		parent::__construct(  );
	}
	
}