<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

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
    $this->destroyAll();
    $response = Http::get('https://age-of-empires-2-api.herokuapp.com/api/v1/civilizations');
    Log::debug('initializing DB');
    Log::debug('response status: '.$response->getStatusCode());
    $json = $response->json()['civilizations'];
    foreach ($json as $civData) {
      Log::debug('handling: '.print_r($civData, true));
      $civ = new Civilization;
      $civ->name = $civData['name'];
      $civ->expansion = $civData['expansion'];
      $civ->army_type = $civData['army_type'];
      // $civ->unique_unit = $civData['unique_unit'];
      // $civ->unique_tech = $civData['unique_tech'];
      $civ->team_bonus = $civData['team_bonus'];
      // $civ->civilization_bonus = $civData['civilization_bonus'];
      $civ->saveOrFail();
      Log::debug('saved '.$civ->name);
    }

    return $json;
  }
}
