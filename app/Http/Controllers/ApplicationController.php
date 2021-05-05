<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplicationRequest;
use App\Models\Application;
use App\Models\Charity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('application.index', ['applications' => Application::all()]);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('create-application', Auth::user());
        return view('application.create', ['charities' => Charity::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('create-application', Auth::user());
        $validated_app = $request->validate(['charity_id' => 'required|integer']);
        $validated_app['user_id'] = Auth::id();
        $validated_app['stage'] = env('STAGE_ORGANISATION_APPROVAL', '');
        $validated_app['created_at'] = now();
        $charity = Charity::where('id', $validated_app['charity_id'])->first();
        if($charity->is_approved){
            $validated_app['stage'] = env('STAGE_ALLOWED_TO_PROCEED', '');
        }
        Application::create($validated_app);
        return redirect()->route('application.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Gate::authorize('move-application', Auth::user());
        return view('application.edit', [
            'application' => Application::where('id', $id)->first()->toArray(),
            'stages' => [env('STAGE_ORGANISATION_APPROVAL', '') => 'Organisation approval', 
                env('STAGE_ALLOWED_TO_PROCEED', '') => 'Allowed to proceed', 
                env('STAGE_PAID', '') => 'Paid'
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ApplicationRequest $request, $id)
    {
        //validate input
        $validated_app = $request->validated();
        $validated_app['id'] = $id;
        $currentApp = Application::where('id', $validated_app['id'])->first();

        //check if application stage can be moved
        if($currentApp->stage != $validated_app['stage']){
            if($currentApp->charity->country_id != env('UK_COUNTRY_ID', '')) {
                return back()->withErrors('Country criteria not met when changing stage for this application');
            }
            if($validated_app['stage'] == env('STAGE_PAID', '') && (now()->lt($currentApp->created_at) || !$currentApp->charity->is_approved )){
                return back()->withErrors('Date and/or is_approved criteria not met when changing stage for this application');
            }
        }
        Application::where('id', $id)->update($validated_app);
        return redirect()->route('application.index');
    }

    public function list()
    {
        return response()->json(Application::all()->toArray());
    }
}
