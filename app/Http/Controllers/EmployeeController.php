<?php

namespace App\Http\Controllers;

use App\Models\{
    Patient,
    User
};

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('employee.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employee = User::findOrFail($id);
        return view('employee.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(['role' => 'required']);

        $employee = User::findOrFail($id);
        $employee->role = $request->role;
        $employee->verified_at = now();
        $employee->is_verified = true;
        $employee->save();

        // Send message to LINE
        $message["type"] = "text";
        $message["text"] = __('You have verified the user account in the role') .' '.__($employee->role);
        $lineMessage["messages"][0] = $message;
        $lineMessage["to"] = $employee->auth_provider->provider_id;
        $this->pushMessage($lineMessage,'push');

        $stickerJson = '{
            "type": "sticker",
            "packageId": "11537",
            "stickerId": "52002734"
        }';

        $stickerJsonCode = json_decode($stickerJson,true);
        $datas['url']   = "https://api.line.me/v2/bot/message/push";
        $messages['to'] = $request->provider_id;
        $messages['messages'][] = $stickerJsonCode;
        $encodeJson = json_encode($messages);
        $this->pushFlexMessage($encodeJson, $datas);

        return back()->with('success', __('Successfully updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
