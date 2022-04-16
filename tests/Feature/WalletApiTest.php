<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WalletApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use  RefreshDatabase;


    public function testGetBalance()
    {
        $response = $this->get('/api/v1/balance');

        $response->assertStatus(200);
    }

    public function testGetBalanceById()
    {
        $response = $this->get('/api/v1/balance/1');


        $response->assertStatus(200);
    }
    public function testAddWalletRecord()
    {
        $response = $this->post('/api/v1/balance/1', [
            'amount' => '100'
        ]);

        $response->assertStatus(200);
    }
}
