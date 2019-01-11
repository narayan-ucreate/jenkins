<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PDO;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        try {
            $db = new \PDO('pgsql:host=127.0.0.1;port=5432;dbname=test;user=postgres;password=postgres');

            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql ='CREATE TABLE IF NOT EXISTS test1 (id serial PRIMARY KEY, prename VARCHAR(50) NOT NULL);';
            $db->exec($sql);
            echo 'success';
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

        $this->assertTrue(true);
    }
}
