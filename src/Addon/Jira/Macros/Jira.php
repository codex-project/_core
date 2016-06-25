<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author Robin Radic
 * @copyright Copyright 2016 (c) Codex Project
 * @license http://codex-project.ninja/license The MIT License
 */
namespace Codex\Addon\Jira\Macros;

use JiraRestApi\Issue\IssueSearchResult;
use JiraRestApi\JiraException;

class Jira
{
    /** @var \Codex\Documents\Document */
    public $document;

    /** @var \Codex\Projects\Project */
    public $project;


    public function issuesList($isCloser = false, $project, $show = 'type,id,summary', $where = 'resolution = Unresolved', $order = 'priority DESC, updated DESC')
    {
        $show = explode(',', $show);

        $jql = 'project = "' . $project . '"';
        if(null !== $where && strlen($where) > 0){
            $jql .= " AND {$where}";
        }
        if(null !== $order && strlen($order) > 0){
            $jql .= " ORDER BY {$order}";
        }

        try
        {
            $issues = $this->searchIssues($jql);
            return view('codex.macros.issues', compact('issues', 'project', 'show'))->render();
        }
        catch (JiraException $e)
        {
            return "<br><strong>JIRA Error</strong><br><small><strong>JQL:</strong>({$jql})<br><strong>Response:</strong><br> ({$e->getMessage()}</small>)<br>";
        }
    }

    public function issuesCount($isCloser = false, $project,$where = 'resolution = Unresolved')
    {
        $jql = 'project = "' . $project . '"';
        if(null !== $where && strlen($where) > 0){
            $jql .= " AND {$where}";
        }

        try
        {
            $issues = $this->searchIssues($jql);
            return $issues->getTotal();
        }
        catch (JiraException $e)
        {
            return "<br><strong>JIRA Error</strong><br><small><strong>JQL:</strong>({$jql})<br><strong>Response:</strong><br> ({$e->getMessage()}</small>)<br>";
        }
    }


    /**
     * searchIssues method
     *
     * @param     $jql
     * @param int $cacheMinutes
     *
     * @return IssueSearchResult
     */
    protected function searchIssues($jql, $cacheMinutes = 5)
    {
        return app('cache.store')->remember('codex.jira.' . md5($jql), $cacheMinutes, function () use ($jql)
        {
            app()->bound('debugbar') && app('debugbar')->addMessage('Doing JQL Search: ' . $jql);
            return app('codex.jira')->issues()->search($jql);
        });
    }
}