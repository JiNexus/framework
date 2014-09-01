<?php

/**
 * @copyright  Frederic G. Østby
 * @license    http://www.makoframework.com/license
 */

namespace mako\application\services;

use \mako\view\ViewFactory;
use \mako\view\renderers\Template;

/**
 * View factory service.
 *
 * @author  Frederic G. Østby
 */

class ViewFactoryService extends \mako\application\services\Service
{
	/**
	 * Registers the service.
	 * 
	 * @access  public
	 */

	public function register()
	{
		$this->container->registerSingleton(['mako\view\ViewFactory', 'view'], function($container)
		{
			$app = $container->get('app');

			$applicationPath = $app->getPath();

			$fileSystem = $container->get('fileSystem');

			// Create factory instance

			$factory = new ViewFactory($fileSystem, $applicationPath . '/views', $app->getCharset());

			// Register template renderer

			$factory->registerRenderer('.tpl.php', function() use ($applicationPath, $fileSystem)
			{
				return new Template($fileSystem, $applicationPath . '/storage/cache/views');
			});

			// Return factory instance

			return $factory;
		});
	}
}