<?php

/**
 * @copyright  Frederic G. Østby
 * @license    http://www.makoframework.com/license
 */

namespace mako\reactor\io;

/**
 * Stdout.
 *
 * @author  Frederic G. Østby
 */

class StdOut extends \mako\reactor\io\StreamOutput
{
	//---------------------------------------------
	// Class properties
	//---------------------------------------------

	// Nothing here

	//---------------------------------------------
	// Class constructor, destructor etc ...
	//---------------------------------------------

	/**
	 * Constructor.
	 * 
	 * @access  public
	 */

	public function __construct()
	{
		parent::__construct(fopen('php://stdout', 'w'));
	}

	//---------------------------------------------
	// Class methods
	//---------------------------------------------

	// Nothing here
}

