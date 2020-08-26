<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Token;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use PermissionSeeder;

class TokenTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(PermissionSeeder::class);

    }

    /** @test */
    public function a_token_can_be_created()
    {

        $token = factory(Token::class)->create();
        $token->givePermissionTo('Create Tokens');

        $response= $this->actingAs($token, 'api')->json('POST', '/api/tokens', $this->data());
        $response->assertStatus(201);
        $this->assertCount(2, Token::all());
        
    }

    /** @test */
    public function a_token_can_be_updated()
    {

        $token = factory(Token::class)->create();
        $token->givePermissionTo(['Create Tokens', 'Update Tokens']);
        $response= $this->actingAs($token, 'api')->json('POST', '/api/tokens', $this->data());
        $response= $this->actingAs($token, 'api')->json('PUT', '/api/tokens/2', array_merge($this->data(), ['name' => 'new name']));
        
        $response->assertStatus(204);
        $this->assertEquals('new name', Token::find(2)->name);

    }

    /** @test */
    public function a_token_can_be_delete()
    {

        $token = factory(Token::class)->create();
        $token->givePermissionTo(['Create Tokens', 'Delete Tokens']);
        
        $response= $this->actingAs($token, 'api')->json('POST', '/api/tokens', $this->data());
        $this->assertCount(2, Token::all());
        
        $response= $this->actingAs($token, 'api')->json('DELETE', '/api/tokens/2');
        $response->assertStatus(204);
        $this->assertCount(1, Token::all());

    }

    /** @test */
    public function can_update_same_token_with_the_same_name()
    {

        $token = factory(Token::class)->create();
        $token->givePermissionTo('Update Tokens');
        
        $response= $this->actingAs($token, 'api')->json('PUT', '/api/tokens/1', ['name' => $token->name]);
        $response->assertStatus(204);
        $this->assertEquals($token->name, Token::first()->name);

    }

    /** @test */
    public function two_tokens_can_not_have_the_same_name()
    {

        $token = factory(Token::class)->create();
        $token->givePermissionTo(['Create Tokens', 'Delete Tokens']);
        
        $response= $this->actingAs($token, 'api')->json('POST', '/api/tokens', $this->data());
        $this->assertCount(2, Token::all());
        
        $response= $this->actingAs($token, 'api')->json('POST', '/api/tokens', $this->data());
        $response->assertStatus(422);
        $this->assertCount(2, Token::all());

    }

    /** @test */
    public function regenerate_token_makes_new_token()
    {

        $token = factory(Token::class)->create();
        $token->givePermissionTo('Regenerate Tokens');
        
        $response = $this->actingAs($token, 'api')->json('POST', '/api/tokens/1/generate_token');
        $response->assertStatus(200);
        $this->assertNotEquals($token->token, Token::first()->token);

    }

    /** @test */
    public function can_not_assign_duplicate_roles_to_token()
    {

        $token = factory(Token::class)->create();
        $token->givePermissionTo(['Update Tokens', 'Create Roles', 'Read Roles']);

        $response = $this->actingAs($token, 'api')->json('POST', '/api/roles', ['name' => 'new role', 'permissions' => []]);
        $response = $this->actingAs($token, 'api')->json('POST', '/api/tokens/1/roles/1');
        $response->assertStatus(204);
        $this->assertCount(1, Token::find(1)->roles()->get());

        $response = $this->actingAs($token, 'api')->json('POST', '/api/tokens/1/roles/1');
        $response->assertStatus(204);
        $this->assertCount(1, Token::find(1)->roles()->get());

    }


    private function data()
    {
        return [
            'name' => 'test token',
            'validated_on' => '2020-07-26 13:38:10'
        ];
    }
}
