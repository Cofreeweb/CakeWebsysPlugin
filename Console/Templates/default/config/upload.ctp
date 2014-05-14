<?= '<?php' ?>

$config ['Upload'] = array(
    'gallery' => array(
        'type' => 'image',
        'template' => 'image',
        'thumbail' => 'med',
        'config' => array(
            'thumbnailMethod' => 'php',
    				'path' => '{ROOT}webroot{DS}files{DS}',
    				'pathMethod' => 'random',
    				'thumbnailQuality' => 100,
    				'thumbnailSizes' => array(
            		'min' => '50w',
                'thm' => '100w',
                'big' => '295w',
            ),
        )
    ),
    'document' => array(
        'type' => 'doc',
        'template' => 'doc',
    ),
);
