<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends ModelBase
{
  use HasFactory;
  protected $table = 'statuses';

  /**
   * List - Listagem de dados
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\JsonResponse
  */
  public static function list($request) 
  {
    try{
      $status = 200;
      $coluna = "descricao like ?";
      $filtro = ['%'.$request['descricao'].'%'];

      if (isset($request['id']) && !empty($request['id'])) {
        $coluna = "id like ?";
        $filtro = [$request['id']];
      }
      
      $data = Status::whereRaw($coluna, $filtro)->orderBy('descricao', 'asc')->get();

      if ($data) {
        foreach($data as $key=>$value) {
          $data[$key]['data_cadastro'] = date("d/m/Y", strtotime($data[$key]['created_at']));
          $data[$key]['data_alteracao'] = !empty($data[$key]['updated_at'])? 
            date("d/m/Y", strtotime($data[$key]['updated_at'])) : ' ';
        }
      }      
    } catch(\Exception $ex) {
      $data = $ex->getMessage();
      $status = 500;
    }
    return response()->json(compact('data'), $status);
  }

  /**
   * Add - Cadastro de dados
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\JsonResponse
  */
  public static function add($request) {
    $data = "Registro salvo com sucesso";
    $status = 200;
    try{
      $usuario = self::usuario();
      $date = new \DateTime();
      $temp = new Status;
      $temp->descricao = $request['descricao'];
      $temp->observacao = $request['observacao'];
      $temp->usuario_cadastro = $usuario['id'];
      $temp->created_at = $date->getTimestamp();
      $temp->updated_at = null;
      $temp->save();
    } catch(\Exception $ex) {
      $data = $ex->getMessage();
      $status = 500;
    }
    return response()->json(compact('data'), $status);
  }

  /**
   * deleteData - Exclusao de dados
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\JsonResponse
  */
  public static function deleteData($request) {
    $id = $request['id'];
    $data = "Registro excluido com sucesso (id: ".$id.")";
    $status = 200;
    try{
      if ($id != "1" && $id != "2" && $id != "3")
        Status::findOrFail($id)->delete();
      else 
        throw new \Exception("Status 'Aberto', 'Fechado' e 'Concluído' não podem ser ALTERADOS/EXCLUÍDOS.");
    } catch(\Exception $ex) {
      $data = $ex->getMessage();
      $status = 500;
    }
    return response()->json(compact('data'), $status);
  }

  /**
   * updateData - Atualizacao de dados
   *
   * @param \Illuminate\Http\Request $request
   * @param int $id
   * @return \Illuminate\Http\JsonResponse
  */
  public static function updateData($request, $id) {
    $data = "Registro atualizado com sucesso (id: ".$id.")";
    $status = 200;
    try{
      $usuario = self::usuario();
      $date = new \DateTime();
      $temp = Status::findOrFail($id);
      $temp->descricao = $request['descricao'];
      $temp->observacao = $request['observacao'];
      $temp->usuario_alteracao = $usuario['id'];
      $temp->updated_at = $date->getTimestamp();
      if ($id != "1" && $id != "2" && $id != "3")
        $temp->save();
      else
        throw new \Exception("Status 'Aberto', 'Fechado' e 'Concluído' não podem ser ALTERADOS/EXCLUÍDOS.");
    } catch(\Exception $ex) {
      $data = $ex->getMessage();
      $status = 500;
    }
    return response()->json(compact('data'), $status);
  }
}