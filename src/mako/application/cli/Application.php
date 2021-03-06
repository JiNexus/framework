<?php

/**
 * @copyright Frederic G. Østby
 * @license   http://www.makoframework.com/license
 */

namespace mako\application\cli;

use mako\Mako;
use mako\application\Application as BaseApplication;
use mako\application\cli\commands\app\GenerateKey;
use mako\application\cli\commands\app\GenerateSecret;
use mako\application\cli\commands\app\ListRoutes;
use mako\application\cli\commands\cache\Clear;
use mako\application\cli\commands\cache\Remove;
use mako\application\cli\commands\migrations\Create;
use mako\application\cli\commands\migrations\Down;
use mako\application\cli\commands\migrations\Reset;
use mako\application\cli\commands\migrations\Status;
use mako\application\cli\commands\migrations\Up;
use mako\application\cli\commands\server\Server;
use mako\cli\output\Output;
use mako\config\Config;
use mako\http\routing\Routes;
use mako\reactor\Reactor;

/**
 * CLI application.
 *
 * @author Frederic G. Østby
 */
class Application extends BaseApplication
{
	/**
	 * Returns all registered commands.
	 *
	 * @access protected
	 * @return array
	 */
	protected function getCommands(): array
	{
		// Define core commands

		$commands =
		[
			'app.generate_key'    => GenerateKey::class,
			'app.generate_secret' => GenerateSecret::class,
			'app.routes'          => ListRoutes::class,
			'server'              => Server::class,
		];

		if($this->container->has('cache'))
		{
			$commands = array_merge($commands,
			[
				'cache.remove' => Remove::class,
				'cache.clear'  => Clear::class,
			]);
		}

		if($this->container->has('database'))
		{
			$commands = array_merge($commands,
			[
				'migrate.create' => Create::class,
				'migrate.status' => Status::class,
				'migrate.up'     => Up::class,
				'migrate.down'   => Down::class,
				'migrate.reset'  => Reset::class,
			]);
		}

		// Add application commands

		$commands += $this->config->get('application.commands');

		// Add package commands

		foreach($this->packages as $package)
		{
			$commands += $package->getCommands();
		}

		// Return commands

		return $commands;
	}

	/**
	 * Loads the reactor ASCII logo.
	 *
	 * @access protected
	 * @return string
	 */
	protected function loadLogo(): string
	{
		$logo = file_get_contents(__DIR__ . '/resources/logo.txt');

		return str_replace('{version}', Mako::VERSION, $logo);
	}

	/**
	 * {@inheritdoc}
	 */
	public function run()
	{
		ob_start();

		$input = $this->container->get('input');

		$output = $this->container->get('output');

		// Create reactor and register custom options

		$reactor = new Reactor($input, $output, $this->container);

		$reactor->setLogo($this->loadLogo());

		$reactor->registerCustomOption('env', 'Overrides the Mako environment', function(Config $config, $option)
		{
			putenv('MAKO_ENV=' . $option);

			$config->setEnvironment($option);
		});

		$reactor->registerCustomOption('database', 'Overrides the default database connection', function(Config $config, $option)
		{
			$config->set('database.default', $option);
		});

		$reactor->registerCustomOption('mute', 'Mutes all output', function(Output $output)
		{
			$output->mute();
		});

		// Register reactor commands

		foreach($this->getCommands() as $command => $class)
		{
			$reactor->registerCommand($command, $class);
		}

		// Run the reactor

		$exitCode = $reactor->run();

		exit($exitCode);
	}
}
