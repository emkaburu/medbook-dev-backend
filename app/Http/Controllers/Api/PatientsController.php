<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gender;
use App\Models\Patient;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Utilities\StaticFunctions as SF;

class PatientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // Get the patients, join with genders and services
        $patients = Patient::leftJoin('genders', 'genders.id', '=', 'patients.gender_id')
            ->leftJoin('services', 'services.id', '=', 'patients.service_id')
            ->select(
                'patients.id',
                'patients.date_of_birth',
                'patients.comments',
                'genders.gender AS gender',
                'services.service_type AS service',
            )
            ->orderBy('patients.id', 'DESC')
            ->get();

        $response = [
            "Code" => "200",
            "Description" => "Patients successfully fetched",
            "patients" => $patients
        ];

        return json_encode($response);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = SF::checkContentType($request);
        $decoded = json_decode($response, TRUE);
        if($decoded["Code"] != 200){
            return $response;
        }
        $form_data     = $request->all();

        if(empty($form_data)){
            $response = [
                "Code" => "500",
                "Description" => "You did not provide any data",
            ];
            return json_encode($response);
        }

        if(is_null($request->gender)){
            $response = [
                "Code" => "500",
                "Description" => "You did not provide a gender",
            ];
            return json_encode($response);
        }

        if(is_null($request->service)){
            $response = [
                "Code" => "500",
                "Description" => "You did not provide a service",
            ];
            return json_encode($response);
        }

        if(is_null($request->name)){
            $response = [
                "Code" => "500",
                "Description" => "You did not provide a name",
            ];
            return json_encode($response);
        }

        if(is_null($request->date_of_birth)){
            $response = [
                "Code" => "500",
                "Description" => "You did not provide a date of birth",
            ];
            return json_encode($response);
        }

        if(is_null($request->comments)){
            $response = [
                "Code" => "500",
                "Description" => "You did not provide comments",
            ];
            return json_encode($response);
        }

        $gender_string = $form_data['gender'];
        $gender        = Gender::where ('gender', $gender_string)->first();

        $service_string = $form_data['service'];
        $service        = Service::where ('service_type', $service_string)->first();

        $patient = Patient::create([
            'name'          => $form_data['name'],
            'gender_id'     => $gender->id,
            'service_id'    => $service->id,
            'date_of_birth' => $form_data['date_of_birth'],
            'comments'      => $form_data['comments'],
        ]);

        if($patient){
            $response = [
                "Code" => "200",
                "Description" => "Patient record successfully created",
                "patient"     => $patient
            ];

            return json_encode($response);
        }else{
            $response = [
                "Code" => "500",
                "Description" => "There was a server error while creating the patient",
            ];
            return json_encode($response);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $data = $request->all();

        $response = $this->checkContentType($request);
        $decoded = json_decode($response, TRUE);
        if($decoded["Code"] != 200){
            return $response;
        }

        $patient = Patient::where('id', $id)->first();
        if(is_null($patient)){
            $response = [
                "Code" => "404",
                "Description" => "Patient record Not Found",
            ];
            return json_encode($response);
        }

        $response = [
            "Code" => "200",
            "Description" => "Patient record successfully created",
            "patient"     => $patient
        ];

        return json_encode($response);


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();

        $response = $this->checkContentType($request);
        $decoded = json_decode($response, TRUE);
        if($decoded["Code"] != 200){
            return $response;
        }

        $patient = Patient::where('id', $id)->first();
        if(is_null($patient)){
            $response = [
                "Code" => "404",
                "Description" => "Patient record Not Found",
            ];
            return json_encode($response);
        }

        // Update the patient's record
        if(!is_null($data)) {

        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $response = $this->checkContentType($request);
        $decoded = json_decode($response, TRUE);
        if($decoded["Code"] != 200){
            return $response;
        }

        $patient = Patient::where('id', $id)->first();
        if(is_null($patient)){
            $response = [
                "Code" => "404",
                "Description" => "Patient record Not Found",
            ];
            return json_encode($response);
        }

        $patient->delete();

        $response = [
            "code" => "200",
            "description" => "Patient record successfully deleted",
        ];
        return json_encode($response);
    }

    public function checkContentType($request){
        // Check for Content-Type first
        if ($request->hasHeader('Content-Type')) {
            $content_type = $request->header('Content-Type');
            if(strcmp($content_type, 'application/json') == 0){
                $response = [
                    "Code" => 200
                ];
                return json_encode($response);

            }else{
                $response = [
                    "Code" => "403",
                    "Description" => "JSON data is required",
                ];
                return json_encode($response);
            }
        }else{
            $response = [
                "Code" => "403",
                "Description" => "The Content-Type Header is required",
            ];
            return json_encode($response);
        }
    }
}
