<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class ApiRequestMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:ApiRequest {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create a new api request class';

    /**
     * Execute the console command.
     */
    protected function getStub(){
        return __DIR__.'/stubs/api-request.stub';
    }
    protected function getDefaultNamespace($rootNamespace){
        return $rootNamespace.'/Http/ApiRequests';
    }
}
