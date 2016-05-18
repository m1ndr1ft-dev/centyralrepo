<?php

namespace App\Http\Controllers;

use App\Agent;
use App\Http\Requests;
use App\Http\Controllers\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;


class AgentController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $user = \Auth::user();
    $agents = \Auth::user()->agents()->orderby('created_at')->get();
    $currenttime = Carbon::now()->format('h:i a');
    $today = Carbon::now()->formatLocalized('%a %d %b %y');
    $deletedAgents = \Auth::user()->agents()->onlyTrashed()->get();

    return view('pages.agents.home', compact('agents', 'today', 'currenttime', 'user', 'deletedAgents'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param Requests\AgentRequest $request
   * @return Response
   */
  public function store(Requests\AgentRequest $request)
  {
    if($request->ajax())
    {
      $slug = Str::slug($request->name);

      \Auth::user()->agents()->create([
        'name' => $request->name,
        'slug' => $slug,
        'industry' => $request->industry,
        'founder' => $request->founder,
      ]);

      $response = [
        'msg' => 'Awesome! close this modal window !'
      ];

      return response()->json($response);
    }
    else
    {
      $slug = Str::slug($request->name);

      \Auth::user()->agents()->create([
        'slug' => $slug,
        'name' => $request->name,
        'industry' => $request->industry,
        'founder' => $request->founder,
      ]);

      return redirect('agents')->with('success', 'Agent' . ucwords($request->name) . ' has been successfully created!' );
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show()
  {
    return ("hello");
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param Agent $agent
   * @param Request $request
   * @return Response
   * @internal param int $id
   */
  public function edit(Agent $agent, Request $request)
  {
    if ($request->ajax())
    {

      $response = [
        'id' => $agent->id,
        'agentslug' => $agent->slug,
        'name' => $agent->name,
        'industry' => $agent->industry,
        'founder' => $agent->founder,
      ];

      return response()->json($response);

    }
    else
    {
      $agents = \Auth::user()->agents()->orderby('created_at')->get();
      $currenttime = Carbon::now()->format('h:i a');
      $today = Carbon::now()->formatLocalized('%a %d %b %y');

      return view('pages.agents.home', compact('agents', 'today', 'currenttime', 'user'));
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param Agent $agent
   * @param Requests\AgentRequest $request
   * @return Response
   * @internal param int $id
   */
  public function update(Agent $agent, Requests\AgentRequest $request)
  {
    if ($request->ajax())
    {
      $slug = Str::slug($request->name);

      $agent->update([
        'name' => $request->name,
        'slug' => $slug,
        'industry' => $request->industry,
        'founder' => $request->founder,
      ]);

      $response = [
        'msg' => 'Awesome! close this modal window !'
      ];

      return response()->json($response);
    }
    else
    {
      $slug = Str::slug($request->name);

      $agent->update([
        'slug' => $slug,
        'name' => $request->name,
        'industry' => $request->industry,
        'founder' => $request->founder,
      ]);

      return redirect('agents')->with('success', 'Agent' . ucwords($request->name) . ' has been successfully updated!' );
    }
  }

  /**
   * Hide the specified resource from view(soft delete).
   *
   * @param Agent $agent
   * @return Response
   * @internal param int $id
   */
  public function hide(Agent $agent)
  {
    $agent->delete();

    return redirect('agents')->with('success', 'Agent ' . $agent->name . ' has been successfully hidden.');
  }

  /**
   * Shows the specified resource from storage.
   *
   * @return Response
   */
  public function trashed()
  {
//    $user = \Auth::user();
//    $agents = \Auth::user()->agents()->orderby('created_at')->get();
//    $currenttime = Carbon::now()->format('h:i a');
//    $today = Carbon::now()->formatLocalized('%a %d %b %y');
//    $deletedAgents = \Auth::user()->agents()->onlyTrashed()->get();
//
//    return view('pages.agents.trashed', compact('agents', 'today', 'currenttime', 'user', 'deletedAgents'));
    return ("hello");
  }

  /**
   * Shows the specified resource from storage.
   *
   * @return Response
   */
  public function restoreAll()
  {
    \Auth::user()->agents()->onlyTrashed()->restore();
    return redirect('agents')->with("success", "Agent/Employers have been restored !");
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    //
  }


}
