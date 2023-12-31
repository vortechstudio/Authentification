<?php

namespace App\Service;

use Illuminate\Support\Facades\Http;
use App\Exceptions\GitlabConfigException;
use Salahhusa9\Updater\Contracts\Repository;
class GitlabRepository implements Repository
{

    /**
     * @throws GitlabConfigException
     * @throws \Exception
     */
    public function getLatestVersion(): string
    {
        $this->checkConfig();

        return isset($this->getLatestVersionData()['message']) ? throw new \Exception($this->getLatestVersionData()['message']) : $this->getLatestVersionData()['tag_name'];
    }

    /**
     * @throws GitlabConfigException
     */
    public function getLatestVersionData(): \Illuminate\Support\Collection
    {
        $this->checkConfig();

        $response = Http::withHeaders([
            'PRIVATE-TOKEN' => config('updater.gitlab_token'),
        ])
            ->timeout(config('updater.gitlab_timeout', 100))
            ->get('https://gitlab.com/api/v4/projects/'.config('updater.gitlab_repository').'/releases/permalinklatest');

        return $response->collect();
    }

    /**
     * @throws GitlabConfigException
     */
    public function getVersions(): array
    {
        $this->checkConfig();

        $versionsData = $this->getVersionsData();

        if (isset($versionsData['message'])) {
            throw new \Exception($versionsData['message']);
        }

        return $versionsData->map(function ($version) {
            return $version['tag_name'];
        })->toArray();
    }

    /**
     * @throws GitlabConfigException
     */
    public function getVersionsData(): \Illuminate\Support\Collection
    {
        $this->checkConfig();

        $response = Http::withHeaders([
            'PRIVATE-TOKEN' => config('updater.gitlab_token'),
        ])
            ->timeout(config('updater.github_timeout', 100))
            ->get('https://gitlab.com/api/v4/projects/'.config('updater.gitlab_repository').'/releases');

        return $response->collect();
    }

    /**
     * @throws GitlabConfigException
     */
    private function checkConfig(): void
    {
        if (config('updater.gitlab_token') == null) {
            throw new GitlabConfigException('Please set GITHUB_TOKEN in .env file');
        }

        if (config('updater.gitlab_username') == null) {
            throw new GitlabConfigException('Please set GITHUB_USERNAME in .env file');
        }

        if (config('updater.gitlab_repository') == null) {
            throw new GitlabConfigException('Please set GITHUB_REPOSITORY in .env file');
        }
    }
}
