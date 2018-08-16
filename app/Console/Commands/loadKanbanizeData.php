<?php

namespace App\Console\Commands;

use App\Modules\Statistic\Contracts\StatisticResultRepositoryContract;
use Illuminate\Console\Command;


class loadKanbanizeData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statistic:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'fetch all task from kanbanize';

    protected $repository;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(StatisticResultRepositoryContract $repository)
    {
        $this->repository = $repository;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->repository->getKanbanizeDataForEachBoard();
    }
}
