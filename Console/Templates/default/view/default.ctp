<!DOCTYPE html>
<html>
<head>
	<?= $this->Html->charset(); ?>
	<title> <?= Configure::read( 'Configuration.site_title') ?></title>
	<?= $this->Html->meta('icon') ?>
  <?= $this->fetch('meta') ?>
  <?= $this->fetch('script') ?>
	
	<?= $this->Html->css( array(
	    '/management/css/bootstrap.min',
	    'style',
	    'font-awesome.min',
	    '/management/css/inline',
	    '/entry/css/flexslider.css'
	)) ?>
	
	<?= $this->fetch( 'css') ?>
	
	<?= $this->Html->script( array(
	  '/management/js/jquery-1.10.2.min.js',
    '/angular/angular.min.js',
    '/angular/components/angular-route.min.js',
    '/angular/components/angular-sanitize.js'
	)) ?>
  <link rel="stylesheet" type="text/css" href="/section/css/angular/ng-slider.round.css" />
  <link rel="stylesheet" type="text/css" href="/section/css/angular/ng-slider.css" />
</head>
<body <?= $this->Auth->user() ? 'ng-app="adminApp"' : ''  ?>>
  <?= $this->Inline->toolbar() ?>
  <div id="wrapper">
    <header id="pageHeader" class="container clearfix noBorder">
      <div id="logo">
        <?= $this->Html->link( Configure::read( 'Configuration.site_title'), '/') ?>
      </div>
      <nav id="mainNav">
			  <ul class="menu">
			    <?= $this->Section->nav( 'main') ?>
			  </ul>
			</nav>
    </header>
    
    <div id="mainContent" class="container" role="main">
      <?= $this->Session->flash() ?>
      
			<?= $this->fetch('content') ?>
    </div>
  </div>
  
	
	<footer class="footer">

	</footer>
	
	<?= $this->fetch( 'script') ?>
	<?= $this->Html->script( array(
	  '/entry/js/jquery.flexslider-min'
	)) ?>
	<?= $this->fetch( 'scriptBottom') ?>
	<?= $this->fetch( 'css') ?>
	
</body>
</html>
