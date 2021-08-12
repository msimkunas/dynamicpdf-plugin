<?php

namespace Renatio\DynamicPDF\Tests;

use Barryvdh\DomPDF\ServiceProvider;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use PluginTestCase;
use Renatio\DynamicPDF\Classes\PDFWrapper;

class TestCase extends PluginTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->changeDefaultFactoriesPath();

        $this->app->register(ServiceProvider::class);

        $this->app->bind('dynamicpdf', function ($app) {
            return new PDFWrapper($app['dompdf'], $app['config'], $app['files'], $app['view']);
        });
    }

    protected function changeDefaultFactoriesPath()
    {
        $this->app->singleton(Factory::class, function () {
            $faker = $this->app->make(Faker::class);

            return Factory::construct($faker, base_path('plugins/renatio/dynamicpdf/tests/factories'));
        });
    }
}
