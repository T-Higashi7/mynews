<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Profile;
use App\ProfileHistory;
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function add(){
      return view('admin.profile.create');
    }
    
    public function create(Request $request){
      
      $this->validate($request, Profile::$rules);
      
      $profile = new Profile;
      $form = $request->all();

      // フォームから送信されてきた_tokenを削除する
      unset($form['_token']);

      // データベースに保存する
      $profile->fill($form);
      $profile->save();
      
      return redirect('admin/profile/create');
    }
    
    public function edit(Request $request){
      $profile = Profile::find($request->id);
      if(empty($profile)){
        abort(404);
      }
      // dd($profile);
      return view('admin.profile.edit' ,['profile_form' => $profile]);
    }
    
    public function index(Request $request){
      $cond_title = $request->cond_title;

      if ($cond_title != '') {
          // 検索されたら検索結果を取得する
          $posts = Profile::where('title', $cond_title)->get();
      } else {
          // それ以外はすべてのプロファイルを取得する
          $posts = Profile::all();
      }
      return view('admin.profile.index', ['posts' => $posts, 'cond_title' => $cond_title]);
    }
    
    public function update(Request $request){
      
      // Validationをかける
      $this->validate($request, Profile::$rules);
      // Profile Modelからデータを取得する
      $profile = Profile::find($request->id);
      // 送信されてきたフォームデータを格納する
      $profile_form = $request->all();

      unset($profile_form['_token']);

      // 該当するデータを上書きして保存する
      $profile->fill($profile_form)->save();
      
      $profile_history = new ProfileHistory;
      $profile_history->profile_id = $profile->id;
      $profile_history->edited_at = Carbon::now();
      $profile_history->save();
      
      return redirect('admin/profile');
      
    }
    
    public function delete(Request $request){
    
      $profile = Profile::find($request->id);
      
      $profile->delete();
      return redirect('admin/profile/');
    }
}