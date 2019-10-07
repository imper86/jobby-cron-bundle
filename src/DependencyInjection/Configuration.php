<?php
/**
 * Author: Adrian Szuszkiewicz <me@imper.info>
 * Github: https://github.com/imper86
 * Date: 07.10.2019
 * Time: 10:28
 */

namespace Imper86\JobbyBundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeBuilder;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('imper86_jobby');

        if (method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            $rootNode = $treeBuilder->root('imper86_jobby');
        }

        $this->addGlobalsNode($rootNode);
        $this->addJobsNode($rootNode);

        return $treeBuilder;
    }

    private function addGlobalsNode(ArrayNodeDefinition $rootNode): void
    {
        $globalsNode = $rootNode
            ->children()
            ->arrayNode('globals')
            ->info('Global settings for jobby')
            ->addDefaultsIfNotSet();

        $this->appendSharedNodes($globalsNode->children());
        $globalsNode->end();
    }

    private function addJobsNode(ArrayNodeDefinition $rootNode): void
    {
        $jobsNode = $rootNode
            ->children()
            ->arrayNode('jobs')
            ->defaultValue([])
            ->info('Here you can define your cron jobs')
            ->useAttributeAsKey('name', false);

        $prototypeNode = $jobsNode->arrayPrototype()->info('Job configuration');

        $prototypeNode
            ->children()
                ->scalarNode('schedule')->defaultValue('* * * * *')->info('Crontab schedule format (man -s 5 crontab) or DateTime format (Y-m-d H:i:s)')->end()
                ->scalarNode('command')->isRequired()->cannotBeEmpty()->info('Command to execute')->end()
                ->booleanNode('is_symfony_command')->defaultTrue()->info("If set to true, bundle will decorate *command* with 'php path/bin/console {command}'")
        ;

        $this->appendSharedNodes($prototypeNode->children());

        $prototypeNode->end();
        $jobsNode->end();
    }

    private function appendSharedNodes(NodeBuilder $builder): void
    {
        $builder
            ->scalarNode('runAs')->defaultNull()->info('Run as this user, if crontab user has *sudo* privileges')->end()
            ->booleanNode('debug')->defaultFalse()->info("Send *jobby* internal messages to 'debug.log'")->end()
            ->scalarNode('environment')->defaultNull()->info('Development environment for this job')->end()
            ->scalarNode('runOnHost')->defaultValue(gethostname())->info('Run jobs only on this hostname')->end()
            ->integerNode('maxRuntime')->defaultNull()->info('Maximum execution time for this job (in seconds)')->end()
            ->booleanNode('enabled')->defaultTrue()->info('Run this job at scheduled times')->end()
            ->scalarNode('haltDir')->defaultNull()->info('A job will not run if this directory contains a file bearing the job\'s name')->end()
            ->scalarNode('output')->defaultValue('/dev/null')->info('Redirect *stdout* and *stderr* to this file')->end()
            ->scalarNode('output_stdout')->defaultValue('/dev/null')->info('Redirect *stdout* to this file')->end()
            ->scalarNode('output_stderr')->defaultValue('/dev/null')->info('Redirect *stderr* to this file')->end()
            ->scalarNode('dateFormat')->defaultValue('Y-m-d H:i:s')->info('Format for dates on *jobby* log messages')->end()
            ->scalarNode('recipients')->defaultNull()->info('Comma-separated string of email addresses')->end()
            ->scalarNode('mailer')->defaultValue('sendmail')->info('Email method: *sendmail* or *smtp* or *mail*')->end()
            ->scalarNode('smtpHost')->defaultNull()->info('SMTP host, if *mailer* is smtp')->end()
            ->integerNode('smtpPort')->defaultValue(25)->info('SMTP port, if *mailer* is smtp')->end()
            ->scalarNode('smtpUsername')->defaultNull()->info('SMTP user, if *mailer* is smtp')->end()
            ->scalarNode('smtpPassword')->defaultNull()->info('SMTP password, if *mailer* is smtp')->end()
            ->scalarNode('smtpSecurity')->defaultNull()->info('SMTP security option: *ssl* or *tls*, if *mailer* is smtp')->end()
            ->scalarNode('smtpSender')->defaultValue('jobby@<hostname>')->info('The sender and from addresses used in SMTP notices')->end()
            ->scalarNode('smtpSenderName')->defaultValue('Jobby')->info('The name used in the from field for SMTP messages')->end()
        ;
    }
}
