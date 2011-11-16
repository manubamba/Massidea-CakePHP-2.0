<?php
echo $this->Html->script(strtolower($this->name).DS.$this->action,array('inline' => false));


/*
 $this->TinyMce->editor(array(
'theme' => 'advanced',
'mode' => 'exact',
'elements' => 'NodeBody',
'theme_advanced_toolbar_location' => "top",
'theme_advanced_disable' => "charmap,sup,sub,code,help,cleanup,image,anchor,unlink,link,removeformat,visualaid,hr"
));
*/

/**
 * Here we set content specific field texts
 *
 */
$challenge = __('(Answer what, why, who, when and where questions)',true);
$idea = __('(What is the idea and why it is important)',true);
$vision = __('(What is the vision of the future and why it is important)',true);
$body = '';
?>

<div id="form_content_realcontent">


<?php if($content_type === 'challenge'): $body = $challenge; ?>

	<h2 class="light-gray border-problem">

	<?php echo __('Share your challenge') ?></h2>
	<p>

	<?php echo __('Challenge is personal, business or social related problem, need, situation or observation. It describes the current status of affairs and recognizes the need to resolve the matter.') ?>
	</p>
	<p>

	<?php echo __('Write to a person who is not familiar with the topic.') ?></p>
	<p>

	<?php echo __('Keep your focus on challenge and not related solutions or visions. You can publish those one a separate document and link them later on to this challenge.') ?></p>
	
	
	
	

<?php elseif($content_type === 'idea'): $body = $idea; ?>

	<h2 class="light-gray border-idea"><?php echo __('Share your new idea') ?></h2>
	<p><?php echo __('Ideas are solutions to today’s challenges and visions of the future related opportunities and threats. Idea can suggest small incremental improvement or radical revolutionary change in thinking, products, processes or organization.') ?> </p>
	<p><?php echo __('Write to a person who is not familiar with the topic.') ?> </p>
	<p><?php echo __('Keep your focus on idea and not related challenges or visions. You can publish those on a separate document and link them later on to this idea.') ?></p>

<?php elseif($content_type === 'vision'): $body = $vision; ?>

	<h2 class="light-gray border-finfo"><?php echo __('Share your vision of the future') ?></h2>
	<p><?php echo __('Vision concern the long-term future which is usually at least 10 years away. It can be future scenario, trend or anti-trend, which is most likely to be realized. It can also describe an alternative unlikely future based on seed of change or weak signal, which might significantly change all our life if realized.') ?></p>
	<p><?php echo __('Write to a person who is not familiar with the topic.') ?></p>
	<p><?php echo __('Keep your focus on vision and not related challenges or ideas. You can publish those on a separate document and link them later on to this vision.') ?></p>

<?php endif; ?>
</div>



<?php echo $this->Form->create('Content', array('type' => 'file',
						 				'url' => array('controller' => 'contents', 'action' => 'add', $content_type),
						 				'inputDefaults' => array('label' => false,
																'div' => false)
));
?>

<div id="content_languages" class="row field">


<?php echo $this->Form->input('language_id', array('type' => 'select',
											 'selected' => "en",
											 'label' => __('Select language',true),
											 'options' => $language_list, )); ?>

</div>
<div class="clear"></div>

<div id="content_title" class="row">
	<div class="field-label">
		<label for="NodeTitle"><?php echo __('Header') ?> </label> <small
			class="right"><?php echo __('(Explain in one sentence the whole story)') ?>
		</small>
	</div>
	<div class="field">


	<?php echo $this->Form->input('title', array('error' 	=> array('wrap' => 'div', 'class' => 'error', true))); ?>
	</div>
	<div class="limit bad">

	<?php echo __('required') ?></div>
</div>
<div class="clear"></div>

<div id="content_lead" class="row">
	<div class="field-label">
		<label for="NodeLead"><?php echo __('Lead chapter') ?> </label> <small
			class="right"><?php echo __('(This text is shown in search result lists)') ?>
		</small>
	</div>
	<div class="field">


	<?php echo $this->Form->input('lead', array('type' => 'textarea',	'error' => array('wrap' => 'div', 'class' => 'error', true))); ?>
	</div>
	<div class="limit bad">

	<?php echo __('required') ?></div>
</div>
<div class="clear"></div>




<?php if($content_type === 'challenge'): ?>

<div id="content_research" class="row">
	<div class="field-label">
		<label for="SpecificResearch"><?php echo __('Research question') ?> </label>
		<small class="right"><?php echo __('(The single question you want to get an answer)') ?>
		</small>
	</div>
	<div class="field">


	<?php echo $this->Form->input('Specific.research', array('error' => array('wrap' => 'div', 'class' => 'error', true))); ?>
	</div>
	<div class="limit bad">

	<?php echo __('required') ?></div>
</div>
<div class="clear"></div>




<?php elseif($content_type === 'idea'): ?>

<div id="content_solution" class="row">
	<div class="field-label">
		<label for="SpecificSolution"><?php echo __('Solution') ?> </label>
	</div>
	<div class="field">


	<?php echo $this->Form->input('Specific.solution', array('error' => array('wrap' => 'div', 'class' => 'error', true))); ?>
	</div>
	<div class="limit bad">

	<?php echo __('required') ?></div>
</div>
<div class="clear"></div>



<?php elseif($content_type === 'vision'): ?>

<div id="content_opportunity" class="row">
	<div class="field-label">
		<label for="SpecificOpportunity"><?php echo __('Opportunity') ?> </label> <small
			class="right"><?php echo __('(The most important if future scenario becomes realized)') ?>
		</small>
	</div>
	<div class="field">


	<?php echo $this->Form->input('Specific.opportunity', array('error' => array('wrap' => 'div', 'class' => 'error', true))); ?>
	</div>
	<div class="limit bad">

	<?php echo __('required') ?></div>
</div>
<div class="clear"></div>

<div id="content_threat" class="row">
	<div class="field-label">
		<label for="SpecificThreat"><?php echo __('Threat') ?> </label> <small
			class="right"><?php echo __('(The most important if future scenario becomes realized)') ?>
		</small>
	</div>
	<div class="field">


	<?php echo $this->Form->input('Specific.threat', array('error' => array('wrap' => 'div', 'class' => 'error', true))); ?>
	</div>
	<div class="limit bad">

	<?php echo __('required') ?></div>
</div>
<div class="clear"></div>


<?php endif;?>

<div id="content_tags" class="row">
	<div class="field-label">
		<label for="TagsTags"><?php echo __('Keywords, Tags') ?> </label> <small
			class="right"><?php echo __('(Use commas to separate tags)') ?> </small>
	</div>
	<div class="field">


	<?php echo $this->Form->input('Tags.tags', array('error' => array('wrap' => 'div', 'class' => 'error', true))); ?>
	</div>
	<div class="limit bad">

	<?php echo __('required') ?></div>
</div>
<div class="clear"></div>

<div id="content_companies" class="row">
	<div class="field-label">
		<label for="CompaniesCompanies"><?php echo __('Related companies and organizations') ?>
		</label> <small class="right"><?php echo __('(Use commas to separate)') ?>
		</small>
	</div>
	<div class="field">


	<?php echo $this->Form->input('Companies.companies', array('error' => array('wrap' => 'div', 'class' => 'error', true))); ?>
	</div>
	<div class="limit bad">

	<?php echo __('required') ?></div>
</div>
<div class="clear"></div>

<div id="content_body" class="row">
	<div class="field-label">
		<label for="NodeBody"><?php echo __('Body text') ?> </label> <small
			class="right"><?php echo $body; ?> </small>
	</div>
	<div class="field">


	<?php echo $this->Form->input('body', array('type' => 'textarea',	'rows' => '20' , 'error' => array('wrap' => 'div', 'class' => 'error', true))); ?>
	</div>
	<div class="limit bad">

	<?php echo __('required') ?></div>
</div>
<div class="clear"></div>


<div id="content_references" class="row">
	<div class="field-label">
		<label for="NodeReferences"><?php echo __('References') ?> </label> <small
			class="right"><?php echo __('(Youtube video url references are embedded)') ?>
		</small>
	</div>
	<div class="field">


	<?php echo $this->Form->input('references', array('type' => 'textarea', 'error' => array('wrap' => 'div', 'class' => 'error', true))); ?>
	</div>
	<div class="limit bad">

	<?php echo __('required') ?></div>
</div>
<div class="clear"></div>




<?php echo $this->Form->input('published', array('type' 	=> 'radio',
										'legend' 	=> __('Do you want to publish your content now?',true),
										'label'		=> true,
										'div'		=> array('id' => 'content_publish', 'class' => 'row'),
										'options'	=> array('1' => __('Yes',true), '0' => __('No, I want to save it for later editing',true)),
										'value'		=> '1',
										'after'		=> '</div><div class="clear">'							
));
?>

<?php echo $this->Form->end(array('div' => array('class' => 'row',
											'id' => 'content_send'),
							'value' => 'Send',
							'label' => __('Send',true),
							'after'	=> '</div><div class="clear">'
));
 ?>







