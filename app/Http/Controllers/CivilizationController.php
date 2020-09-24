<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

use App\Models\Civilization as CivilizationModel;
use App\Http\Resources\Civilization as CivilizationResource;
use App\Http\Resources\CivilizationCollection as CivilizationCollection;

class CivilizationController extends Controller
{
  public function index()
  {
    return new CivilizationCollection(CivilizationModel::all());
  }

  /**
   * pull the canonical civilization list from remote source at
   * https://age-of-empires-2-api.herokuapp.com/api/v1
   */
  public function initialize()
  {
    $response = Http::get('https://age-of-empires-2-api.herokuapp.com/api/v1/civilizations');
    Log::debug('got response of length '.$response->getHeader('Content-Length')[0]);
  }

  public function insert($name)
  {
    DB::insert('insert into civilizations (id, name) values (?, ?)', [1, $name]);
  }

  public function show($id)
  {
    return new CivilizationResource(CivilizationModel::findOrFail($id));
  }
}
