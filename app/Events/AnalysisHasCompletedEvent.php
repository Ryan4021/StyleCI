<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Cachet HQ <support@cachethq.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Events;

use Exception;
use StyleCI\StyleCI\Models\Commit;

/**
 * This is the analysis has completed event class.
 *
 * @author Graham Campbell <graham@cachethq.io>
 */
class AnalysisHasCompletedEvent
{
    /**
     * The commit that was analysed.
     *
     * @var \StyleCI\StyleCI\Models\Commit
     */
    public $commit;

    /**
     * The exception that occurred during analysis.
     *
     * @var \Exception|null
     */
    public $exception;

    /**
     * Create a new analysis has completed event instance.
     *
     * @param \StyleCI\StyleCI\Models\Commit $commit
     * @param \Exception|null                $exception
     *
     * @return void
     */
    public function __construct(Commit $commit, Exception $exception = null)
    {
        $this->commit = $commit;
        $this->exception = $exception;
    }
}
