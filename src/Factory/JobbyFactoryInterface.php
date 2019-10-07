<?php
/**
 * Author: Adrian Szuszkiewicz <me@imper.info>
 * Github: https://github.com/imper86
 * Date: 07.10.2019
 * Time: 11:51
 */

namespace Imper86\JobbyBundle\Factory;


use Jobby\Jobby;

interface JobbyFactoryInterface
{
    public function generate(): Jobby;
}
