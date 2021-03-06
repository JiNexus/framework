<?php

/**
 * @copyright Frederic G. Østby
 * @license   http://www.makoframework.com/license
 */

namespace mako\gatekeeper\repositories\group;

use InvalidArgumentException;

use mako\gatekeeper\repositories\group\GroupRepositoryInterface;

/**
 * Group repository.
 *
 * @author Frederic G. Østby
 *
 * @method \mako\gatekeeper\entities\group\Group      createGroup(array $properties = [])
 * @method \mako\gatekeeper\entities\group\Group|bool getByIdentifier($identifier)
 */
class GroupRepository implements GroupRepositoryInterface
{
	/**
	 * Model name.
	 *
	 * @var string
	 */
	protected $model;

	/**
	 * Group identifier.
	 *
	 * @var string
	 */
	protected $identifier = 'name';

	/**
	 * Constructor.
	 *
	 * @access public
	 * @param string $model Model name
	 */
	public function __construct(string $model)
	{
		$this->model = $model;
	}

	/**
	 * Returns a model instance.
	 *
	 * @access protected
	 * @return \mako\database\midgard\ORM
	 */
	protected function getModel()
	{
		$model = $this->model;

		return new $model;
	}

	/**
	 * {@inheritdoc}
	 */
	public function createGroup(array $properties = [])
	{
		$group = $this->getModel();

		foreach($properties as $property => $value)
		{
			$group->$property = $value;
		}

		$group->save();

		return $group;
	}

	/**
	 * Sets the user identifier.
	 *
	 * @access public
	 * @param string $identifier User identifier
	 */
	public function setIdentifier(string $identifier)
	{
		if(!in_array($identifier, ['name', 'id']))
		{
			throw new InvalidArgumentException(vsprintf("%s(): Invalid identifier [ %s ].", [__METHOD__, $identifier]));
		}

		$this->identifier = $identifier;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getByIdentifier($identifier)
	{
		switch($this->identifier)
		{
			case 'name':
				return $this->getByName($identifier);
			case 'id':
				return $this->getById($identifier);
		}
	}

	/**
	 * Fetches a group by its name.
	 *
	 * @access public
	 * @param  string                                     $name Group name
	 * @return \mako\gatekeeper\entities\group\Group|bool
	 */
	public function getByName(string $name)
	{
		return $this->getModel()->where('name', '=', $name)->first();
	}

	/**
	 * Fetches a group by its id.
	 *
	 * @access public
	 * @param  int                                        $id Group id
	 * @return \mako\gatekeeper\entities\group\Group|bool
	 */
	public function getById(int $id)
	{
		return $this->getModel()->where('id', '=', $id)->first();
	}
}
