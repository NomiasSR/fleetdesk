<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JWTAuth;

class ModelBase extends Model
{
  use HasFactory;

  /**
   * Usuario - Retorna dados do usuario do token
   *
   * @return array $usuario
  */
  public static function usuario() : array {      
    $temp = JWTAuth::parseToken()->authenticate()->toArray(); 
    $usuario['id'] = $temp['id'];
    return $usuario;
  }    
}
