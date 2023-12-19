<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Distance;

class DistanceController extends Controller
{
    public function store(Request $request){
        try {
          // $validateData = $request->validate([
          //   'lantitude'=>'required',
          //   'longitude'=>'required'
          // ]);
          
          $validateData = $this->validateLatitudeLongitude($request);

          $distance = Distance::create($validateData);
          return response()->json(['message'=>'Data inserted Successfully']);
        } catch (\Throwable $th) {
          return response()->json(['error' => $th->getMessage()], 500);
        }
    }
    private function validateLatitudeLongitude($request)
    {
        return $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
        ]);
    }
    public function findDistanceById($distance_id){
       $distance = Distance::find($distance_id);
    }
    public function update(Request $request,$distance){
      try {
        $distance = $this->findDistanceById($distance);
        
        $validateData = $this->validateLatitudeLongitude($request);

        $result = $distance->update($validateData);
        return response()->json(['distance'=>$distance]);

      } catch (\Throwable $th) {
        return response()->json(['error'=>$th->getMessage(),500]);
      }
    }
    public function show(Request $request,$distance){
      try {
          $distance = $this->findDistanceById($distance);
          return response()->json(['distance'=>$distance]);

      } catch (\Throwable $th) {
        return response()->json(['error'=>$th->getMessage(),500]);
      }


    }
    public function index(Request $request){
      try {

        $distances = Distance::all();
        return response()->json(['distance'=>$distances]);

      } catch (\Throwable $th) {

        return response()->json(['error'=>$th->getMessage(),500]);
      }
    }
    public function softDelete(Request $request,$distance){
      try {
        $distance = $this->findDistanceById($distance);
        if ($distance) {
          $distance->update([
              'is_delete' => 1
          ]);
  
        return response()->json(['messege'=>$distance]);}
      } catch (\Throwable $th) {

        return response()->json(['error'=>$th->getMessage(),500]);
      }
    }
    
    public function calculateDistanceBetWeenTwoPoints(Request $request)
    {
      try {
          $request->validate([
            'lat1' => 'required|numeric',
            'lon1' => 'required|numeric',
            'lat2' => 'required|numeric',
            'lon2' => 'required|numeric',
          ]);

          $lat1 = deg2rad($request->lat1);
          $lon1 = deg2rad($request->lon1);
          $lat2 = deg2rad($request->lat2);
          $lon2 = deg2rad($request->lon2);

      
    
        $latDiff = $lat2 - $lat1;
        $lonDiff = $lon2 - $lon1;
    
        $a = sin($latDiff / 2) ** 2 + cos($lat1) * cos($lat2) * sin($lonDiff / 2) ** 2;
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    
        $radius = 6371;
    
        $distance = $radius * $c;
    
        // return $distance;
        return response()->json(['distance'=>$distance]);
      } catch (\Throwable $th) {
        return response()->json(['error'=>$th->getMessage(),500]);
      }
          
    }



}
