<?php
namespace RepositoryLab\Repository\Generators\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use RepositoryLab\Repository\Generators\TransformerGenerator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class TransformerCommand extends Command
{

    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'make:transformer';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Create a new transformer.';

    /**
     * Execute the command.
     *
     * @return void
     */
    public function fire()
    {
        (new TransformerGenerator([
            'name'  => $this->argument('name'),
            'force' => $this->option('force'),
        ]))->run();
        $this->info("Transformer created successfully.");
    }


    /**
     * The array of command arguments.
     *
     * @return array
     */
    public function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of model for which the transformer is being generated.', null],
        ];
    }

    /**
     * The array of command options.
     *
     * @return array
     */
    public function getOptions()
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, 'Force the creation if file already exists.', null]
        ];
    }
}
