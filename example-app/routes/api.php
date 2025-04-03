use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

Route::post('/register', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'nombre_completo' => 'required|string|max:100',
        'email' => 'required|email|unique:usuarios,email',
        'password' => 'required|string|min:6',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 400);
    }

    $id_usuario = Str::uuid();
    DB::table('usuarios')->insert([
        'id_usuario' => $id_usuario,
        'nombre_completo' => $request->nombre_completo,
        'email' => $request->email,
        'contrasena_hash' => Hash::make($request->password),
        'fecha_registro' => now(),
        'estado_cuenta' => 'activo'
    ]);

    return response()->json(['message' => 'Usuario registrado con éxito'], 201);
});

Route::post('/login', function (Request $request) {
    $user = DB::table('usuarios')->where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->contrasena_hash)) {
        return response()->json(['error' => 'Credenciales incorrectas'], 401);
    }

    return response()->json(['message' => 'Inicio de sesión exitoso', 'user' => $user]);
});
