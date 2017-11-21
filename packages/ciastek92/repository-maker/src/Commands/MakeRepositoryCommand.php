<?php

namespace Ciastek92\RepositoryMaker\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeRepositoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new repository class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Repository';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    private $files;

    /**
     * Create a new command instance.
     *
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Repositories';
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = basename(trim($this->input->getArgument('name')));

        $this->createRepository($name);
    }

    /**
     * @param $name
     * @return bool
     */
    private function createRepository($name)
    {
        $modelName = $this->modelName($name);

        $filename = $modelName . 'Repository.php';

        if ($this->files->exists(app_path('Repositories/' . $filename))) {
            $this->error('Model repository already exists!');
            return false;
        }

        $model = $this->buildRepository($name);

        $this->files->put(app_path('/Repositories/' . $filename), $model);

        $this->info($modelName . ' repository created');

        return true;
    }

    /**
     * @param string $name
     * @return mixed|string
     */
    protected function buildRepository($name)
    {
        $stub = $this->files->get(__DIR__ . '/stubs/repository.stub');

        $stub = $this->replaceClassName($name . 'Repository', $stub);

        return $stub;
    }

    /**
     * @param $name
     * @param $stub
     * @return mixed
     */
    private function replaceClassName($name, $stub)
    {
        return str_replace('NAME_PLACEHOLDER', $name, $stub);
    }


    /**
     * Build a Model name from a word.
     *
     * @param string $name
     * @return string
     */
    private function modelName($name)
    {
        return ucfirst($name);
    }
}
