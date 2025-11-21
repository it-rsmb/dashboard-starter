<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    /**
     * Ambil semua roles
     */
     public function index()
    {
         $roles = Role::query();

    return DataTables::of($roles)
        ->addIndexColumn() // ini yang menambahkan DT_RowIndex
        ->addColumn('actions', function ($row) {
            return '<button class="btn btn-sm btn-primary">Edit</button>
                    <button class="btn btn-sm btn-danger">Delete</button>';
        })
        ->rawColumns(['actions'])
        ->make(true);
    }

    /**
     * Simpan role baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
        ]);

        $role = Role::create(['name' => $request->name]);

        return response()->json([
            'message' => 'Role created successfully',
            'role'    => $role
        ], 201);
    }

    /**
     * Update role
     */
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
        ]);

        $role->update(['name' => $request->name]);

        return response()->json([
            'message' => 'Role updated successfully',
            'role'    => $role
        ]);
    }

    /**
     * Hapus role
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return response()->json([
            'message' => 'Role deleted successfully'
        ]);
    }
}
