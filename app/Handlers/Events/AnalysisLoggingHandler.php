<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Cachet HQ <support@cachethq.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Handlers\Events;

use McCool\LaravelAutoPresenter\PresenterDecorator;
use Psr\Log\LoggerInterface;

/**
 * This is the analysis logging handler class.
 *
 * @author Graham Campbell <graham@cachethq.io>
 */
class AnalysisLoggingHandler
{
    /**
     * The logger instance.
     *
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * The presenter instance.
     *
     * @var \McCool\LaravelAutoPresenter\PresenterDecorator
     */
    protected $presenter;

    /**
     * Create a new analysis logging handler instance.
     *
     * @param \Psr\Log\LoggerInterface                        $logger
     * @param \McCool\LaravelAutoPresenter\PresenterDecorator $presenter
     *
     * @return void
     */
    public function __construct(LoggerInterface $logger, PresenterDecorator $presenter)
    {
        $this->logger = $logger;
        $this->presenter = $presenter;
    }

    /**
     * Handle the analysis event.
     *
     * @param \StyleCI\StyleCI\Events\AnalysisHasStartedEvent|\StyleCI\StyleCI\Events\AnalysisHasCompletedEvent $event
     *
     * @return void
     */
    public function handle($event)
    {
        $commit = $event->commit;

        switch ($commit->status) {
            case 0:
                $this->logger->debug("Analysis of {$commit->id} has started.", ['title' => 'Analysis started.', 'commit' => $this->presenter->decorate($commit)->toArray()]);
                break;
            case 1:
            case 2:
                $this->logger->debug("Analysis of {$commit->id} has completed successfully.", ['title' => 'Analysis completed.', 'commit' => $this->presenter->decorate($commit)->toArray()]);
                break;
            case 3:
                $this->logger->error("Analysis of {$commit->id} has failed due to an internal error.", ['title' => 'Analysis errored.', 'commit' => $this->presenter->decorate($commit)->toArray()]);
                break;
            case 4:
                $this->logger->notice("Analysis of {$commit->id} has failed due to misconfiguration.", ['title' => 'Analysis misconfigured.', 'commit' => $this->presenter->decorate($commit)->toArray()]);
                break;
        }
    }
}