<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Railway\Engine;
use Illuminate\Http\Request;

class EngineController extends Controller
{
    public function upload($id, Request $request)
    {
        $engine = Engine::find($id);

        if($engine->type_train == 'automotrice') {
            for ($i=0; $i <= $engine->technical->nb_wagon -1; $i++) {
                if(!\Storage::disk('public')->exists("/engines/{$engine->type_train}/{$engine->slug}-{$i}.gif")) {
                    $request->file('image')->storeAs("/engines/{$engine->type_train}/", $engine->slug."-".$i.".gif", "public");
                }
            }
        } else {
            $request->file('image')->storeAs("/engines/{$engine->type_train}/", $engine->slug.".gif", "public");
        }
    }
}
