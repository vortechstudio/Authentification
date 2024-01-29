<?php

namespace App\Logging;

use App\Jobs\GithubIssueHandlerJob;
use Github\Client;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\LogRecord;

class GithubIssuesHandler extends AbstractProcessingHandler
{

    /**
     * @inheritDoc
     */
    protected function write(LogRecord $record): void
    {
        dispatch(new GithubIssueHandlerJob($record))->onQueue('github_error');
    }


}
