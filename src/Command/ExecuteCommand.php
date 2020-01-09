<?php
/**
 * Author: Adrian Szuszkiewicz <me@imper.info>
 * Github: https://github.com/imper86
 * Date: 07.10.2019
 * Time: 12:06
 */

namespace Imper86\JobbyBundle\Command;


use Jobby\Jobby;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExecuteCommand extends Command
{
    public static $defaultName = 'i86:jobby:execute';
    /**
     * @var Jobby
     */
    private $jobby;

    public function __construct(Jobby $jobby)
    {
        parent::__construct(self::$defaultName);
        $this->jobby = $jobby;
    }

    protected function configure()
    {
        $this->setDescription('Executes jobby');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->jobby->run();

        return 0;
    }
}
