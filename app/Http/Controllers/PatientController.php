<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

use App\Models\{
    HealthStatus,
    Patient,
    User,
    Stage,
    PatientImage
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
            'age' => $request->age,
        ]);

        if ($request->hasFile('images')) {
            $files = $request->file('images');
            foreach ($files as $key => $file) {
                $path = $file->store('upload', 's3');
                PatientImage::create([
                    'image' => basename($path),
                    'patient_id' => $patient->id
                ]);
            }
        }

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

        if($patient->birth_date) {
            $age = $patient->age().' '.__('Years');
        } else {
            $patient->age ? $age = $patient->age.' '.__('Years') : $age = __('No data found');
        }

        $flexMessageDataJson = '{
            "type": "flex",
            "altText": "'.__('You have successfully referred patient information') .' '."$patient->full_name".'",
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
                                        },
                                        {
                                            "type": "text",
                                            "text": "'."Refer no.".' '."$patient->number".'",
                                            "size": "xs",
                                            "color": "#FFFFFF",
                                            "wrap": true
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
                                            "text": "'.__('First Name-Last name').'",
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
                                            "text": "'.__('Refer number') .' refer no.)",
                                            "color": "#aaaaaa",
                                            "size": "sm",
                                            "flex": 3,
                                            "weight": "regular"
                                        },
                                        {
                                            "type": "text",
                                            "text": "'.$patient->number.'",
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
                                            "text": "'.$age.'",
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
                                        },
                                        {
                                            "type": "text",
                                            "text": "'."Refer no.".' '."$patient->number".'",
                                            "size": "xs",
                                            "color": "#FFFFFF",
                                            "wrap": true
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

        $flexDataJsonPatientCode = json_decode($flexMessageDataJson,true);
        $messagesPatientInfo['to'] = $patient->referred_by->auth_provider->provider_id;
        $messagesPatientInfo['messages'][] = $flexDataJsonPatientCode;
        $encodeJson = json_encode($messagesPatientInfo);
        $this->pushFlexMessage($encodeJson);

        // Send to creater
        $flexDataJsonPatientCompactCode = json_decode($flexMessageReferPatientCompact,true);
        $messages['to'] = $patient->referred_by->auth_provider->provider_id;
        $messages['messages'][] = $flexDataJsonPatientCompactCode;
        $encodeJsonPatientCompact = json_encode($messages);
        $this->pushFlexMessage($encodeJsonPatientCompact);

        // Send message to LINE Notify
        $messageToNotify = __(auth()->user()->role) .' '. auth()->user()->fullname .' '.__('has sent patient information named').' '. $patient->fullname.' '.__('View more information here') .' '. url('/patients/'.$patient->id.'').'';

        $this->lineNotify($messageToNotify, config('settings.lineNotifyTokenPatientReferral'));
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
        $patient = Patient::findOrFail($id);

        $newStage = Stage::where('step', $patient->stage->step+1)->first();
        $lastStage = Stage::where('step', $patient->stage->step-1)->first();

        // $patient->stage_id = $newStage->id;

        if($newStage->step == 2 ? $patient->contacted_relative_at = now() : '');
        if($newStage->step == 3 ? $patient->relative_visited_at = now() : '');
        if($newStage->step == 4 ? $patient->decided_at = now() : '');

        $patient->expected_arrive_date_time = $request->expected_arrive_date_time;
        $patient->arrive_date_time = $request->arrive_date_time;

        if($request->staying_decision) {
            $patient->staying_decision = $request->staying_decision;
        }

        $patient->reason_not_staying = $request->reason_not_staying;
        $patient->symptom_assessment = $request->symptom_assessment;
        $patient->underlying_disease = $request->underlying_disease;
        $patient->first_checkup      = $request->first_checkup;
        $patient->treatment_history  = $request->treatment_history;

        $patient->evaluate_eye_opening = $request->evaluate_eye_opening;
        $patient->verbal_response = $request->verbal_response;
        $patient->motor_response  = $request->motor_response;

        if($request->rollback == 'yes') {
            $patient->stage_id = $lastStage->id;
        }

        if ($request->has('change_decision')) {
            $patient->stage_id = $patient->stage_id;
            $patient->staying_decision = 'stay';
        } else {
            $patient->stage_id = $newStage->id;
        }

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
                                        },
                                        {
                                            "type": "text",
                                            "text": "'."Refer no.".' '."$patient->number".'",
                                            "size": "xs",
                                            "color": "#FFFFFF",
                                            "wrap": true
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
                            "text": "'.__('Step') .' '."$newStage->step".' '.$newStage->name.'",
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

        if ($request->has('staying_decision')) {
            if($patient->staying_decision == 'backoff') {
                if($patient->reason_not_staying) {
                    $reason = __('for reason') .' '.$patient->reason_not_staying.'';
                } else {
                    $reason = '';
                }
                $flexMessageNotStay = '{
                    "type": "flex",
                    "altText": "'.__('Informing patient of the decision not to stay') .' '."$patient->full_name".'",
                    "contents": {
                        "type": "bubble",
                        "body": {
                          "type": "box",
                          "layout": "vertical",
                          "contents": [
                            {
                              "type": "text",
                              "text": "'.__('Informing patient of the decision not to stay').'",
                              "weight": "bold",
                              "color": "#1DB446",
                              "size": "sm",
                              "wrap": true
                            },
                            {
                              "type": "text",
                              "text": "'.__('Dear Khun') .' '.$patient->referred_by->full_name.'",
                              "size": "xs",
                              "color": "#aaaaaa",
                              "wrap": true
                            },
                            {
                              "type": "text",
                              "text": "'.__('Chivacare') .' '.__('would like to inform that') .' '.__('The patient you referred named') .' '.$patient->full_name .' '.__('has decided not to stay') .' '.$reason.'",
                              "size": "xs",
                              "color": "#aaaaaa",
                              "wrap": true,
                              "margin": "lg"
                            },
                            {
                              "type": "text",
                              "text": "'.__('Forwarded for your information').'",
                              "size": "xs",
                              "color": "#aaaaaa",
                              "wrap": true,
                              "margin": "lg"
                            },
                            {
                                "type": "text",
                                "text": "'.__('If you have any questions or want to ask for more information. You can inquire through this chat').'",
                                "size": "xxs",
                                "color": "#aaaaaa",
                                "wrap": true,
                                "margin": "lg"
                            }
                          ]
                        },
                        "styles": {
                          "footer": {
                            "separator": true
                          }
                        }
                    }
                }';
                $flexDataJsonDeCodeNotStay = json_decode($flexMessageNotStay, true);
                $messages['to'] = $patient->referred_by->auth_provider->provider_id;
                $messages['messages'][] = $flexDataJsonDeCodeNotStay;
                $encodeJson = json_encode($messages);
                $this->pushFlexMessage($encodeJson);
            }
        }

        // Send message to LINE Notify
        if($newStage->step == 5 && $request->change_decision == null) {
            $messageToNotify = __('New patient').' '.$patient->arrive_date_time.' '.$patient->full_name.' '.__('Age').' '.$patient->age().' '.__('Years old').' '."NO U/D".' '."\r\n".' '."\r\n" .' '.$patient->underlying_disease.' '."\r\n".' '."\r\n".$patient->treatment_history.' '."\r\n".' '."\r\n".$patient->symptom_assessment.' '."\r\n".' '."\r\n".$patient->first_checkup;
            $this->lineNotify($messageToNotify, config('settings.lineNotifyTokenReportFirstCaseSymptoms'));
        }
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
        $flexMessagePatientEndService = '{
            "type": "flex",
            "altText": "'.__('Notification of end service') .' '."$patient->full_name".'",
            "contents": {
                "type": "bubble",
                "body": {
                  "type": "box",
                  "layout": "vertical",
                  "contents": [
                    {
                      "type": "text",
                      "text": "'.__('Notification of end service').'",
                      "weight": "bold",
                      "color": "#1DB446",
                      "size": "sm",
                      "wrap": true
                    },
                    {
                      "type": "text",
                      "text": "'.__('Dear Khun') .' '.$patient->referred_by->full_name.'",
                      "size": "xs",
                      "color": "#aaaaaa",
                      "wrap": true
                    },
                    {
                      "type": "text",
                      "text": "'.__('Chivacare') .' '.__('would like to inform that') .' '.__('The patient you referred named') .' '.$patient->full_name .' '.__('has ended the service').'",
                      "size": "xs",
                      "color": "#aaaaaa",
                      "wrap": true,
                      "margin": "lg"
                    },
                    {
                      "type": "text",
                      "text": "'.__('Forwarded for your information').'",
                      "size": "xs",
                      "color": "#aaaaaa",
                      "wrap": true,
                      "margin": "lg"
                    },
                    {
                        "type": "text",
                        "text": "'.__('If you have any questions or want to ask for more information. You can inquire through this chat').'",
                        "size": "xxs",
                        "color": "#aaaaaa",
                        "wrap": true,
                        "margin": "lg"
                    }
                  ]
                },
                "styles": {
                  "footer": {
                    "separator": true
                  }
                }
            }
        }';
        $flexDataJsonDeCode = json_decode($flexMessagePatientEndService, true);
        $messages['to'] = $patient->referred_by->auth_provider->provider_id;
        $messages['messages'][] = $flexDataJsonDeCode;
        $encodeJson = json_encode($messages);
        $this->pushFlexMessage($encodeJson);
        return back()->with('success', __('Successfully updated'));
    }

    public function updatedExpectedArrive(Request $request, $id)
    {
        $patient  = Patient::findOrFail($id);
        $patient->expected_arrive_date_time = $request->expected_arrive_date_time;
        $patient->save();

        $flexMessage = '{
            "type": "flex",
            "altText": "'.__('Changing the expected date and time of service') .' '."$patient->full_name".'",
            "contents": {
                "type": "bubble",
                "body": {
                  "type": "box",
                  "layout": "vertical",
                  "contents": [
                    {
                      "type": "text",
                      "text": "'.__('Changing the expected date and time of service').'",
                      "weight": "bold",
                      "color": "#1DB446",
                      "size": "sm"
                    },
                    {
                      "type": "text",
                      "text": "'.__('Dear Khun') .' '.$patient->referred_by->full_name.'",
                      "size": "xs",
                      "color": "#aaaaaa",
                      "wrap": true
                    },
                    {
                      "type": "text",
                      "text": "'.__('Chivacare') .' '.__('would like to inform that') .' '.__('The patient you referred named') .' '.$patient->full_name .' '.__('has changed the expected date and time of service') .' '.__('to be the date') .' '.date('Y-m-d', strtotime($patient->expected_arrive_date_time)) .' '.__('Time') .' '.date('H:m', strtotime($patient->expected_arrive_date_time)).'",
                      "size": "xs",
                      "color": "#aaaaaa",
                      "wrap": true,
                      "margin": "lg"
                    },
                    {
                      "type": "text",
                      "text": "'.__('Forwarded for your information').'",
                      "size": "xs",
                      "color": "#aaaaaa",
                      "wrap": true,
                      "margin": "lg"
                    },
                    {
                        "type": "text",
                        "text": "'.__('If you have any questions or want to ask for more information. You can inquire through this chat').'",
                        "size": "xxs",
                        "color": "#aaaaaa",
                        "wrap": true,
                        "margin": "lg"
                    }
                  ]
                },
                "styles": {
                  "footer": {
                    "separator": true
                  }
                }
            }
        }';
        $flexDataJsonDeCode = json_decode($flexMessage, true);
        $messages['to'] = $patient->referred_by->auth_provider->provider_id;
        $messages['messages'][] = $flexDataJsonDeCode;
        $encodeJson = json_encode($messages);
        $this->pushFlexMessage($encodeJson);
        return back()->with('success', __('Successfully updated'));
    }

    public function referralFees()
    {
        return view('referral-fees.index');
    }
}
