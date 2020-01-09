<?php
/**
 * Author: Adrian Szuszkiewicz <me@imper.info>
 * Github: https://github.com/imper86
 * Date: 07.10.2019
 * Time: 11:58
 */

namespace Imper86\JobbyBundle\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ListCommand extends Command
{
    public static $defaultName = 'i86:jobby:list';
    /**
     * @var array
     */
    private $config;

    public function __construct(array $config)
    {
        parent::__construct(self::$defaultName);
        $this->config = $config;
    }

    protected function configure()
    {
        $this->setDescription('Returns list of jobs');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $tableHeader = [
            'Name',
            'Command',
            'Schedule',
            'Enabled',
        ];

        $tableData = array_map(function (string $name, array $config) {
            return [
                $name,
                $config['command'],
                $config['schedule'],
                $config['enabled'] ? 'true' : 'false',
            ];
        }, array_keys($this->config['jobs']), $this->config['jobs']);

        $io->table($tableHeader, $tableData);

        return 0;
    }
}
