<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;
use JWTAuth;

class AuthController extends Controller
{
  /**
   * Login
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function login(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'email' => 'required|email',
      'password' => 'required|string|min:6',
    ]);

    if ($validator->fails()) 
      return response()->json($validator->errors(), 422);
    
    if (! $token = auth()->attempt($validator->validated())) 
      return response()->json(['message' => 'Usuario não autorizado'], 401);
    
    return $this->createToken($token);
  }

    /**
     * Criar nova conta
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) 
    {
      $validator = Validator::make($request->all(), [
        'name' => 'required|string|between:2,100',
        'email' => 'required|string|email|max:100|unique:users',
        'password' => 'required|string|confirmed|min:6',
      ]);

      if($validator->fails())
        return response()->json($validator->errors()->toJson(), 400);

      $user = User::create(array_merge($validator->validated(),
        ['password' => bcrypt($request->password)]));

      return response()->json(['message' => 'Usuario registrado com sucesso', 
        'user' => $user], 201);
    }

    /**
     * Logout
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
      auth()->logout();
      return response()->json(['message' => 'Logout executado com sucesso']);
    }

    /**
     * Refresh token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {   
      return $this->createToken(auth()->refresh());
    }

    /**
     * Listar dados do usuario logado
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
      return response()->json(auth()->user());
    }

    /**
     * Criar novo token JWT
     *
     * @param string $token
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createToken($token){        
      return response()->json([
        'token' => $token,
        'type' => 'bearer',
        'expires_in' => auth()->factory()->getTTL() * 60,
        'user' => auth()->user()
      ]);
    }
}