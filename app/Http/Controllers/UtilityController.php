<?php

namespace App\Http\Controllers;

use App\Models\Lenders;
use App\Models\ROS;
use Illuminate\Http\Request;

class UtilityController extends Controller
{
    public function lendersOption() {
        $lenders = Lenders::get();

        $options = [];

        foreach($lenders as $item){
            array_push($options, [
                'value' => $item['id'],
                'label' => $item['name'],
            ]);
        }

        return response()->json($options);
    }

    public function rosOption() {
        $ros = ROS::get();

        $options = [];

        foreach($ros as $item){
            array_push($options, [
                'value' => $item['id'],
                'label' => $item['name'],
            ]);
        }

        return response()->json(['success' => 'ROS options get successfully.', 'options' => $options], 200);
    }
}
