<?php

/**
 * @copyright Frederic G. Østby
 * @license   http://www.makoframework.com/license
 */

namespace mako\validator\plugins;

use mako\session\Session;
use mako\validator\plugins\ValidatorPlugin;

/**
 * One time token validator plugin.
 *
 * @author Frederic G. Østby
 */
class OneTimeTokenValidator extends ValidatorPlugin
{
	/**
	 * Rule name.
	 *
	 * @var string
	 */
	protected $ruleName = 'one_time_token';

	/**
	 * Session instance.
	 *
	 * @var \mako\session\Session
	 */
	protected $session;

	/**
	 * Constructor.
	 *
	 * @access public
	 * @param \mako\session\Session $session Session instance
	 */
	public function __construct(Session $session)
	{
		$this->session = $session;
	}

	/**
	 * Validates a one time token.
	 *
	 * @access public
	 * @param  null|string $input Input
	 * @return bool
	 */
	public function validate(string $input = null): bool
	{
		return $this->session->validateOneTimeToken($input);
	}
}
