<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Auth;
use DB;

class AdminController extends Controller
{
	public function index()
	{
		if(!Auth::user() || !Auth::user()->type == 0) {     
			return redirect('admin');
        }
		
		
		$users = DB::table('users')->where('type', '<>', 0)->get();
		
		return view('admin/users', compact('users'));
	}
	public function login()
	{
		if(Auth::user() && Auth::user()->type == 0) {     
			return redirect('admin/users');
        }

		return view('admin/login');
	}

	public function loginme(Request $request)
	{
		$validator = Validator::make($request->all(), [
    		'email' => 'required|email',
    		'password' => 'required',
    	]);

    	if($validator->fails()) {
    		return redirect('admin')
    			->withErrors($validator)
    			->withInput();
    	}

        if($request->input('remember') == 1) { $remember = 1; } 
		else { $remember = null; }

    	if (Auth::attempt([
    			'email' => $request->input('email'),
    			'password' => $request->input('password'),
    			'type' => 0
    	], $remember)) {
			Session::flash('flash_message', 'Successfuly logged in');
    		return redirect('admin/users');
    	} else {
    		Session::flash('error_message', 'Admin email or password is wrong');
			return redirect('admin')->withInput();
    	}

	}

    public function logout()
    {
        Auth::logout();

        return redirect('admin');
    }
	
	public function suspend( Request $request )
	{
		if(Auth::user() && Auth::user()->type == 0) {     
			DB::table('users')->where('id', '=', $request->input('id'))->update(['suspended' => 1]);
			return redirect('admin/users');
        }

		return redirect('admin');
	}
	
	public function active( Request $request )
	{
		if(Auth::user() && Auth::user()->type == 0) {
			DB::table('users')->where('id', '=', $request->input('id'))->update(['suspended' => 0]);  
			return redirect('admin/users');
        }

		return redirect('admin');
	}
	
	public function delete_user( Request $request )
	{
		if(Auth::user() && Auth::user()->type == 0) {
			DB::table('users')->where('id', '=', $request->input('id'))->delete();  
			return redirect('admin/users');
        }

		return redirect('admin');
	}
	
	public function search_user( Request $request )
	{
		if(Auth::user() && Auth::user()->type == 0) {
			$looking = '%'.$request->input('user').'%';
			$users = DB::table('users')
				->where('firstname', 'like', $looking)
				->orWhere('middlename', 'like', $looking)
				->orWhere('lastname', 'like', $looking)
				->orWhere('email', 'like', $looking)
				->get();  
			return view('admin/users', compact('users'));
        }

		return redirect('admin');
	}
	
	public function add_category( Request $request )
	{
		if(Auth::user() && Auth::user()->type == 0) {
			$category = $request->input('category');
			if($category){
				DB::table('categories')
					->insert(['title' => $category]);
				Session::flash('flash_message', 'Category succesfuly added');
				return redirect('admin/users')->withInput();
			} else  {
				Session::flash('error_message', "You can't add empty category");
				return redirect('admin/users')->withInput();
			}
        }

		return redirect('admin');
	}
	
	public function save_category( Request $request )
	{
		if(Auth::user() && Auth::user()->type == 0) {
			$id = $request->input('id');
			$title = $request->input('title');
			if($title && $id ) {
				$update = DB::table('categories')
					->where('id', '=', $id )
					->update(['title' => $title]);
				if($update) {
					Session::flash('flash_message', 'Category succesfuly updated');
					return redirect('admin/experts')->withInput();
				} else {
					Session::flash('error_message', "Category wasn't update");
					return redirect('admin/experts')->withInput();
				}
			} else  {
				Session::flash('error_message', "You can't add empty category");
				return redirect('admin/users')->withInput();
			}
        }

		return redirect('admin');
	}

	public function delete_category( $id )
	{
		if(Auth::user() && Auth::user()->type == 0) {
			DB::table('categories')
				->where('id', '=', $id )
				->delete();
			Session::flash('flash_message', 'Category was succesfuly deleted');
			return redirect('admin/users')->withInput();
        }

		return redirect('admin');
	}

	public function customers()
	{
		if(Auth::user() && Auth::user()->type == 0) {
			$type = 1;
			$users = DB::table('users')->where('type','=',$type)->get();
			
		
			return view('admin/users', compact('users', 'type'));
        }

		return redirect('admin');
	}
	
	public function experts($id = NULL)
	{
		if(Auth::user() && Auth::user()->type == 0) {
			$type = 2;
			$users = DB::table('users')->where('users.type','=',$type);
			if($id) {
				$users = $users->join('user_category', 'users.id', '=', 'user_category.user_id')
					->join('categories', 'user_category.category_id', '=', 'categories.id')
					->where('categories.id','=',$id);
			}
			$users = $users->get();
			$categories = DB::table('categories')->where('type','=',$type)->get();
		
			return view('admin/users', compact('users', 'type','categories'));
        }

		return redirect('admin');
	}
	
	public function statistics( Request $request )
	{
		if(Auth::user() && Auth::user()->type == 0) {
			
			$type = $request->input('statistic');
			$categorytype = $request->input('category');
			
			$categories = DB::table('categories')->get();
			
			switch($type) {
				case 'posibilities':
					$feedbacks = DB::table('feedbacks')->get();
					$searches = DB::table('searches')->select(DB::raw('count(*) as count, text'))
						->groupBy('text')
						->orderBy('count', 'desc')
						->get();
					return view('admin/statistics', compact('type', 'categorytype', 'categories', 'feedbacks', 'searches'));
					break;
				case 'experts':
					return view('admin/statistics', compact('type', 'categorytype', 'categories'));
					break;
				case 'popularity':
					$experts = DB::table('users');
					if($categorytype != ''){
						$experts =  $experts->join('user_category', 'users.id', '=', 'user_category.user_id')
							->where('category_id', '=', $categorytype);
					}
					$experts =  $experts->join('reviews', 'reviews.expert_id', '=', 'users.id')
						->where('users.type', '=', 2)
						->select(DB::raw('count(reviews.rating) as review_count, sum(reviews.rating) as rating, users.*'))
						->groupBy('users.id')
						->orderBy('rating', 'desc')
						->get();
					
				
				
					// TODO Try to improve this with SQL
					foreach($experts as $expert){
						$ratings = DB::table('reviews')->where('expert_id', '=', $expert->id)->get();
						$quote = 0;
						foreach($ratings as $rating){
							switch($rating->rating) {
								case 1: break;
								case 2: $quote += 100; break;
								case 3: $quote += 200; break;
								case 4: $quote += 300; break;
								case 5: $quote += 400; break;
							}
						}
						$expert->value = ($expert->rating + $quote) / $expert->review_count;
					}
					// end
					
					return view('admin/statistics', compact('type', 'categorytype', 'categories','experts'));
					break;
					
					break;
				case 'prices':
					$experts = DB::table('users');
					if($categorytype != ''){
						$experts =  $experts->join('user_category', 'users.id', '=', 'user_category.user_id')
							->where('category_id', '=', $categorytype);
					}
					$experts =  $experts->where('type', '=', 2)
						->orderBy('price', 'desc')
						->get();
				
					return view('admin/statistics', compact('type', 'categorytype', 'categories','experts'));
					break;
			}
			
			return view('admin/statistics', compact('type', 'categorytype', 'categories'));
        }

		return redirect('admin');
	}
}
