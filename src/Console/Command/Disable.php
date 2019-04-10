<?php
/**
 * This file is part of CaptainHook.
 *
 * (c) Sebastian Feldmann <sf@sebastian.feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CaptainHook\App\Console\Command;

use CaptainHook\App\CH;
use CaptainHook\App\Runner\Config\Editor;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Add
 *
 * @package CaptainHook
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/captainhookphp/captainhook
 * @since   Class available since Release 4.2.0
 */
class Disable extends Base
{
    /**
     * Configure the command
     *
     * @return void
     */
    protected function configure() : void
    {
        $this->setName('disable')
             ->setDescription('Disable a hook execution')
             ->setHelp('This command will disable a hook configuration for a given hook')
             ->addArgument('hook', InputArgument::REQUIRED, 'Hook you want to disable')
             ->addOption(
                 'configuration',
                 'c',
                 InputOption::VALUE_OPTIONAL,
                 'Path to your json configuration',
                 getcwd() . DIRECTORY_SEPARATOR . CH::CONFIG
             );
    }

    /**
     * Execute the command
     *
     * @param  \Symfony\Component\Console\Input\InputInterface   $input
     * @param  \Symfony\Component\Console\Output\OutputInterface $output
     * @return void
     * @throws \CaptainHook\App\Exception\InvalidHookName
     */
    protected function execute(InputInterface $input, OutputInterface $output) : void
    {
        $io     = $this->getIO($input, $output);
        $config = $this->getConfig($input->getOption('configuration'), true);

        $editor = new Editor($io, $config);
        $editor->setHook((string) $input->getArgument('hook'))
               ->setChange('DisableHook');

        $editor->run();
    }
}
