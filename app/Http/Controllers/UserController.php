<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
//use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(5);
        //$roles = Role::all();
    
    return view('users.users', compact('users'));
    }
    

    /**
     * Show the form for creating a new resource.
     
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    // Validar la entrada
    $request->validate([
        'nombre' => 'required|string|max:255|unique:users',
        'usuario' => 'required|string|max:255|unique:users',
        'password' => 'required|string|min:3|confirmed',
    ], [
        'nombre.required' => 'El campo nombre es obligatorio.',
        'nombre.unique' => 'El nombre ya está en uso.',
        'usuario.required' => 'El campo usuario es obligatorio.',
        'usuario.unique' => 'El nombre de usuario ya está en uso.',
        'password.required' => 'El campo contraseña es obligatorio.',
        'password.min' => 'La contraseña debe tener al menos 3 caracteres.',
        'password.confirmed' => 'Las contraseñas no coinciden.',
    ]);
            // Registrar al usuario
        $datosUsers = $request->except('_token');
        $user = User::create($datosUsers);
        // Asignar roles al usuario
        //$user->roles()->sync($request->roles);
        //return redirect('/users')->with('success', 'Usuario Registrado Con Exito');
        if ($user) {
            // Verificar si el usuario fue creado correctamente
            //return redirect('/users')->with('success', 'Usuario Registrado Con Éxito');
            return redirect('/users')->withSuccess('Usuario Registrado Con Éxito');
        } else {
            return redirect('/users')->with('error', 'Hubo un problema al registrar el usuario');
        }

    }

    /**
     * Display the specified resource.
     
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validar la entrada
        // Validar la entrada con mensajes personalizados
    $request->validate([
        'nombre' => 'sometimes|required',
        'usuario' => 'sometimes|required|unique:users,usuario,' . $id,
        'password' => 'sometimes|nullable|min:3|confirmed',
        'password_confirmation' => 'sometimes|required_with:password|same:password',
    ], [
        'nombre.required' => 'El nombre es obligatorio.',
        'usuario.required' => 'El nombre de usuario es obligatorio.',
        'usuario.unique' => 'El nombre de usuario ya está en uso.',
        'password.min' => 'La contraseña debe tener al menos :min caracteres.',
        'password_confirmation.required_with' => 'La confirmación de la contraseña es obligatoria.',
        'password_confirmation.same' => 'Las contraseñas no coinciden.',
    ]);
    
        // Buscar el usuario por el id
        $user = User::find($id);
    
        if (!$user) {
            return redirect('/users')->with('error', 'Usuario no encontrado');
        }
    
        // Preparar los datos validados para la actualización
        $data = $request->only(['nombre', 'usuario', 'password']);
    
        // Si se proporcionó una contraseña, hashearla antes de la actualización
        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            // Si la contraseña está vacía, eliminarla de los datos de actualización
            unset($data['password']);
        }
    
        // Actualizar los datos del usuario
        $user->update($data);
    
        // Redirigir a la página de usuarios con un mensaje de éxito
        return redirect('/users')->with('success', 'La cuenta se actualizó correctamente');
    }
    
    



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return redirect('users')->with('success', 'La cuenta ha sido eliminada correctamente');
        } else {
            return redirect('users')->with('error', 'Usuario no encontrado');
        }
    }
}
