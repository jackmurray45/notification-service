<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Token;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TokenTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function create_token()
    {
        
        factory(Token::class)->create();

        $this->assertCount(1, Token::all());

    }

    /** @test */
    public function create_token_with_token()
    {
        $token = factory(Token::class)->create();

        $token2 = factory(Token::class)->create([
            'token_id' => $token->id
        ]);

        $this->assertCount(2, Token::all());
        $this->assertEquals($token->id, $token2->token_id);

    }

    /** @test */
    public function assign_role_to_token()
    {
        $token = factory(Token::class)->create();
        $role = factory(Role::class)->create();

        $token->assignRole($role);

        $this->assertCount(1, $token->roles()->get());

    }

    /** @test */
    public function can_only_assign_role_to_token_once()
    {
        $token = factory(Token::class)->create();
        $role = factory(Role::class)->create();

        $token->assignRole($role);
        //Attempt to assign same role to token
        $token->assignRole($role);

        //Make sure that only one assignment was created
        $this->assertCount(1, $token->roles()->get());

    }

    
}
