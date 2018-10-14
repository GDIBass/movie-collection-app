<?php
/**
 * @author Matt Johnson <matt@gdibass.com>
 */

namespace App\Traits;

use Psr\Log\LoggerInterface;

/**
 * Trait LoggerTrait
 * Adds auto-wired logging to a class
 *
 * @package App\Traits
 */
trait LoggerTrait
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param LoggerInterface $logger
     *
     * @required
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}