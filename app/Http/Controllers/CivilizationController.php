<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Civilization;

class CivilizationController extends Controller
{
  public function index()
  {
    $civilizations = DB::select('select * from civilizations');
    return view('civilization-index', ['civilizations' => $civilizations]);
  }

  public function insert($name)
  {
    DB::insert('insert into civilizations (id, name) values (?, ?)', [1, $name]);
  }

  public function show($id)
  {
    return view('civilization', ['civilization' => Civilization::findOrFail($id)]);
  }
}
