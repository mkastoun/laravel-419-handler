<?php

namespace Laravel419Handler\Tests;

use Orchestra\Testbench\TestCase;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Route;
use Laravel419Handler\Laravel419HandlerServiceProvider;

class HandleTokenMismatchTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [Laravel419HandlerServiceProvider::class];
    }

    public function setUp(): void
    {
        parent::setUp();

        Route::middleware(['web'])->post('/test-token', function () {
            throw new TokenMismatchException();
        });
    }

    /** @test */
    public function it_returns_json_when_expecting_json()
    {
        $response = $this->postJson('/test-token');
        $response->assertStatus(419);
        $response->assertJson(["message" => "Session expired. Please try again."]);
    }

    /** @test */
    public function it_redirects_back_when_not_expecting_json()
    {
        $response = $this->from('/form-page')->post('/test-token');
        $response->assertRedirect('/form-page');
        $this->assertEquals(session('error'), 'Your session has expired. Please try again.');
    }
}