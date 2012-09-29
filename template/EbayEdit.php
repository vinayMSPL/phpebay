<div class="<?php print @$val['set']['page_class']?>_but_edit_top">
	<input type="button" value="cancel" class="<?php print @$val['set']['page_class']?>_but" onclick="list_target( '<?php print LinkMgr::form_link( array( 'file' => $val['cfg']['plg'].'_list' ) )?>' );">
	<?php if ( 'add' == $val['mod'] ) { ?>
		<input type="button" name="save" value="add" class="<?php print @$val['set']['page_class']?>_but" onclick="form_submit( 'main_frm' )">
	<?php } ?>
	<?php if ( 'edit' == $val['mod'] ) { ?>
		<input type="button" name="save" value="save" class="<?php print @$val['set']['page_class']?>_but" onclick="form_submit( 'main_frm' )">
	<?php } ?>
</div>

<div class="box_main_item <?php print @$val['set']['page_class']?>_main_item">
	
	<?php print @$val['tab']?>
	
	<form id="main_frm" method="post" action="<?php print LinkMgr::form_link( array( 'file' => $val['cfg']['plg'].'_save' ) )?>" enctype="multipart/form-data">
		
		<input type="hidden" id="save_and_edit_item" name="save_and_edit" value="0">
		<input type="hidden" class="to_delete" name="<?php print $val['cfg']['id']?>" value="<?php print @$val['info'][ $val['cfg']['id'] ]?>">
		<input type="hidden" name="info[merchant]" value="<?php print Main::get_merch(  )?>">
		
		<div id="tab_gen" class="box_int" <?php if ( 'gen' != @$val['tab_sel'] ) { echo 'style="display:none;"'; } ?>>
			<?php print @$val['page']['tab_a']?>
		</div>
		<div id="tab_cfid" class="box_int" <?php if ( 'cfid' != @$val['tab_sel'] ) { echo 'style="display:none;"'; } ?>>
			<?php print @$val['page']['cfid']?>
		</div>
	</form>
</div>

<div class="<?php print @$val['set']['page_class']?>_but_edit_bot">
	<input type="button" value="cancel" class="<?php print @$val['set']['page_class']?>_but" onclick="list_target( '<?php print LinkMgr::form_link( array( 'file' => $val['cfg']['plg'].'_list' ) )?>' );">
	<?php if ( 'add' == $val['mod'] ) { ?>
		<input type="button" name="save" value="add" class="<?php print @$val['set']['page_class']?>_but" onclick="form_submit( 'main_frm' )">
	<?php } ?>
	<?php if ( 'edit' == $val['mod'] ) { ?>
		<input type="button" name="save" value="save" class="<?php print @$val['set']['page_class']?>_but" onclick="form_submit( 'main_frm' )">
	<?php } ?>
</div>