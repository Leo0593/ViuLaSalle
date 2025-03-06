<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Mostrar la lista de usuarios.
     */
    public function index()
    {
        $users = User::all();
        return view('usuarios.index', compact('users'));
    }

    /**
     * Mostrar el formulario de creación.
     */
    public function create()
    {
        return view('usuarios.create'); // Asegúrate de crear esta vista
    }

    /**
     * Guardar un nuevo usuario.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:ADMIN,USER,PROFESOR',
            'avatar' => 'nullable|image|max:2048',
            'phone' => 'nullable|integer', // Validación para el campo phone
        ]);

        // Manejo de la imagen (si se sube)
        $avatarPath = $request->file('avatar') ? $request->file('avatar')->store('avatars', 'public') : null;

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => 1, // Activo por defecto
            'avatar' => $avatarPath,
            'phone' => $request->phone, // Guardar el teléfono
        ]);

        return redirect()->route('users.index')->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Mostrar el formulario de edición.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('usuarios.edit', compact('user')); // Asegúrate de crear esta vista
    }

    /**
     * Actualizar un usuario.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:ADMIN,USER,PROFESOR',
            'avatar' => 'nullable|image|max:2048',
            'phone' => 'nullable|integer', // Validación para el campo phone
        ]);

        // Manejo de la imagen (si se sube)
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'phone' => $request->phone, // Actualizar el teléfono
        ]);

        return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Activar/Inactivar un usuario.
     */
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->status = !$user->status; // Cambia entre 1 y 0
        $user->save();

        return redirect()->route('users.index')->with('success', 'Estado del usuario actualizado.');
    }

    /**
     * Eliminar un usuario.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Usuario eliminado correctamente.');
    }
}
