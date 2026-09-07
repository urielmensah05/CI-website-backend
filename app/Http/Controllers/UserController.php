<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
 use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    // afficher tous les utilisateurs
    public function list_users()
    {
        $list_users = User::get();
        return $list_users;
    }

    // enregistrer un utilisateur
    public function create_users(Request $request)
    {
        $data = $request->all();

        $Vname = $data['name'];
        $Vemail = $data['email'];
        $Vpassword = $data['password'];

        $users = new User();

        $users->name = $Vname;
        $users->email = $Vemail;
        $users->password = bcrypt($Vpassword);
        $users->password = Hash::make($request->password);

        $users->save();

        return $users;
        
    }
   
public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'message' => 'Email ou mot de passe incorrect'
        ], 401);
    }

    $token = $user->createToken('api_token')->plainTextToken;

    return response()->json([
        'token' => $token,
        'user' => $user
    ]);
}
public function updatePhoto(Request $request, $id)
{
    $user = User::find($id);

    if (!$user) {
        return response()->json(['message' => 'Utilisateur non trouvé'], 404);
    }

    // vérifier si fichier existe
    if ($request->hasFile('photo')) {

        $file = $request->file('photo');

        // nom unique
        $filename = time() . '.' . $file->getClientOriginalExtension();

        // enregistrer
        $file->storeAs('public/photos', $filename);

        // sauvegarder en base
        $user->photo = $filename;
        $user->save();

        return response()->json([
            'message' => 'Photo mise à jour',
            'photo_url' => asset('storage/photos/' . $filename)
        ]);
    }

    return response()->json(['message' => 'Aucune image envoyée'], 400);
}
}