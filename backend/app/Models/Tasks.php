<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Status;

class Tasks extends ModelBase
{
  use HasFactory;
  protected $table = 'taskses';

  //trazer status relacionado com a tarefa
  public function status()
  {
    return $this->belongsTo(Status::class, 'id_status');
  }

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

      //pesquisar por id da tarefa
      if (isset($request['id']) && !empty($request['id'])) {
        $coluna = "id like ?";
        $filtro = [$request['id']];
      }

      //pesquisar por status da tarefa
      if (isset($request['id_status']) && !empty($request['id_status'])) {
        $coluna = "id_status = ?";
        $filtro = [$request['id_status']];
      }

      //pesquisar por status da tarefa e descricao
      if (isset($request['id_status']) && !empty($request['id_status'])
          && isset($request['descricao']) && !empty($request['descricao'])) {
        $coluna = "id_status = ? and descricao like ?";
        $filtro = [$request['id_status'], '%'.$request['descricao'].'%'];
      }

      //eager loading
      $data = Tasks::select(['id', 'descricao', 'observacao', 'usuario_cadastro', 
        'usuario_alteracao', 'created_at', 'updated_at', 'id_status'])
      ->with(['status:id,descricao'])->whereRaw($coluna, $filtro)->get();

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
      $temp = new Tasks;
      $temp->descricao = $request['descricao'];
      $temp->observacao = $request['observacao'];
      $temp->id_status = $request['id_status'];
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
      Tasks::findOrFail($id)->delete();
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
      $temp = Tasks::findOrFail($id);
      $temp->descricao = $request['descricao'];
      $temp->observacao = $request['observacao']? $request['observacao'] : $temp['observacao'];
      $temp->id_status = $request['id_status']? $request['id_status'] : $temp['id_status'];
      $temp->usuario_alteracao = $usuario['id'];
      $temp->updated_at = $date->getTimestamp();
      $temp->save();
    } catch(\Exception $ex) {
      $data = $ex->getMessage();
      $status = 500;
    }
    return response()->json(compact('data'), $status);
  }
}