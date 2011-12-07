
<div id="memebers_dialog" class="hidden">
	<div id="members_tabs">
	<?php if($userRole == 'Admin') : ?>
		<ul>
			<li><a href="#current">Current</a></li>
			<li id="waiting_link"><a href="#waiting">Waiting</a></li>

		</ul>
		<?php endif;?>
		<div id="current">
			<input type="hidden" id="group_id"
				value=<?php echo $group['Group']['id'];?>>
			<table id="members_table" width="100%" class="fixed-table display">
				<thead>
					<tr>
						<th>Id</th>
						<th><?php echo __('Name') ?></th>
					</tr>
				</thead>
				<tbody>

				</tbody>
				<tfoot>
					<tr>
						<th>Id</th>
						<th><?php echo __('Name') ?></th>
					</tr>
				</tfoot>
			</table>
		</div>
		<?php if($userRole == 'Admin') : ?>
		<div id="waiting">
		<table id="waiting_members_table" width="100%" class="fixed-table display">
				<thead>
					<tr>
						<th>Id</th>
						<th><?php echo __('Name') ?></th>
					</tr>
				</thead>
				<tbody>

				</tbody>
				<tfoot>
					<tr>
						<th>Id</th>
						<th><?php echo __('Name') ?></th>
					</tr>
				</tfoot>
			</table>
		</div>		
		<?php endif;?>
	</div>
</div>
