<?php

namespace Bitfumes\Multiauth\Http\Controllers;

use Bitfumes\Multiauth\Model\Admin;
use Bitfumes\Multiauth\Model\Role;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('role:super');
    }

    public function index()
    {
        $roles = Role::all();

        return view('multiauth::roles.index', compact('roles'));
    }

    public function create()
    {
        return view('multiauth::roles.create');
    }

    public function edit(Role $role)
    {
        return view('multiauth::roles.edit', compact('role'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        Role::create($request->all());

        return redirect(route('admin.roles'))->with('message', "Nauja rolė pridėta sėkmingai. Norėdami suaktyvinti spauskite 'keisti'");
    }

    public function update(Role $role, Request $request)
    {
        $request->validate(['name' => 'required']);

        $role->update($request->all());

        return redirect(route('admin.roles'))->with('message', 'Rolė atnaujinta sėkmingai');
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->back()->with('message', 'Rolė buvo ištrinta');
    }
}
