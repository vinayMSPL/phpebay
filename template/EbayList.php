<div class="<?php print @$val['set']['page_class']?>_pag_top">
	<?php print @$val['pag']?>
</div>

<div class="<?php print @$val['set']['page_class']?>_but_list_top">
	<input type="button" value="add" class="<?php print @$val['set']['page_class']?>_but" onclick="document.location.href = '<?php print LinkMgr::form_link( array( 'file' => $val['cfg']['plg'].'_add' ) )?>';">
</div>

<div class="<?php print @$val['set']['page_class']?>_list_top">
	
	<div class="<?php print @$val['set']['page_class']?>_filter">
		<?php print @$val['filter']?>
	</div>
	
	<div class="page_count_box">
		total: <span class="page_count_text">&nbsp;&nbsp;<?php print @$val['num']?></span>
	</div>
	
	<table class="box_top_list" border="0" cellpadding="0" cellspacing="0">
		
		<tr>
			<td style="width:30px;"		class="tl">&nbsp;</td>
			<td style="width:50px;"		class="tl"><div <?php print @$val['sort']['id']['attr']?>><?php print @$val['cfg']['id']?></div></td>
			<td							class="tl"><div <?php print @$val['sort']['name']['attr']?>>{{#Name#}}</div></td>
			<td style="width:100px;"	class="tl"><div <?php print @$val['sort']['order']['attr']?>>{{#Order#}}</div></td>
			<td style="width:30px;"		class="tl">&nbsp;</td>
			<td style="width:40px;"		class="tl">&nbsp;Del</td>
		</tr>
	</table>
</div>

<div class="<?php print @$val['set']['page_class']?>_list_body">
	
	<table class="box_body_list" border="0" cellpadding="0" cellspacing="0">
		
		<?php if ( @$val['list'] ) { $c = 0; ?>
			
			<?php foreach ( $val['list'] as $unit ) { ?>
				
				<?php
					$link_edit		= LinkMgr::form_link( array( 'file' => $val['cfg']['plg'].'_edit', $val['cfg']['id'] => $unit[ $val['cfg']['id'] ] ) );
					$link_swap		= LinkMgr::form_link( array( 'file' => $val['cfg']['plg'].'_swap', $val['cfg']['id'] => $unit[ $val['cfg']['id'] ] ) );
					$link_clone		= LinkMgr::form_link( array( 'file' => $val['cfg']['plg'].'_clone', $val['cfg']['id'] => $unit[ $val['cfg']['id'] ] ) );
					$link_del		= LinkMgr::form_link( array( 'file' => $val['cfg']['plg'].'_del',  $val['cfg']['id'] => $unit[ $val['cfg']['id'] ] ) );
				?>
				
				<?php if ( $unit['active'] ) { $img_on = CfgGen::$cfg_img->get( 'IMG_ON' ); } else { $img_on = CfgGen::$cfg_img->get( 'IMG_OFF' ); } ?>
				
				<?php if ( ++$c%2 ) {	$cl	= 'row_odd';	}	else	{	$cl	= 'row_even';	} if ( @$_GET[ @$val['cfg']['id'] ] AND @$unit[ @$val['cfg']['id'] ] == $_GET[ @$val['cfg']['id'] ] ) { $cl = 'row_last'; } ?>
				<tr class="<?php print $cl?>" onmouseover="body_row_over( this );" onmouseout="body_row_out( this, '<?php print $cl?>' );">
					<td style="width:30px;"		class="bl"><a href="<?php print $link_swap?>" class="link_row"><img src="<?php print @$img_on?>" class="img_mgr"></a></td>
					<td style="width:50px;"		class="bl"><a href="<?php print $link_edit?>" class="link_row"><?php print @$unit[ @$val['cfg']['id'] ]?></a></td>
					<td							class="bl">
						<div class="quick_edit_out" onmouseover="box_quick_edit_over( this );" onmouseout="box_quick_edit_out( this );" onclick="box_quick_edit_click( this, '<?php print @$val['cfg']['tbl']?>', 'name', '<?php print @$val['cfg']['id']?>', '<?php print @$unit[$val['cfg']['id']]?>' );"><?php print ( @$unit['name'] ) ? $unit['name'] : "&nbsp;"; ?></div>
					</td>
					<td style="width:100px;"	class="bl">
						<div class="quick_edit_out" onmouseover="box_quick_edit_over( this );" onmouseout="box_quick_edit_out( this );" onclick="box_quick_edit_click( this, '<?php print @$val['cfg']['tbl']?>', 'order', '<?php print @$val['cfg']['id']?>', '<?php print @$unit[$val['cfg']['id']]?>' );"><?php print ( @$unit['order'] ) ? $unit['order'] : "&nbsp;"; ?></div>
					</td>
					<td style="width:30px;"		class="bl"><a href="<?php print $link_clone?>" class="link_row"><img src="<?php print CfgGen::$cfg_img->get( 'IMG_CLONE' )?>" class="img_mgr"></a></td>
					<td style="width:40px;"		class="bl" onclick="del_target( '<?php print $link_del?>', '<?php print @$unit['name']?>' );"><img src="<?php print CfgGen::$cfg_img->get( 'IMG_DEL' )?>" class="img_mgr"></td>
				</tr>
			<?php } ?>
		<?php }
		else { ?>
			
			<tr class="empty_row" valign="middle">
				<td align="center"><?php print @$val['no_unit_warning']?></td>
			</tr>
		<?php } ?>
	</table>
	<div class="<?php print @$val['set']['page_class']?>_pag_bot">
		<?php print @$val['pag']?>
	</div>
</div>

<div class="<?php print @$val['set']['page_class']?>_but_list_bot">
	<input type="button" value="add" class="<?php print @$val['set']['page_class']?>_but"  onclick="document.location.href = '<?php print LinkMgr::form_link( array( 'file' => $val['cfg']['plg'].'_add' ) )?>';">
</div>