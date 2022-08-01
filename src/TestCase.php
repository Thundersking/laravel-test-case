<?php

namespace Vion\TestCase;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Vion\TestCase\Actions\LogAction;
use Vion\TestCase\Console\Cli;
use Vion\TestCase\Traits\HttpTrait;

abstract class TestCase extends BaseTestCase
{
    use Cli, HttpTrait;

    /**
     * Module test
     * @var string
     */
    protected $module;

    /**
     * Filename test
     * @var string
     */
    private $filename;

    /**
     * @return void
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $explodes = explode('/', $this->module);
        
        foreach ($explodes as $explode) {
            $name .= ucfirst($explode);
        }

        $this->filename = $name;
    }

    /**
     * Test index method
     *
     * @return void
     */
    protected function index()
    {
        $response = $this->withToken()->get('/' . $this->module);
        if ($response->status() === 200) {
            $response->assertOk();
            $this->success($this->module . '/index - 200');
        } elseif ($response->status() === 403) {
            $response->assertForbidden();
            $this->warning($this->module . '/index - 403');
        } else {
            (new LogAction)->error($this->filename . 'IndexError.log', $response);
            $this->error($this->module . '/index - ' . $response->status());
        }
    }

    /**
     * Test show method
     *
     * @param int $id
     * @return void
     */
    protected function show(int $id)
    {
        $response = $this->withToken()->get('/' . $this->module . '/' . $id);
        if ($response->status() === 200) {
            $response->assertOk();
            $this->success($this->module . '/show - 200');
        } elseif ($response->status() === 403) {
            $response->assertForbidden();
            $this->warning($this->module . '/show - 403');
        }  else {
            (new LogAction)->error($this->filename . 'ShowError.log', $response);
            $this->error($this->module . '/show - ' . $response->status());
        }
    }

    /**
     * Test store method
     *
     * @param array $data
     * @return void
     */
    protected function store(array $data)
    {
        $response = $this->withToken()->post('/' . $this->module);
        if ($response->status() === 422) {
            $response->assertUnprocessable();
            $this->info($this->module . '/create - 422');

            $response = $this->withToken()->post('/' . $this->module, $data);

            if ($response->status() === 201) {
                $response->assertCreated();
                $this->success($this->module . '/create - 201');
            } else {
                (new LogAction)->error($this->filename . 'StoreError.log', $response);
                $this->error($this->module . '/create - ' . $response->status());
            }
        } elseif ($response->status() === 403) {
            $response->assertForbidden();
            $this->warning($this->module . '/create - 403');
        } 
    }

    /**
     * Test update method
     *
     * @param int $id
     * @param array $data
     * @return void
     */
    protected function update(int $id, array $data)
    {
        $response = $this->withToken()->put('/' . $this->module . '/' . $id);

        if ($response->status() === 422) {
            $response->assertUnprocessable();
            $this->info($this->module . '/update - 422');

            $response = $this->withToken()->put('/' . $this->module . '/' . $id, $data);

            if ($response->status() === 200) {
                $response->assertOk();
                $this->success($this->module . '/update - 200');
            } else {
                (new LogAction)->error($this->filename . 'UpdateError.log', $response);
                $this->error($this->module . '/update - ' . $response->status());
            }
        } elseif ($response->status() === 403) {
            $response->assertForbidden();
            $this->warning($this->module . '/update - 403');
        } 
    }

    /**
     * Test destroy method
     *
     * @param int $id
     * @return void
     */
    protected function destroy(int $id)
    {
        $response = $this->withToken()->delete('/' . $this->module . '/' . $id);

        if ($response->status() === 200) {
            $response->assertSuccessful();
            $this->success($this->module . '/delete - 200');
        } elseif ($response->status() === 403) {
            $response->assertForbidden();
            $this->warning($this->module . '/delete - 403');
        } elseif ($response->status() === 422) {
            $response->assertUnprocessable();
            (new LogAction)->error($this->filename . 'DestroyError.log', $response);
            $this->warning($this->module . '/delete - ' . $response->status());
        } else {
            (new LogAction)->error($this->filename . 'DestroyError.log', $response);
            $this->error($this->module . '/delete - ' . $response->status());
        }
    }

    /**
     * Test all list method
     *
     * @return void
     */
    protected function allList()
    {
        $response = $this->withToken()->get('/' . $this->module . '/all-list');
        if ($response->status() === 200) {
            $response->assertOk();
            $this->success($this->module . '/all-list - 200');
        } elseif ($response->status() === 403) {
            $response->assertForbidden();
            $this->warning($this->module . '/delete - 403');
        } else {
            (new LogAction)->error($this->filename . 'AllListError.log', $response);
            $this->error($this->module . '/all-list - ' . $response->status());
        }
    }

    /**
     * Test get method
     *
     * @param string $method
     * @param string $param
     * @return void
     */
    protected function getTest(string $method, string $param = null)
    {
        $response = $this->withToken()->get('/' . $this->module . '/' . $method . '/' . $param);

        // добавил проверку 201, т.к. в некоторых get запросах присутствует post запрос
        if ($response->status() === 200 || $response->status() === 201) {
            $response->assertSuccessful();
            $this->success($this->module . '/' . $method . ' - ' . $response->status());
        } elseif ($response->status() === 403) {
            $response->assertForbidden();
            $this->warning($this->module . '/delete - 403');
        } else {
            (new LogAction)->error($this->filename . 'Get' . ucfirst($method) . 'Error.log', $response);
            $this->error($this->module . '/' . $method . ' - ' . $response->status());
        }
    }

    /**
     * Test post method
     *
     * @param string $method
     * @param array $data
     * @return void
     */
    protected function postTest(string $method, array $data)
    {
        $response = $this->withToken()->post('/' . $this->module . '/' . $method);
        
        if ($response->status() === 422) {
            $response->assertUnprocessable();
            $this->info($this->module . '/' . $method . ' - 422');

            $response = $this->withToken()->post('/' . $this->module . '/' . $method, $data);

            if ($response->status() === 200 || $response->status() === 201) {
                $response->assertSuccessful();
                $this->success($this->module . '/' . $method . ' - 200');
            } else {
                (new LogAction)->error($this->filename . 'Post' . str_replace('-', '', ucfirst($method)) . 'Error.log', $response);
                $this->error($this->module . '/' . $method . ' - ' . $response->status());
            }
        } elseif ($response->status() === 403) {
            $response->assertForbidden();
            $this->warning($this->module . '/delete - 403');
        } else {
            (new LogAction)->error($this->filename . 'Post' . str_replace('-', '', ucfirst($method)) . 'Error.log', $response);
            $this->error($this->module . '/' . $method . ' - ' . $response->status());
        }
    }
}
