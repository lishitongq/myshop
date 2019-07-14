<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class GoodsController extends Controller
{
    // public function add_goods()
    // {
    //     // dd(storage_path('app\public'));
    //     return view('admin.add_goods');
    // }

    // public function do_add_goods(Request $request)
    // {
    //     // dd($_FILES);
    //     $files=$request->file('goods_pic');
    //     $path='';
    //     if(empty($files)){
    //         echo 'fail';die();
    //     }else{
    //       $path= $files->store('goods');
    //     }
    //     // dd($path);l;pp

    //     echo asset('storage').'/'.$path;
    // }

    public function goodsList(Request $request)
    {
        $req=$request->all();
        $search="";
        if(!empty($req['search'])){
            $search=$req['search'];
            $info=DB::table('goods')->where('goods_name','like','%'.$req['search'].'%')->paginate(2);
            // dd($info);
        }else{
            $info=DB::table('goods')->paginate(2);
        }
     
        return view('admin.goodsList',['goods'=>$info,'search'=>$search]);
      
    }

    public function goods(Request $request)
    {
        return view('admin.goods.goods');
    }

    public function add_goods(){
        return view('admin.add_goods');
    }

     public function do_add_goods(Request $request)
    {
        // dd($_FILES);
        $files=$request->file('goods_pic');
        $path='';
        if(empty($files)){
            echo 'fail';die();
        }else{
          $path= $files->store('goods');
        }
        // dd($path);l;pp

        echo asset('storage').'/'.$path;
        $req=$request->all();
        $req['add_time']=time();
        // dd($req);
        $result=DB::table('goods')->insert([
            $req
        ]);
        // dd($result);
        $result=true;
        if($result){
           return  redirect('admin/goods');
        }else{
            echo 'fail';
        }
    }

    public function delete(Request $request)
    {
        $req=$request->all();
        $result=DB::table('goods')->where(['id'=>$req['id']])->delete();
        if($result){
            return redirect('admin/goods');
        }
    }

    public function update(Request $request){
        $req=$request->all();
        $info=DB::table('goods')->where(['id'=>$req['id']])->first();
        return view('admin.goodsUpdate',['goods_info'=>$info]);
    }


    public function do_update(Request $request)
    {
       $req=$request->all();
    //    dd($req);
        $result=DB::table('goods')->where(['id'=>$req['id']])->update([
            'goods_name'=>$req['goods_name'],
            'goods_price'=>$req['goods_price'],
            'goods_pic'=>$req['goods_pic']
        ]);
        // dd($result);
        if($result){
           return  redirect('/admin/goods');
        }else{
            echo 'fail';
        }
    }
}
