<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\{
    Patient,
    User
};

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('patient.create');
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
            'birth_date' => 'required'
        ]);

        $patient = Patient::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'birth_date' => $request->birth_date,
            'weight' => $request->weight,
            'height' => $request->height,
            'congenital_disease' => $request->congenital_disease,
            'current_symptoms' => $request->current_symptoms,
            'food' => $request->food,
            'excretory_system' => $request->excretory_system,
            'expectations' => $request->expectations,
            'contact_person' => $request->contact_person,
            'contact_person_relationship' => $request->contact_person_relationship,
            'phone_number' => $request->phone_number,
            'arrival_date_time_expectation' => $request->arrival_date_time_expectation,
            'room_type' => $request->room_type,
            'offer_courses' => $request->offer_courses
        ]);

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
                            "text": "'.__('You has been successfully sent patient information Wait for CVC to contact the patient').'",
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
                            "text": "ข้อมูลคนไข้:",
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
                                            "text": "เพศ",
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
                                            "text": "อายุ",
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
                                            "text": "น้ำหนัก",
                                            "color": "#aaaaaa",
                                            "size": "sm",
                                            "flex": 3
                                        },
                                        {
                                            "type": "text",
                                            "text": "'.$patient->weight.' '.__('kg').'",
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
                                            "text": "ส่วนสูง",
                                            "color": "#aaaaaa",
                                            "size": "sm",
                                            "flex": 3
                                        },
                                        {
                                            "type": "text",
                                            "text": "'.$patient->height.' '.__('cm').'",
                                            "text": "160 ซม",
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
                                            "text": "โรคประจำตัว",
                                            "color": "#aaaaaa",
                                            "size": "sm",
                                            "flex": 3
                                        },
                                        {
                                            "type": "text",
                                            "text": "'.$patient->congenital_disease.'",
                                            "wrap": true,
                                            "color": "#666666",
                                            "size": "sm",
                                            "flex": 5
                                        }
                                    ]
                                }
                            ]
                        },
                        {
                            "type": "separator",
                            "margin": "lg"
                        },
                        {
                            "type": "box",
                            "layout": "vertical",
                            "contents": [
                                {
                                    "type": "text",
                                    "text": "ประวัติการรักษา:",
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
                                            "text": "อาการปัจจุบัน:",
                                            "color": "#aaaaaa",
                                            "size": "sm",
                                            "flex": 3
                                        },
                                        {
                                            "type": "text",
                                            "text": "'.$patient->current_symptoms.'",
                                            "wrap": true,
                                            "color": "#666666",
                                            "size": "sm",
                                            "flex": 5
                                        }
                                    ],
                                    "margin": "sm"
                                },
                                {
                                    "type": "box",
                                    "layout": "baseline",
                                    "spacing": "sm",
                                    "contents": [
                                        {
                                            "type": "text",
                                            "text": "อาหารที่รับทาน:",
                                            "color": "#aaaaaa",
                                            "size": "sm",
                                            "flex": 3,
                                            "wrap": true
                                        },
                                        {
                                            "type": "text",
                                            "text": "'.$patient->food.'",
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
                                            "text": "ระบบขับถ่าย:",
                                            "color": "#aaaaaa",
                                            "size": "sm",
                                            "flex": 3
                                        },
                                        {
                                            "type": "text",
                                            "text": "'.$patient->excretory_system.'",
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
                                            "text": "ความคาดหวังญาติ:",
                                            "color": "#aaaaaa",
                                            "size": "sm",
                                            "flex": 3,
                                            "wrap": true
                                        },
                                        {
                                            "type": "text",
                                            "text": "'.$patient->expectations.'",
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
                                            "text": "ญาติผู้ติดต่อ:",
                                            "color": "#aaaaaa",
                                            "size": "sm",
                                            "flex": 3
                                        },
                                        {
                                            "type": "text",
                                            "text": "'.$patient->contact_person.'",
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
                                            "text": "ความสัมพันธ์:",
                                            "color": "#aaaaaa",
                                            "size": "sm",
                                            "flex": 3,
                                            "wrap": true
                                        },
                                        {
                                            "type": "text",
                                            "text": "'.$patient->contact_person_relationship.'",
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
                                            "text": "เบอร์โทรศัพท์:",
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
                                            "text": "คาดการณ์เข้าพักวันเวลา:",
                                            "color": "#aaaaaa",
                                            "size": "sm",
                                            "flex": 3,
                                            "wrap": true
                                        },
                                        {
                                            "type": "text",
                                            "text": "'.$patient->arrival_date_time_expectation.'",
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
                                            "text": "สนใจห้อง:",
                                            "color": "#aaaaaa",
                                            "size": "sm",
                                            "flex": 3,
                                            "wrap": true
                                        },
                                        {
                                            "type": "text",
                                            "text": "'.__($patient->room_type).'",
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
                                            "text": "เสนอเพิ่มเติม:",
                                            "color": "#aaaaaa",
                                            "size": "sm",
                                            "flex": 3,
                                            "wrap": true
                                        },
                                        {
                                            "type": "text",
                                            "text": "'.$patient->offer_courses.'",
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
            $flexDataJsonPatientCode   = json_decode($flexMessageDataJson,true);
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
        return view('patient.show', compact('patient'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
