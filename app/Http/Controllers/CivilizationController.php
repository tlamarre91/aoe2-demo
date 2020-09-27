<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

use App\Models\Civilization as Civilization;
use App\Http\Resources\Civilization as CivilizationResource;

class CivilizationController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $allCivs = Civilization::all();
    return CivilizationResource::collection($allCivs->sortByDesc('updated_at'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  //public function create()
  //{
  //  // 
  //}

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    Log::debug('store()');
    $civ = new Civilization;
    $civ->name = $request->input('name');
    $civ->saveOrFail();
    return true;
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    Log::debug('show()');
    $civ = Civilization::findOrFail($id);
    return $civ;
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  //public function edit($id)
  //{
  //  //
  //}

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $civ = Civilization::findOrFail($id);
    Log::debug('updating '.$civ->name);

    foreach ($request->all() as $key => $val) {
      Log::debug('key: '.$key.', val: '.$val);
      $civ->{$key} = $val;
    }
    $civ->saveOrFail();
    return $civ;
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    DB::table('civilizations')->where('id', '=', $id)->delete();
  }

  public function destroyAll()
  {
    DB::table('civilizations')->delete();
  }

  public function initialize()
  {
    //Log::debug($request->input['fallback']);
    $response = Http::get('https://age-of-empires-2-api.herokuapp.com/api/v1/civilizations');
    Log::debug('initializing DB');
    $status = $response->getStatusCode();
    Log::debug('response status: '.$status);
    if ($status == 200) {
      $this->destroyAll();
      $json = $response->json()['civilizations'];
      foreach ($json as $civData) {
        Log::debug('handling: '.print_r($civData, true));
        $civ = new Civilization;
        $civ->name = $civData['name'];
        $civ->expansion = $civData['expansion'];
        $civ->army_type = $civData['army_type'];
        $civ->unique_unit = json_encode($civData['unique_unit']);
        $civ->unique_tech = json_encode($civData['unique_tech']);
        $civ->team_bonus = $civData['team_bonus'];
        $civ->civilization_bonus = json_encode($civData['civilization_bonus']);
        $civ->saveOrFail();
        Log::debug('saved '.$civ->name);
      }

      return $json;
    } else {
      Log::debug('error! cancelling initialize with no changes');
      return response("got response code ".$status." from age-of-empires-2-api", 503);
    }
  }

  public function initializeFromLocal()
  {
    $json = Storage::disk('public')->get('civilizations.json');
    $json = json_decode($json, true);
    Log::debug($json);
    $this->destroyAll();
    foreach ($json as $civData) {
      Log::debug('handling: '.print_r($civData, true));
      $civ = new Civilization;
      $civ->name = $civData['name'];
      $civ->expansion = $civData['expansion'];
      $civ->army_type = $civData['army_type'];
      $civ->unique_unit = json_encode($civData['unique_unit']);
      $civ->unique_tech = json_encode($civData['unique_tech']);
      $civ->team_bonus = $civData['team_bonus'];
      $civ->civilization_bonus = json_encode($civData['civilization_bonus']);
      $civ->saveOrFail();
      Log::debug('saved '.$civ->name);
    }
  }
}
