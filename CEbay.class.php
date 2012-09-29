<?php

class CEbay extends Ctrl {
	
	public $cfg;
	public $set;
	public $ModObj;
	
	public function __construct( $set ) {
		
		$this->set		= $set;
		$this->cfg		= $this->get_plg_cfg(  );
		$this->ModObj	= new $this->cfg['mod']( $set );
		
		parent::__construct( $this->ModObj, $set, $this->get_plg_cfg(  ), $this->get_sort_field(  ), $this->get_filter(  ) );
	}
	
	public function list_item(  ) {
		
		
	}
	
	public function additem_item(  ) {
		
		ob_start(  );
		
		require_once('class/get-common/keys.php');
		require_once('class/get-common/eBaySession.php');
		
		include_once 'class/AddItem.php';
				
//		print "add item";
		
		return ob_get_clean(  );
	}
	
	public function getofficialtime_item(  ) {
		
		ob_start(  );
		
		require_once 'class/get-common/keys.php';
		require_once 'class/get-common/eBaySession.php';		
		
		include_once 'class/GeteBayOfficialTime.php';
	
		return ob_get_clean(  );
	}
	
	public function getcategories_item(  ) {
		
		ob_start(  );
		
		require_once 'class/get-common/keys.php';
		require_once 'class/get-common/eBaySession.php';		
		
		include_once 'class/GetCategories.php';

		return ob_get_clean(  );
	}
	public function enditem_item(  ) {
		
		ob_start(  );
		
		require_once 'class/get-common/keys.php';
		require_once 'class/get-common/eBaySession.php';		
		
		include_once 'class/EndItem.php';
		return ob_get_clean(  );
	}
	
		public function geteBayDetails_item(  ) {
		
		ob_start(  );
		
		require_once 'class/get-common/keys.php';
		require_once 'class/get-common/eBaySession.php';		
		
		include_once 'class/GeteBayDetails.php';
		return ob_get_clean(  );
	}
		public function getCategorySpecifics_item(  ) {
		
		ob_start(  );
		
		require_once 'class/get-common/keys.php';
		require_once 'class/get-common/eBaySession.php';		
		
		include_once 'class/GetCategorySpecifics.php';
	
		return ob_get_clean(  );
	}

	public function geteBayFeatures_item(  ) {
		
		ob_start(  );
		
		require_once 'class/get-common/keys.php';
		require_once 'class/get-common/eBaySession.php';		
		
		include_once 'class/GeteBayFeatures.php';

		return ob_get_clean(  );
	}
	
	public function reviseItemHtmlDescription_item(  ) {
		
		ob_start(  );
		
		require_once 'class/get-common/keys.php';
		require_once 'class/get-common/eBaySession.php';		
		
		include_once 'class/ReviseItem-HtmlDescription.php';
		
		return ob_get_clean(  );
	}
	
	public function reviseItemPrice_item(  ) {
		
		ob_start(  );
		
		require_once 'class/get-common/keys.php';
		require_once 'class/get-common/eBaySession.php';		
		
		include_once 'class/ReviseItem-Price.php';	
		return ob_get_clean(  );
	}
	
	public function verifyAddItem_item(  ) {
		
		ob_start(  );
		
		require_once 'class/get-common/keys.php';
		require_once 'class/get-common/eBaySession.php';		
		
		include_once 'class/VerifyAddItem.php';

		return ob_get_clean(  );
	}
	
	public function get_plg_cfg(  ) {
		
		return array( 'plg' => 'ebay', 'tpl' => 'Ebay', 'tbl' => '', 'mod' => 'MEbay', 'id' => 'id', 'csv' => 1, 'act_as' => 1, 'name' => 'Ebay MANAGER', 'tab' => 'Ebay Info' );
	}
	
	public function get_sort_field(  ) {
		
		return array( 'id' => '`tbl`.`id`', 'name' => '`tbl`.`name`', 'order' => '`tbl`.`order`' );
	}
}