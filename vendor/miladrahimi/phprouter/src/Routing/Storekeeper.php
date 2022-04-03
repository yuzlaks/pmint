<?php

namespace MiladRahimi\PhpRouter\Routing;

use Closure;

/**
 * Class Storekeeper
 * It adds new routes with an existing state (attributes) into a Route repository
 *
 * @package MiladRahimi\PhpRouter\Routing
 */
class Storekeeper
{
    /**
     * @var Repository
     */
    private $repository;

    /**
     * @var State
     */
    private $state;

    /**
     * Constructor
     *
     * @param Repository $repository
     * @param State $state
     */
    public function __construct(Repository $repository, State $state)
    {
        $this->repository = $repository;
        $this->state = $state;
    }

    /**
     * Add a new route
     *
     * @param string $method
     * @param string $path
     * @param Closure|string|array $controller
     * @param string|null $name
     */
    public function add(string $method, string $path, $controller, ?string $name = null): void
    {

        if ($_ENV['RUN_SERVE'] == "TRUE") {

            $end_url = $this->state->getPrefix() ."/". $path;
            $end_url = explode("/", $end_url);

            // menghilangkan array yang kosong
            $end_url =array_filter($end_url, function($value) { return !is_null($value) && $value !== ''; });
            $end_url = "/".implode("/", $end_url);
            
            $this->repository->save(
                $method,
                $end_url,
                $controller,
                $name,
                $this->state->getMiddleware(),
                $this->state->getDomain()
            );
            
        }else{
            
            global $base_project;

            
            $end_url = $base_project."/".$this->state->getPrefix() ."/". $path;
            $end_url = explode("/", $end_url);
            
            // menghilangkan array yang kosong
            $end_url =array_filter($end_url, function($value) { return !is_null($value) && $value !== ''; });

            if($path != "/"){
                $end_url = "/".implode("/", $end_url);
            }else{
                $end_url = "/".implode("/", $end_url)."/";
            }

            $this->repository->save(
                $method,
                $end_url,
                $controller,
                $name,
                $this->state->getMiddleware(),
                $this->state->getDomain()
            );

        }
        
    }

    /**
     * @return State
     */
    public function getState(): State
    {
        return $this->state;
    }

    /**
     * @param State $state
     */
    public function setState(State $state): void
    {
        $this->state = $state;
    }

    /**
     * @return Repository
     */
    public function getRepository(): Repository
    {
        return $this->repository;
    }
}
