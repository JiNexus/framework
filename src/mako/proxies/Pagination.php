<?php

/**
 * @copyright  Frederic G. Østby
 * @license    http://www.makoframework.com/license
 */

namespace mako\proxies;

use \mako\core\Application;

/**
 * Pagination factory proxy.
 *
 * @author  Frederic G. Østby
 */

class Pagination extends \mako\proxies\Proxy
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
	 * Returns instance of the class we're proxying.
	 * 
	 * @access  protected
	 * @return  \mako\pagination\PaginationFactory
	 */

	protected static function instance()
	{
		return Application::instance()->get('paginationfactory');
	}
}

