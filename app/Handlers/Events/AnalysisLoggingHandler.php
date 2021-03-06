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
use StyleCI\StyleCI\Events\CleanupHasCompletedEvent;
use StyleCI\StyleCI\Models\Commit;

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
     * Handle the event.
     *
     * @param \StyleCI\StyleCI\Events\AnalysisHasStartedEvent|\StyleCI\StyleCI\Events\AnalysisHasCompletedEvent|\StyleCI\StyleCI\Events\CleanupHasCompletedEvent $event
     *
     * @return void
     */
    public function handle($event)
    {
        $commit = $event->commit;

        if (isset($event->exception)) {
            $this->logger->notice($event->exception);
        }

        if ($event instanceof CleanupHasCompletedEvent) {
            $this->logger->error("Analysis of {$commit->id} has failed due to it timing out.", $this->getContext('Analysis timed out.', $commit));

            return; // if we've cleaned up a commit, stop here
        }

        switch ($commit->status) {
            case 0:
                $this->logger->debug("Analysis of {$commit->id} has started.", $this->getContext('Analysis started.', $commit));
                break;
            case 1:
            case 2:
                $this->logger->debug("Analysis of {$commit->id} has completed successfully.", $this->getContext('Analysis completed.', $commit));
                break;
            case 3:
                $this->logger->error("Analysis of {$commit->id} has failed due to an internal error.", $this->getContext('Analysis errored.', $commit));
                break;
            case 4:
                $this->logger->notice("Analysis of {$commit->id} has failed due to misconfiguration.", $this->getContext('Analysis misconfigured.', $commit));
                break;
        }
    }

    /**
     * Get the context.
     *
     * @param string                         $title
     * @param \StyleCI\StyleCI\Models\Commit $commit
     *
     * @return array
     */
    protected function getContext($title, Commit $commit)
    {
        return ['title' => $title, 'commit' => $this->presenter->decorate($commit)->toArray()];
    }
}
