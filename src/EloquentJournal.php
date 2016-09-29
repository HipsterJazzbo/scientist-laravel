<?php

namespace Scientist\Laravel;

use Scientist\Experiment;
use Scientist\Journals\Journal;
use Scientist\Laravel\Models\Experiment as ExperimentModel;
use Scientist\Laravel\Models\Result as ResultModel;
use Scientist\Report;
use Scientist\Result;

class EloquentJournal implements Journal
{
    /**
     * The executed experiment.
     *
     * @var \Scientist\Experiment
     */
    protected $experiment;

    /**
     * The experiment report.
     *
     * @var \Scientist\Report
     */
    protected $report;

    /**
     * Dispatch a report to storage.
     *
     * @param \Scientist\Experiment $experiment
     * @param \Scientist\Report     $report
     *
     * @return mixed
     */
    public function report(Experiment $experiment, Report $report)
    {
        $this->experiment = $experiment;

        $this->report = $report;

        // Record the Experiment
        $experimentModel = $this->recordExperiment($experiment);

        // Record the control results
        $resultModel = $this->recordResult($report->getControl(), true);

        $experimentModel->results()->save($resultModel);

        // Record the trial results
        foreach ($report->getTrials() as $name => $result) {
            $resultModel = $this->recordResult($result, false);

            $experimentModel->results()->save($resultModel);
        }
    }

    /**
     * Get the experiment.
     *
     * @return \Scientist\Experiment
     */
    public function getExperiment()
    {
        return $this->experiment;
    }

    /**
     * Get the experiment report.
     *
     * @return \Scientist\Report
     */
    public function getReport()
    {
        return $this->report;
    }

    /**
     * @param Experiment $experiment
     *
     * @return ExperimentModel
     */
    protected function recordExperiment(Experiment $experiment)
    {
        return ExperimentModel::updateOrCreate([
            'name' => $experiment->getName(),
        ], [
            'control' => $experiment->getControl(),
            'trials'  => $experiment->getTrials(),
            'params'  => $experiment->getParams(),
            'chance'  => $experiment->getChance(),
        ]);
    }

    /**
     * @param Result          $result
     * @param bool            $isControl
     *
     * @return ResultModel
     */
    protected function recordResult(Result $result, $isControl)
    {
        return new ResultModel([
            'control'      => $isControl,
            'value'        => $result->getValue(),
            'start_time'   => $result->getStartTime(),
            'end_time'     => $result->getEndTime(),
            'start_memory' => $result->getStartMemory(),
            'end_memory'   => $result->getEndMemory(),
            'exception'    => $result->getException(),
            'match'        => $isControl ? null : $result->isMatch(),
        ]);
    }
}
