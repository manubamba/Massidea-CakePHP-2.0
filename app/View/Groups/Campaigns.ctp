<?php 
echo $this->Html->script('datatables'.DS.'jquery.dataTables.min',array('inline'=>false));
echo $this->Html->script('datatables'.DS.'datatables_custom',array('inline'=>false));
echo $this->Html->script('datatables'.DS.'tabletools'.DS.'js'.DS.'TableTools.min',array('inline'=>false));
echo $this->Html->script('datatables'.DS.'tabletools'.DS.'js'.DS.'ZeroClipboard',array('inline'=>false));
echo $this->Html->css(array(
	'..'.DS.'js'.DS.'datatables'.DS.'tabletools'.DS.'css'.DS.'TableTools_JUI'
		),'stylesheet', array('inline' => false ) );
 ?>
 <input type="hidden" id="group_id" value=<?php echo $groupId;?>>
 <table id="linkedGroups_table" width="100%" class="fixed-table display">
	<thead>
		<tr>
			
			<th >Id</th>
			<th width="4%" class="checkbox_header"><input type="checkbox"/></th>
			<th width="22%">
				<p class="name"><?php echo __('Name') ?></p>
				
			</th>			
		</tr>
	</thead>
	<tbody>

	</tbody>
	<tfoot>
	<tr>			
			<th >Id</th>
			<th width="4%" class="checkbox_header"><input type="checkbox"/></th>
			<th width="22%">
				<span class="title_from"><?php echo __('Name') ?></span>				
			</th>
		</tr>
	</tfoot>
</table>