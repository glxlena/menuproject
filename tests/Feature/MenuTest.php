<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
class MenuTest extends TestCase
{
  use RefreshDatabase;
  protected function setUp(): void
  {
    parent::setUp();

    $this->post('/register', [
      'name' => 'Helena',
      'email' => 'lena.oli1102@gmail.com',
      'password' => '12345678',
      'password_confirmation' => '12345678',
      'cpf' => '12345678901',
      'company_phone' => '0987654321',
      'cnpj' => '53628746',
      'phone' => '6723476346',
      'company_name' => 'example',
      'trading_name' => 'example LTDA',
      'adress' => 'rua tal',
      'type' => 'Gerente'
    ]);
    $user = User::where('email', 'lena.oli1102@gmail.com')->first();
    $this->actingAs($user);
  }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_should_show_index_menu_when_authenticated()
    {
        $response = $this->get('/menu');

        $response->assertOk()
          ->assertViewIs('menus.cardapios')
          ->assertSeeText('Gerenciamento de Cardápios');
    }

    public function test_shouldnt_create_menu_when_invalid_data()
    {
        $response = $this->post('/menu');

        $response->assertRedirect()
          ->assertInvalid(['name']);
    }

    public function test_should_create_menu_when_valid_data()
    {
        $response = $this->post('/menu', [
          'name' => 'Cardápio de teste',
          'description' => 'Descrição do Teste',
        ]);

        $response->assertRedirect()
          ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('menus', [
            'name' => 'Cardápio de teste',
        ]);
    }
  }
