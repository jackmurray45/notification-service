<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Requests\StoreRole;


class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('Read Roles');
        return Role::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRole $request)
    {

        $this->authorize('Write Roles');

        $role = Role::create(['name' => $request->name]);

        foreach($request->permissions as $permission)
        {
            $role->givePermissionTo($permission);
        }

        return $role;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Role $role)
    {

        $this->authorize('Read Roles');

        if($request->permissions == 1)
        {
            $role->permissions;
        }
        return $role;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRole $request, Role $role)
    {

        $role->update($request->only('name'));

        $role->permissions()->detach();
        foreach($request->permissions as $permission)
        {
            $role->givePermissionTo($permission);
        }

        return response(null, 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {

        $this->authorize('Delete Roles');

        $role->delete();
        
        return response(null, 204);
    }
}
