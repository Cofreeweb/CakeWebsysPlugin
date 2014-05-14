<?php

App::uses('AppShell', 'Console/Command');
App::uses('File', 'Utility');
App::uses('Folder', 'Utility');
App::uses('CakeSchema', 'Model');


class ThemedShell extends AppShell 
{
    
/**
 * El path de los themed
 *
 * @var string
 */
  private $__themePath = 'View/Themed/';
  
/**
 * Los paths de los ficheros a copiar para la creación/actualización de un theme
 *
 * @var array
 */
  public $paths = array(
      'Blog' => array(
          'Posts/index',
          'Posts/view',
      ),
      'Entry' => array(
          'Blocks/row',
          'Blocks/type',
          'Blocks/types',
          'Entries/_row',
          'Entries/view'
      )
  );
  
/**
 * Listado de menus disponibles para crear un theme
 *
 * @var array
 */
  public $menus = array(
      'main',
      'bottom',
  );
  
/**
 * Listado de plugins disponibles para crear un theme
 *
 * @var array
 */
  public $plugins = array(
      'Blog',
      'Entry'
  );
  
/**
 * Crea un theme
 *
 * @return void
 */
  public function create()
  {
    $name = $this->in( "Indica un nombre (en minúsculas)");
    $theme_path = APP . $this->__themePath . $name .DS;
    
    // Si el theme existe, salimos
    if( is_dir( $theme_path))
    {
      $this->out( "El theme ya existe");
      die();
    }
    
    // Crea el fichero de configuración de json
    $this->__configJson( $theme_path, $name);    
    
    // El layout por defecto
    $layout = App::pluginPath( 'Websys') . 'Console' .DS. 'Templates' .DS. 'default' .DS. 'view' .DS. 'default.ctp';
    $this->createFile( $theme_path .'Layouts' .DS. 'default.ctp', file_get_contents( $layout));
    
    $Folder = new Folder;
    
    // Crea los ficheros indicados en $this->paths
    // Si el path es un folder, entonces tomará todos los ficheros de ese folder
    foreach( $this->paths as $plugin => $paths)
    {
      foreach( $paths as $path)
      {
        $filepath = APP . 'Plugin' .DS. $plugin .DS. 'View' .DS. $path;

        if( is_dir( $filepath))
        {
          $files = $Folder->tree( $filepath);
          
          foreach( $files [1] as $file)
          {
            $content = file_get_contents( $file);
            $dest = $theme_path . 'Plugin' .DS. $plugin .DS. str_replace( APP . 'Plugin' .DS. $plugin .DS. 'View' .DS, '', $file);
            $this->createFile( $dest, $content);
          }
        }
        else
        {
          $content = file_get_contents( $filepath .'.ctp');
          $this->createFile( $theme_path . 'Plugin' .DS. $plugin .DS. $path . '.ctp', $content);
        }
      }
    }
    
    
    
  }
  
/**
 * Crea el fichero de configuración JSON
 *
 * @param string $path 
 * @param string $name
 * @return void
 */
  private function __configJson( $theme_path, $name)
  {
    $json = array(
        'name' => ucfirst( $name),
        'plugins' => array(),
        'menus' => array()
    );
    
    $this->out( '_______ MENUS _______');
    
    foreach( $this->menus as $menu)
    {
      $accept = $this->in( '¿Vas a usar el menú '. $menu .'?', array( 's', 'n'), 's');
      
      if( $accept == 's')
      {
        $json ['menus'][] = $menu;
      }
    }
    
    foreach( $this->plugins as $plugin)
    {
      $accept = $this->in( '¿Vas a usar el plugin '. $plugin .'?', array( 's', 'n'), 's');
      
      if( $accept == 's')
      {
        $json ['plugins'][] = $plugin;
      }
    }
    
    $this->createFile( $theme_path . 'info.json', json_encode( $json));
  }
}
