<table border="0" cellpadding="0" cellspacing="0" style="margin-left:10px; margin-top:20px;">
	
	<tr class="row_text" valign="top">
		<td class="view_title">
			{{#Name#}}:
		</td>
		<td class="view_box">
			<input type="text" name="info[name]" class="view_text {{:Name:}} to_rename" value="<?php print @$val['info']['name']?>">
		</td>
	</tr>
	
	<tr class="row_text" valign="top">
		<td class="view_title">
			{{#Order#}}:
		</td>
		<td class="view_box">
			<input type="text" name="info[order]" class="view_text {{:Order:}}" value="<?php print @$val['info']['order']?>">
		</td>
	</tr>
	
	<tr class="row_text" valign="top">
		<td class="view_title">
			{{#Active#}}:
		</td>
		<td class="view_box">
			<input type="hidden" name="info[active]" value="0">
			<input type="checkbox" name="info[active]" value="1" <?php if ( @$val['info']['active'] ) { ?>checked="checked"<?php } ?>>
		</td>
	</tr>
	
</table>