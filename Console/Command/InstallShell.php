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
  
/**
 * El título del sitio web
 * Se usará para la configuración por defecto en la base de datos
 *
 * @var string
 */
  public $siteTitle;
  
/**
 * El dominio del sitio
 * Solo se usa para colocarlo en el fichero core.php (no va en git)
 *
 * @var string
 */
  public $siteDomain;
  
  
/**
 * Realiza la instalación
 *
 * @return void
 */
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
    
    $this->out( '=====================================');
    $this->out( '¡BIEN! INSTALACIÓN FINALIZADA');
    $this->out( '=====================================');
    $this->out( '');
    $this->out( 'Puedes acceder al website en http://'. $this->siteDomain);
    $this->out( 'Entra como administrador en http://'. $this->siteDomain . '/admin/users/login');
    $this->out( '');
    $this->out( '¡Feliz trabajo!');
  }
  
  
/**
 * General el fichero AppController.php tomándolo de la plantilla
 *
 * @return void
 */
  private function __controller()
  {
    $this->interactive = false;
    $this->header( 'Creando AppController');
    $this->interactive = false;
    $this->Template->templatePaths ['default'] = App::pluginPath( 'Websys') . 'Console' .DS. 'Templates' .DS. 'default' .DS;
    $content = $this->Template->generate( 'controller', 'AppController');
    $filename = APP . 'Controller' .DS. 'AppController.php';
    $this->createFile( $filename, $content);
    $this->interactive = true;
  }


/**
 * Genera los ficheros de configuración
 * uploads.php
 * routes.php
 * events.php
 * section.php
 * asset_compress.ini
 * management.php
 * core.php
 *
 * @return void
 */
  private function __configs()
  {
    $this->interactive = false;
    $this->header( 'Creando ficheros de configuración');
    // $this->interactive = false;
    $this->Template->templatePaths ['default'] = App::pluginPath( 'Websys') . 'Console' .DS. 'Templates' .DS. 'default' .DS;
    
    $this->siteTitle = $this->in( 'Indica un nombre para el web');
    $this->siteDomain = $this->in( 'Indica un dominio para el web');
    
    $this->Template->set( array(
        'site_title' => $this->siteTitle,
        'site_domain' => $this->siteDomain
    ));
    
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
    $this->interactive = true;
  }

  
/**
 * Crea una configuración por defecto
 * El theme por defecto será "developer"
 *
 * @return void
 */
  public function init_configuration()
  {
    $this->header( 'Creando configuración del website');
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
  
  
/**
 * Crea las secciones por defecto
 *
 * @return void
 */
  public function create_sections()
  {
    $this->header( 'Creando secciones por defecto');
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