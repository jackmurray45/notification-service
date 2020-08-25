<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Token;

class TokenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $this->authorize('Read Tokens');
        return Token::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->authorize('Create Tokens');

        $data = $request->validate([
            'name' => 'required|unique:tokens|max:255',
            'validated_on' => 'nullable|date_format:Y-m-d H:i:s'
        ]);

        $plainToken = Str::random(60);
        $data['token'] = hash('sha256', $plainToken);
        $token = Token::create($data);
        $token['plain_token'] = $plainToken; 

        return $token;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Token $token)
    {
        $this->authorize('Read Tokens');

        if($request->roles == 1)
        {
            $token->roles;
        }

        return $token;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Token $token)
    {
        $this->authorize('Update Tokens');

        $data = $request->validate([
            'name' => "required|unique:tokens,name,{$token->id}|max:255",
            'validated_on' => 'nullable|date_format:Y-m-d H:i:s',
            'expires_on' => 'nullable|date_format:Y-m-d H:i:s',
        ]);

        $token->update($data);

        return response(null, 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Token $token)
    {
        $this->authorize('Delete Tokens');

        $token->delete();

        return response(null, 204);
    }

    public function generateNewToken(Token $token)
    {
        $this->authorize('Regenerate Tokens');

        $plainToken = Str::random(60);
        $token->update(['token' => hash('sha256', $plainToken)]);
        $token['plain_token'] = $plainToken; 

        return $token;

    }

    public function assignRole(Token $token, Role $role)
    {
        $this->authorize('Update Tokens');
        $this->authorize('Read Roles');

        $token->assignRole($role);

        return response(null, 204);

    }

    public function removeRole(Token $token, Role $role)
    {
        $this->authorize('Update Tokens');
        $this->authorize('Read Roles');

        $token->removeRole($role);

        return response(null, 204);

    }

}
