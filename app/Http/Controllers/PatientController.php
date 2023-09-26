<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\{
    HealthStatus,
    Patient,
    User,
    Stage
};

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $health_statuses = HealthStatus::all();
        return view('patient.create', [
            'health_statuses' => HealthStatus::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'birth_date' => 'required',
            'preliminary_symptoms' => 'required',
            'precautions' => 'required',
            'contact_person' => 'required',
            'contact_person_relationship' => 'required',
            'phone_number' => 'required',
        ]);

        $patient = Patient::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'birth_date' => $request->birth_date,
            'weight' => $request->weight,
            'height' => $request->height,
            'congenital_disease' => $request->congenital_disease,
            'preliminary_symptoms' => $request->preliminary_symptoms,
            'food' => $request->other_food ? $request->other_food : $request->food,
            'excretory_system' => $request->excretory_system,
            'expectations' => $request->expectations,
            'contact_person' => $request->contact_person,
            'contact_person_relationship' => $request->contact_person_relationship,
            'phone_number' => $request->phone_number,
            'expected_arrive' => $request->expected_arrive,
            'room_type' => $request->room_type,
            'recommend_service' => $request->recommend_service,
            'precautions' => $request->precautions,
            'treatment_history' => $request->treatment_history,
            'health_status_id' => $request->health_status_id,
        ]);

        // Optional information
        $patient->weight ? $weightInfo = $patient->weight .' '.__('kg') : $weightInfo = __('No data found');
        $patient->height ? $heightInfo = $patient->height .' '.__('cm') : $heightInfo = __('No data found');
        $patient->health_status_id ? $healthStatus = __($patient->health_status->name) : $healthStatus = __('No data found');

        $patient->congenital_disease ? $congenitalDisease = $patient->congenital_disease : $congenitalDisease = __('No data found');

        $patient->treatment_history ? $treatmentHistory = $patient->treatment_history : $treatmentHistory = __('No data found');
        $patient->food ? $food = $patient->food : $food = __('No data found');
        $patient->excretory_system ? $excretorySystem = $patient->excretory_system : $excretorySystem = __('No data found');
        $patient->expectations ? $relativeExpectations = $patient->expectations : $relativeExpectations = __('No data found');
        $patient->expected_arrive ? $expectedArrive = $patient->expected_arrive : $expectedArrive = __('No data found');
        $patient->room_type ? $roomType = $patient->room_type : $roomType = __('Don\'t know yet');
        $patient->recommend_service ? $recommendService = $patient->recommend_service : $recommendService = __('No data found');

        $flexMessageReferPatientCompact = '{
            "type": "flex",
            "altText": "'.__('You have successfully referred patient information').'",
            "contents": {
                "type": "bubble",
                "size": "mega",
                "header": {
                    "type": "box",
                    "layout": "vertical",
                    "contents": [
                        {
                            "type": "box",
                            "layout": "horizontal",
                            "contents": [
                                {
                                    "type": "box",
                                    "layout": "vertical",
                                    "contents": [
                                        {
                                            "type": "text",
                                            "text": "'.__('Patient referral information').'",
                                            "color": "#FFFFFF"
                                        },
                                        {
                                            "type": "text",
                                            "text": "'.$patient->full_name.'",
                                            "flex": 1,
                                            "color": "#FFFFFF",
                                            "gravity": "bottom"
                                        }
                                    ],
                                    "flex": 6,
                                    "alignItems": "flex-start",
                                    "justifyContent": "space-between",
                                    "margin": "none"
                                }
                            ]
                        }
                    ],
                    "paddingAll": "20px",
                    "backgroundColor": "#198754",
                    "spacing": "md",
                    "paddingTop": "22px"
                },
                "body": {
                    "type": "box",
                    "layout": "baseline",
                    "contents": [
                        {
                            "type": "text",
                            "text": "'.__('Current stage').'",
                            "color": "#b7b7b7",
                            "size": "xs",
                            "flex": 1
                        },
                        {
                            "type": "text",
                            "text": "'.__('Stage').' 1 '.__('You has been successfully sent patient information Wait for CVC to contact the patient').'",
                            "flex": 2,
                            "wrap": true,
                            "size": "sm"
                        }
                    ]
                },
                "footer": {
                    "type": "box",
                    "layout": "vertical",
                    "spacing": "sm",
                    "contents": [
                        {
                            "type": "button",
                            "style": "primary",
                            "height": "sm",
                            "action": {
                                "type": "uri",
                                "label": "'.__('View patient information').'",
                                "uri": "'.url('/patients/'.$patient->id.'').'"
                            },
                            "color": "#E7A109"
                        },
                        {
                            "type": "box",
                            "layout": "vertical",
                            "contents": [],
                            "margin": "sm"
                        }
                    ],
                    "flex": 0
                }
            }
        }';

        $flexMessageDataJson = '{
            "type": "flex",
            "altText": "'.__('You have received patient referred information') .' '."$patient->full_name".'",
            "contents": {
                "type": "bubble",
                "header": {
                    "type": "box",
                    "layout": "vertical",
                    "contents": [
                        {
                            "type": "box",
                            "layout": "horizontal",
                            "contents": [
                                {
                                    "type": "box",
                                    "layout": "vertical",
                                    "contents": [
                                        {
                                            "type": "text",
                                            "text": "'.__('Patient referral information').'",
                                            "color": "#FFFFFF"
                                        }
                                    ],
                                    "flex": 6,
                                    "alignItems": "flex-start",
                                    "justifyContent": "space-between",
                                    "margin": "none"
                                }
                            ]
                        }
                    ],
                    "paddingAll": "20px",
                    "backgroundColor": "#198754",
                    "spacing": "md",
                    "paddingTop": "22px"
                },
                "body": {
                    "type": "box",
                    "layout": "vertical",
                    "contents": [
                        {
                            "type": "text",
                            "text": "'.__('Patient information').'",
                            "weight": "bold",
                            "size": "sm",
                            "margin": "md"
                        },
                        {
                            "type": "box",
                            "layout": "vertical",
                            "margin": "lg",
                            "spacing": "sm",
                            "contents": [
                                {
                                    "type": "box",
                                    "layout": "baseline",
                                    "spacing": "sm",
                                    "contents": [
                                        {
                                            "type": "text",
                                            "text": "ชื่อ-สกุล",
                                            "color": "#aaaaaa",
                                            "size": "sm",
                                            "flex": 3,
                                            "weight": "regular"
                                        },
                                        {
                                            "type": "text",
                                            "text": "'.$patient->full_name.'",
                                            "wrap": true,
                                            "color": "#000000",
                                            "size": "sm",
                                            "flex": 5
                                        }
                                    ]
                                },
                                {
                                    "type": "box",
                                    "layout": "baseline",
                                    "spacing": "sm",
                                    "contents": [
                                        {
                                            "type": "text",
                                            "text": "'.__('Gender').'",
                                            "color": "#aaaaaa",
                                            "size": "sm",
                                            "flex": 3,
                                            "weight": "regular"
                                        },
                                        {
                                            "type": "text",
                                            "text": "'.__($patient->gender).'",
                                            "wrap": true,
                                            "color": "#000000",
                                            "size": "sm",
                                            "flex": 5
                                        }
                                    ]
                                },
                                {
                                    "type": "box",
                                    "layout": "baseline",
                                    "spacing": "sm",
                                    "contents": [
                                        {
                                            "type": "text",
                                            "text": "'.__('Age').'",
                                            "color": "#aaaaaa",
                                            "size": "sm",
                                            "flex": 3
                                        },
                                        {
                                            "type": "text",
                                            "text": "'.$patient->age().' '.__('Years').'",
                                            "color": "#666666",
                                            "size": "sm",
                                            "flex": 5,
                                            "wrap": true
                                        }
                                    ]
                                },
                                {
                                    "type": "box",
                                    "layout": "baseline",
                                    "spacing": "sm",
                                    "contents": [
                                        {
                                            "type": "text",
                                            "text": "'.__('Weight').'",
                                            "color": "#aaaaaa",
                                            "size": "sm",
                                            "flex": 3
                                        },
                                        {
                                            "type": "text",
                                            "text": "'.$weightInfo.'",
                                            "color": "#666666",
                                            "size": "sm",
                                            "flex": 5,
                                            "wrap": true
                                        }
                                    ]
                                },
                                {
                                    "type": "box",
                                    "layout": "baseline",
                                    "spacing": "sm",
                                    "contents": [
                                        {
                                            "type": "text",
                                            "text": "'.__('Height').'",
                                            "color": "#aaaaaa",
                                            "size": "sm",
                                            "flex": 3
                                        },
                                        {
                                            "type": "text",
                                            "text": "'.$heightInfo.'",
                                            "color": "#666666",
                                            "size": "sm",
                                            "flex": 5,
                                            "wrap": true
                                        }
                                    ]
                                },
                                {
                                    "type": "box",
                                    "layout": "baseline",
                                    "spacing": "sm",
                                    "contents": [
                                        {
                                            "type": "text",
                                            "text": "'.__('Health status').'",
                                            "color": "#aaaaaa",
                                            "size": "sm",
                                            "flex": 3
                                        },
                                        {
                                            "type": "text",
                                            "text": "'.$healthStatus.'",
                                            "color": "#666666",
                                            "size": "sm",
                                            "flex": 5,
                                            "wrap": true
                                        }
                                    ]
                                },
                                {
                                    "type": "box",
                                    "layout": "baseline",
                                    "spacing": "sm",
                                    "contents": [
                                        {
                                            "type": "text",
                                            "text": "'.__('Congenital disease').'",
                                            "color": "#aaaaaa",
                                            "size": "sm",
                                            "flex": 3
                                        },
                                        {
                                            "type": "text",
                                            "text": "'.$congenitalDisease.'",
                                            "color": "#666666",
                                            "size": "sm",
                                            "flex": 5,
                                            "wrap": true
                                        }
                                    ]
                                },
                                {
                                    "type": "box",
                                    "layout": "baseline",
                                    "spacing": "sm",
                                    "contents": [
                                        {
                                            "type": "text",
                                            "text": "'.__('Preliminary symptoms').'",
                                            "color": "#aaaaaa",
                                            "size": "sm",
                                            "flex": 3
                                        },
                                        {
                                            "type": "text",
                                            "text": "'.$patient->preliminary_symptoms.'",
                                            "color": "#666666",
                                            "size": "sm",
                                            "flex": 5,
                                            "wrap": true
                                        }
                                    ]
                                },
                                {
                                    "type": "box",
                                    "layout": "baseline",
                                    "spacing": "sm",
                                    "contents": [
                                        {
                                            "type": "text",
                                            "text": "'.__('Precautions').'",
                                            "color": "#aaaaaa",
                                            "size": "sm",
                                            "flex": 3
                                        },
                                        {
                                            "type": "text",
                                            "text": "'.$patient->precautions.'",
                                            "color": "#666666",
                                            "size": "sm",
                                            "flex": 5,
                                            "wrap": true
                                        }
                                    ]
                                },
                                {
                                    "type": "box",
                                    "layout": "baseline",
                                    "spacing": "sm",
                                    "contents": [
                                        {
                                            "type": "text",
                                            "text": "'.__('Treatment history').'",
                                            "color": "#aaaaaa",
                                            "size": "sm",
                                            "flex": 3
                                        },
                                        {
                                            "type": "text",
                                            "text": "'.$treatmentHistory.'",
                                            "color": "#666666",
                                            "size": "sm",
                                            "flex": 5,
                                            "wrap": true
                                        }
                                    ]
                                },
                                {
                                    "type": "text",
                                    "text": "'.__('Relative information').'",
                                    "weight": "bold",
                                    "size": "sm",
                                    "margin": "md"
                                },
                                {
                                    "type": "box",
                                    "layout": "baseline",
                                    "spacing": "sm",
                                    "contents": [
                                        {
                                            "type": "text",
                                            "text": "'.__('Name of relative').'",
                                            "color": "#aaaaaa",
                                            "size": "sm",
                                            "flex": 3
                                        },
                                        {
                                            "type": "text",
                                            "text": "'.$patient->contact_person.' ('.$patient->contact_person_relationship.')",
                                            "wrap": true,
                                            "color": "#666666",
                                            "size": "sm",
                                            "flex": 5
                                        }
                                    ]
                                },
                                {
                                    "type": "box",
                                    "layout": "baseline",
                                    "spacing": "sm",
                                    "contents": [
                                        {
                                            "type": "text",
                                            "text": "'.__('Phone number').'",
                                            "color": "#aaaaaa",
                                            "size": "sm",
                                            "flex": 3
                                        },
                                        {
                                            "type": "text",
                                            "text": "'.$patient->phone_number.'",
                                            "wrap": true,
                                            "color": "#666666",
                                            "size": "sm",
                                            "flex": 5
                                        }
                                    ]
                                },
                                {
                                    "type": "box",
                                    "layout": "baseline",
                                    "spacing": "sm",
                                    "contents": [
                                        {
                                            "type": "text",
                                            "text": "'.__('Expected arrive').'",
                                            "color": "#aaaaaa",
                                            "size": "sm",
                                            "flex": 3
                                        },
                                        {
                                            "type": "text",
                                            "text": "'.__($expectedArrive).'",
                                            "wrap": true,
                                            "color": "#666666",
                                            "size": "sm",
                                            "flex": 5
                                        }
                                    ]
                                },
                                {
                                    "type": "box",
                                    "layout": "baseline",
                                    "spacing": "sm",
                                    "contents": [
                                        {
                                            "type": "text",
                                            "text": "'.__('Relative Expectations').'",
                                            "wrap": true,
                                            "color": "#aaaaaa",
                                            "size": "sm",
                                            "flex": 3
                                        },
                                        {
                                            "type": "text",
                                            "text": "'.__($relativeExpectations).'",
                                            "wrap": true,
                                            "color": "#666666",
                                            "size": "sm",
                                            "flex": 5
                                        }
                                    ]
                                },
                                {
                                    "type": "box",
                                    "layout": "baseline",
                                    "spacing": "sm",
                                    "contents": [
                                        {
                                            "type": "text",
                                            "text": "'.__('Recommend additional recovery programs').'",
                                            "color": "#aaaaaa",
                                            "size": "sm",
                                            "wrap": true,
                                            "flex": 3
                                        },
                                        {
                                            "type": "text",
                                            "text": "'.__($recommendService).'",
                                            "wrap": true,
                                            "color": "#666666",
                                            "size": "sm",
                                            "flex": 5
                                        }
                                    ]
                                },
                                {
                                    "type": "text",
                                    "text": "'.__('Additional information').'",
                                    "weight": "bold",
                                    "size": "sm",
                                    "margin": "md"
                                },
                                {
                                    "type": "box",
                                    "layout": "baseline",
                                    "spacing": "sm",
                                    "contents": [
                                        {
                                            "type": "text",
                                            "text": "'.__('Food').'",
                                            "color": "#aaaaaa",
                                            "size": "sm",
                                            "wrap": true,
                                            "flex": 3
                                        },
                                        {
                                            "type": "text",
                                            "text": "'.__($food).'",
                                            "wrap": true,
                                            "color": "#666666",
                                            "size": "sm",
                                            "flex": 5
                                        }
                                    ]
                                },
                                {
                                    "type": "box",
                                    "layout": "baseline",
                                    "spacing": "sm",
                                    "contents": [
                                        {
                                            "type": "text",
                                            "text": "'.__('Excretory system').'",
                                            "color": "#aaaaaa",
                                            "size": "sm",
                                            "wrap": true,
                                            "flex": 3
                                        },
                                        {
                                            "type": "text",
                                            "text": "'.__($excretorySystem).'",
                                            "wrap": true,
                                            "color": "#666666",
                                            "size": "sm",
                                            "flex": 5
                                        }
                                    ]
                                },
                                {
                                    "type": "box",
                                    "layout": "baseline",
                                    "spacing": "sm",
                                    "contents": [
                                        {
                                            "type": "text",
                                            "text": "'.__('Room type').'",
                                            "color": "#aaaaaa",
                                            "size": "sm",
                                            "wrap": true,
                                            "flex": 3
                                        },
                                        {
                                            "type": "text",
                                            "text": "'.__($roomType).'",
                                            "wrap": true,
                                            "color": "#666666",
                                            "size": "sm",
                                            "flex": 5
                                        }
                                    ]
                                }
                            ],
                            "margin": "lg"
                        }
                    ]
                },
                "footer": {
                    "type": "box",
                    "layout": "vertical",
                    "spacing": "xs",
                    "contents": [
                        {
                            "type": "button",
                            "style": "primary",
                            "color": "#E7A109",
                            "action": {
                                "type": "uri",
                                "label": "'.__('View patient information').'",
                                "uri": "'.url('/patients/'.$patient->id.'').'"
                            },
                            "height": "sm"
                        }
                    ],
                    "flex": 0
                }
            }
        }';

        // Send to creater
        $flexDataJsonPatientCompactCode = json_decode($flexMessageReferPatientCompact,true);

        $messages['to'] = auth()->user()->auth_provider->provider_id;
        $messages['messages'][] = $flexDataJsonPatientCompactCode;
        $encodeJsonPatientCompact = json_encode($messages);
        $this->pushFlexMessage($encodeJsonPatientCompact);

        // Send to admin
        $admin = User::where('role', 'admin')->first();

        if($admin) {
            $flexDataJsonPatientCode = json_decode($flexMessageDataJson,true);
            $messagesPatientInfo['to'] = $admin->auth_provider->provider_id;
            $messagesPatientInfo['messages'][] = $flexDataJsonPatientCode;
            $encodeJson = json_encode($messagesPatientInfo);
            $this->pushFlexMessage($encodeJson);
        }
        return redirect()->route('patients.show', $patient->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $patient = Patient::findOrFail($id);

        if($patient->staying_decision == 'backoff') {
            $stages = Stage::where('step', '<', 5)->get();
        } else {
            if($patient->end_service_at) {
                $stages = Stage::where('step', '<=', $patient->stage->step)->get();
            } else {
                $stages = Stage::all();
            }
        }
        $nextStage = Stage::where('step', $patient->stage->step+1)->first();
        return view('patient.show', compact('patient', 'stages', 'nextStage'));
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
    public function update(Request $request, $id)
    {
        $patient  = Patient::findOrFail($id);

        $newStage = Stage::where('step', $patient->stage->step+1)->first();
        $patient->stage_id = $newStage->id;
        if($newStage->step == 2 ? $patient->contacted_relative_at = now() : '');
        if($newStage->step == 3 ? $patient->relative_visited_at = now() : '');
        if($newStage->step == 4 ? $patient->decided_at = now() : '');
        if($newStage->step == 5 ? $patient->arrive_date_time = now() : '');

        if ($request->has('staying_decision')){
            $patient->staying_decision = $request->staying_decision;
        }

        if ($request->has('expected_arrive_date_time')){
            $patient->expected_arrive_date_time = $request->expected_arrive_date_time;
        }

        if ($request->has('physical_therapy_service')){
            $patient->physical_therapy_service = $request->physical_therapy_service;
        }

        $patient->reason_not_staying = $request->reason_not_staying;

        $patient->save();

        $flexMessageUpdateReferPatient = '{
            "type": "flex",
            "altText": "'.__('Update on the patient referral process') .' '."$patient->full_name".'",
            "contents": {
                "type": "bubble",
                "size": "mega",
                "header": {
                    "type": "box",
                    "layout": "vertical",
                    "contents": [
                        {
                            "type": "box",
                            "layout": "horizontal",
                            "contents": [
                                {
                                    "type": "box",
                                    "layout": "vertical",
                                    "contents": [
                                        {
                                            "type": "text",
                                            "text": "'.__('Patient referral information').'",
                                            "color": "#FFFFFF"
                                        },
                                        {
                                            "type": "text",
                                            "text": "'.$patient->full_name.'",
                                            "flex": 1,
                                            "color": "#FFFFFF",
                                            "gravity": "bottom"
                                        }
                                    ],
                                    "flex": 6,
                                    "alignItems": "flex-start",
                                    "justifyContent": "space-between",
                                    "margin": "none"
                                }
                            ]
                        }
                    ],
                    "paddingAll": "20px",
                    "backgroundColor": "#198754",
                    "spacing": "md",
                    "paddingTop": "22px"
                },
                "body": {
                    "type": "box",
                    "layout": "baseline",
                    "contents": [
                        {
                            "type": "text",
                            "text": "'.__('Current stage').'",
                            "color": "#b7b7b7",
                            "size": "xs",
                            "flex": 1
                        },
                        {
                            "type": "text",
                            "text": "'.__($newStage->name).'",
                            "flex": 2,
                            "wrap": true,
                            "size": "sm"
                        }
                    ]
                },
                "footer": {
                    "type": "box",
                    "layout": "vertical",
                    "spacing": "sm",
                    "contents": [
                        {
                            "type": "button",
                            "style": "primary",
                            "height": "sm",
                            "action": {
                                "type": "uri",
                                "label": "'.__('View patient information').'",
                                "uri": "'.url('/patients/'.$patient->id.'').'"
                            },
                            "color": "#E7A109"
                        },
                        {
                            "type": "box",
                            "layout": "vertical",
                            "contents": [],
                            "margin": "sm"
                        }
                    ],
                    "flex": 0
                }
            }
        }';

        $flexDataJsonDeCode = json_decode($flexMessageUpdateReferPatient, true);
        $messages['to'] = $patient->referred_by->auth_provider->provider_id;
        $messages['messages'][] = $flexDataJsonDeCode;
        $encodeJson = json_encode($messages);
        $this->pushFlexMessage($encodeJson);
        return back()->with('success', __('Successfully updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function endService(Request $request, $id)
    {
        $patient  = Patient::findOrFail($id);
        $patient->end_service_at = now();
        $patient->save();
        return back()->with('success', __('Successfully updated'));
    }
}
