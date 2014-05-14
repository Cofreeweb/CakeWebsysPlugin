<?php

App::uses( 'StartupShell', 'Cofree.Console/Command');
    
class InstallShell extends StartupShell
{

/**
 * Nombre de los grupos por defecto creados en la instalación
 * Si se pasa un valor al array, éstos son los aros a los que tiene acceso ese grupo
 */
  public $groups = array(
      'Member'
  );
  
  public $languages = array(
      'es' => 'Español', 
  );
  
  public function app()
  {
    $this->setDatabase();
    $this->setBootstrap();
    $this->__configs();
    $this->__controller();
    $this->base();
    $this->schemaCreate( 'app');
    $this->cmd( 'bin/cake Websys.install init_configuration');
    $this->cmd( 'bin/cake Websys.install create_sections');
  }
  
  private function __controller()
  {
    $this->interactive = false;
    $this->Template->templatePaths ['default'] = App::pluginPath( 'Websys') . 'Console' .DS. 'Templates' .DS. 'default' .DS;
    $content = $this->Template->generate( 'controller', 'AppController');
    $filename = APP . 'Controller' .DS. 'AppController.php';
    $this->createFile( $filename, $content);
  }
  
  private function __configs()
  {
    // $this->interactive = false;
    $this->Template->templatePaths ['default'] = App::pluginPath( 'Websys') . 'Console' .DS. 'Templates' .DS. 'default' .DS;
    
    $site_title = $this->in( 'Indica un nombre para el web');
    $site_domain = $this->in( 'Indica un dominio para el web');
    $this->Template->set( compact( array(
        'site_title',
        'site_domain'
    )));
    
    $configs = array(
        'upload' => 'upload.php',
        'routes' => 'routes.php',
        'events' => 'events.php',
        'section' => 'section.php',
        'asset_compress' => 'asset_compress.ini',
        'management' => 'management.php',
        'core' => 'core.php'
    );
    
    foreach( $configs as $key => $file)
    {
      $content = $this->Template->generate( 'config', $key);

      $filename = APP . 'Config' .DS. $file;
      $this->createFile( $filename, $content);
    }
  }
  
  
  
/**
 * Crea una configuración por defecto
 * El theme por defecto será "developer"
 *
 * @return void
 */
  public function init_configuration()
  {
    $Configuration = ClassRegistry::init( 'Configuration.Configuration');
    
    $data = array(
        'site_title' => Configure::read( 'Config.siteName'),
        'site_description' => '',
    		'google_analytics' => '',
    		'enable_comments' => 1,
    		'comments_moderate' => 1,
    		'allow_public_comments' => 1,
    		'page_format_titles' => '',
    		'content_format_titles' => '',
    		'theme' => 'developer',
    );
    
    $Configuration->saveData( $data);
  }
  
  public function create_sections()
  {
    $Section = ClassRegistry::init( 'Section.Section');
    
    $data = array(
        'title' => 'Página de inicio',
        'title_menu' => 'Inicio',
        'plugin' => 'Entry',
        'menu' => 'main',
        'insert_menu' => 1,
        'is_homepage' => 1,
    );
    
    $Section->create();
    $Section->save( $data);
  }
  
}