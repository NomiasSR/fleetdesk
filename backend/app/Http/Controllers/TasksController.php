<?php
  namespace App\Http\Controllers;

  use Illuminate\Http\Request;

  class TasksController extends Controller
  {
    public function list(Request $request) {
      return \App\Models\Tasks::list($request);
    }

    public function add(Request $request) {
      return \App\Models\Tasks::add($request);
    }    

    public function delete(Request $request) {
      return \App\Models\Tasks::deleteData($request);
    }

    public function update(Request $request, $id) {
      return \App\Models\Tasks::updateData($request, $id);
    }

  }