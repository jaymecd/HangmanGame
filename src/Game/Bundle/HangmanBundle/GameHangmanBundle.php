<?php

namespace Game\Bundle\HangmanBundle;

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Game\Bundle\HangmanBundle\DependencyInjection\Compiler\RegisterKernelSubscribersPass;

class GameHangmanBundle extends Bundle
{
	public function build(ContainerBuilder $container)
	{
		parent::build($container);

		if (version_compare(Kernel::VERSION, '2.1-DEV', '<')) {
		    $container->addCompilerPass(new RegisterKernelSubscribersPass(), PassConfig::TYPE_AFTER_REMOVING);
		}
	}
}
