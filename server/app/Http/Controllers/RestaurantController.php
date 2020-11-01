<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Restaurant;
use Illuminate\Support\Facades\DB;

class RestaurantController extends Controller
{
    public function index(Request $request)
    {
        $name = $request->name;
        $category = $request->category;

        $query = Restaurant::query();

        if ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        }
        
        if($category) {
            // $query->where('category', 'like', '%' . $category . '%');

            // $qは戻り値を受け取ってる。
            $query->whereHas('category', function($q) use ($category) {
                $q->where('name', 'like', '%' . $category . '%');
            });
        }
        // 10件表示
        $restaurants = $query->simplePaginate(5);

        // 最後尾に追加
        $restaurants->appends(compact('name', 'category'));
    

        // 【検索方法１:拡張性がない】
        // likeで一致するもの
        // nameが含まれていればOK
        // %つけることで、「酒」と検索しても居酒屋出てくる。
        // if(!empty($name)) {
        //     $restaurants = Restaurant::where('name', 'like', '%'. $name . '%');
        // } else {
        //     $restaurants = Restaurant::all();
        // }

        // 【検索方法２】

        // Restaurant::paginate(10)で1ページに10件表示
        // simplepaginateにすることで、１、２、３、４、の番号がなくなる。
        // $restaurants = Restaurant::all()->sortByDesc('recommend');
        // $restaurants = Restaurant::simplepaginate(10);
        return view('restaurants.index', compact('restaurants'));
    }


        // public function index()
    // {
    //     $restaurants = DB::table('restaurants')
    //         ->orderByRaw('recommend IS NULL ASC')
    //         ->orderBy('recommend', 'ASC')
    //         ->get();
    //     return view('restaurants.index', compact('restaurants'));
    // }


    public function show($id)
    {
        $restaurant = Restaurant::find($id);
        return view('restaurants.show', compact('restaurant'));
    }
}
