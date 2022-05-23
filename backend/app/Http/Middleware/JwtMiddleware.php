<?php
  namespace App\Http\Middleware;

  use Closure;
  use JWTAuth;
  use Exception;
  use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

  class JwtMiddleware extends BaseMiddleware
  {
    /**
    * Handle an incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Closure  $next
    * @return mixed
    */
    public function handle($request, Closure $next)
    {
      try {
        $user = JWTAuth::parseToken()->authenticate();

      } catch (Exception $e) {
        if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
          return response()->json(['message'=>$e->getMessage()], 500);

        } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
          return response()->json(['message'=>$e->getMessage()], 401);
        } else {
          return response()->json(['message' => $e->getMessage()], 500);
        }
      }
      return $next($request);
    }
}    