<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Establishment_image;
use App\Models\Establishment;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EstablishmentController extends Controller
{
    private $loggedUser;

    public function __construct() {
        $this->middleware('auth:api');
        $this->loggedUser = auth()->user();
    }

    public function create(Request $request){
        $array = ['error' => '', 'return' => ''];

        $validator = Validator::make($request->all(), [
            'name' => [ 'required' ],
            'phone' => [ 'required' ],
            'email' => [ 'required', 'email' ],
            'website' => [  ],
            'description' => [ ],
            'discount' => [ 'numeric' ],
            'open_weekday' => [ ],
            'open_saturday' => [ ],
            'open_sunday' => [ ],
            'open_holiday' => [ ],
            'product_type' => [ 'required' ],
            'signature_type' => [ 'required' ],
            'cardMachine' => [  ],
            'payment_type' => [ ],
            'featured' => [ 'numeric' ],
            'is_current_location' => [ 'numeric' ],
            'latitude' => [  ],
            'longitude' => [  ]
        ]);

        if(!$validator->fails()){
            $name = $request->input('name');
            $phone = $request->input('phone');
            $email = $request->input('email');
            $website = $request->input('website');
            $description = $request->input('description');
            $discount = $request->input('discount');
            $open_weekday = $request->input('open_weekday');
            $open_saturday = $request->input('open_saturday');
            $open_sunday = $request->input('open_sunday');
            $open_holiday = $request->input('open_holiday');
            $product_type = $request->input('product_type');
            $signature_type = $request->input('signature_type');
            $cardMachine = $request->input('cardMachine');
            $payment_type = $request->input('payment_type');
            $featured = $request->input('featured');
            $is_current_location = $request->input('is_current_location');
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            $e = new Establishment();
            $e->id_creator = $this->loggedUser['id'];
            $e->name = $name;
            $e->phone = $phone;
            $e->email = $email;
            $e->website = $website;
            $e->description = $description;
            $e->discount = $discount;
            $e->open_weekday = $open_weekday;
            $e->open_saturday = $open_saturday;
            $e->open_sunday = $open_sunday;
            $e->open_holiday = $open_holiday;
            $e->product_type = $product_type;
            $e->signature_type = $signature_type;
            $e->cardMachine = $cardMachine;
            $e->payment_type = $payment_type;
            $e->featured = $featured;
            $e->is_current_location = $is_current_location;
            $e->latitude = $latitude;
            $e->longitude = $longitude;
            $e->save();

            $array = ['error'=>'', 'return' => true];
        }

        return $array;
    }

    public function list(){
        $array = ['error'=>'','return'=>''];
        $info = $this->loggedUser;
        $establishments = Establishment::where('id_creator', $info['id'])->orderBy('id', 'desc')->get();
        
        if($establishments){

            $array['data'] = $establishments;

            for($q=0;$q<count($establishments);$q++){
                $establishment_image = Establishment_image::where('id_establishment', $establishments[$q]['id'])->get();
                $array['data'][$q]['images'] = $establishment_image;
            }

            $array['return'] = true;
            $array['error'] = false;

        }else{
            $array['return'] = false;
            $array['error'] = 'Estabelecimento não encontrado';
        }

        return $array;
    }

    public function one($id){
        $array = ['error'=>'','return'=>''];

        $info = $this->loggedUser;
        $establishment = Establishment::find($id);

        if($establishment){
            $array['data'] = $establishment;

            $establish_images = Establishment_image::where('id_establishment', $id)->get();
            $array['data']['images'] = $establish_images;
        }else{
            $array['return'] = false;
            $array['error'] = 'Estabelecimento não encontrado';
        }
        
        

        return $array;
    }

    public function update(Request $request, $id){
        $array = ['error' => true, 'return' => false];

        $rules = [
            'name' => [  ],
            'phone' => [ ],
            'email' => [ 'email' ],
            'website' => [ ],
            'description' => [ ],
            'discount' => [ 'numeric' ],
            'open_weekday' => [ ],
            'open_saturday' => [ ],
            'open_sunday' => [ ],
            'open_holiday' => [ ],
            'product_type' => [  ],
            'signature_type' => [ ],
            'cardMachine' => [ 'numeric' ],
            'payment_type' => [ ],
            'featured' => [ 'numeric' ],
            'is_current_location' => [ 'numeric' ],
            'latitude' => [  ],
            'longitude' => [  ]
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
           $array['error'] = $validator->messages();
           return $array;
        }

        $name = $request->input('name');
        $phone = $request->input('phone');
        $email = $request->input('email');
        $website = $request->input('website');
        $description = $request->input('description');
        $discount = $request->input('discount');
        $open_weekday = $request->input('open_weekday');
        $open_saturday = $request->input('open_saturday');
        $open_sunday = $request->input('open_sunday');
        $open_holiday = $request->input('open_holiday');
        $product_type = $request->input('product_type');
        $signature_type = $request->input('signature_type');
        $cardMachine = $request->input('cardMachine');
        $payment_type = $request->input('payment_type');
        $featured = $request->input('featured');
        $is_current_location = $request->input('is_current_location');
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');

        $establishment = Establishment::find($id);

        if($name){
            $establishment->name = $name;
        }
        if($phone){
            $establishment->phone = $phone;
        }
        if($email){
            $establishment->email = $email;
        }
        if($website){
            $establishment->website = $website;
        }
        if($description){
            $establishment->description = $description;
        }
        if($discount){
            $establishment->discount = $discount;
        }
        if($open_weekday){
            $establishment->open_weekday = $open_weekday;
        }
        if($open_saturday){
            $establishment->open_saturday = $open_saturday;
        }
        if($open_sunday){
            $establishment->open_sunday = $open_sunday;
        }
        if($open_holiday){
            $establishment->open_holiday = $open_holiday;
        }
        if($product_type){
            $establishment->product_type = $product_type;
        }
        if($signature_type){
            $establishment->signature_type = $signature_type;
        }
        if($cardMachine){
            $establishment->cardMachine = $cardMachine;
        }
        if($payment_type){
            $establishment->payment_type = $payment_type;
        }        
        if($featured){
            $establishment->featured = $featured;
        }
        if($is_current_location){
            $establishment->is_current_location = $is_current_location;
        }
        if($latitude){
            $establishment->latitude = $latitude;
        }
        if($longitude){
            $establishment->longitude = $longitude;
        }

        $establishment->save();

        $array = ['error'=>'', 'return' => true];

        return $array;
    }
}
