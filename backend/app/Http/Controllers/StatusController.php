<?php
  namespace App\Http\Controllers;

  use Illuminate\Http\Request;

  class StatusController extends Controller
  {
    public function list(Request $request) {
      return \App\Models\Status::list($request);
    }

    public function add(Request $request) {
      return \App\Models\Status::add($request);
    }    

    public function delete(Request $request) {
      return \App\Models\Status::deleteData($request);
    }

    public function update(Request $request, $id) {
      return \App\Models\Status::updateData($request, $id);
    }

  }