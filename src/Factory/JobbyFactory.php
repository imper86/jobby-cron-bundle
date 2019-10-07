<?php
/**
 * Author: Adrian Szuszkiewicz <me@imper.info>
 * Github: https://github.com/imper86
 * Date: 07.10.2019
 * Time: 11:52
 */

namespace Imper86\JobbyBundle\Factory;


use Jobby\Jobby;

class JobbyFactory implements JobbyFactoryInterface
{
    /**
     * @var array
     */
    private $config;
    /**
     * @var string
     */
    private $projectDir;

    public function __construct(array $config, string $projectDir)
    {
        $this->config = $config;
        $this->projectDir = $projectDir;
    }

    public function generate(): Jobby
    {
        $jobby = new Jobby($this->config['globals']);

        foreach ($this->config['jobs'] as $jobName => $jobConfig) {
            if ($jobConfig['is_symfony_command']) {
                $jobConfig['command'] = "{$this->projectDir}/./bin/console {$jobConfig['command']}";
            }

            $jobby->add($jobName, $jobConfig);
        }

        return $jobby;
    }
}
