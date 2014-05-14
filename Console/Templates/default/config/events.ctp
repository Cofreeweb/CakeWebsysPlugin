<?= '<?php' ?>

$config = array(
  'EventHandlers' => array(
	  'AppEvents' => array(
		  'options' => array(
			  'priority' => 1,
			),
		),
		'Blog.BlogEvents' => array(
		  'options' => array(
			  'priority' => 1,
			),
		),
		'Entry.EntryEvents' => array(
		  'options' => array(
			  'priority' => 1,
			),
		),
	),
);
