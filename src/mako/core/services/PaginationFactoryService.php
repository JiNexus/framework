<?php

/**
 * @copyright  Frederic G. Østby
 * @license    http://www.makoframework.com/license
 */

namespace mako\core\services;

use \mako\pagination\PaginationFactory;

/**
 * Pagination factory service.
 *
 * @author  Frederic G. Østby
 */

class PaginationFactoryService extends \mako\core\services\Service
{
	//---------------------------------------------
	// Class properties
	//---------------------------------------------

	// Nothing here

	//---------------------------------------------
	// Class constructor, destructor etc ...
	//---------------------------------------------

	// Nothing here

	//---------------------------------------------
	// Class methods
	//---------------------------------------------
	
	/**
	 * Registers the service.
	 * 
	 * @access  public
	 */

	public function register()
	{
		$this->application->registerSingleton(['mako\pagination\PaginationFactory', 'paginationfactory'], function($app)
		{
			return new PaginationFactory($app->get('request'), $app->get('urlbuilder'), $app->get('viewfactory'), $app->getConfig()->get('pagination'));
		});
	}
}

