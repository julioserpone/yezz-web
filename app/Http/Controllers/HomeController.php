<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.2/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Subscription;
use App\User;
use App\UserRol;
use App\YtCategorystatus;
use App\YtComment;
use App\YtTheme;
use App\YtThemeStatus;
use Carbon\Carbon;
use DB;

class HomeController extends Controller {
	
	/**
	* Show the application dashboard.
	*
	* @return Response
	*/
	public function index() {

		$register = array();
		$months_users    = array(0,0,0,0,0,0,0,0,0,0,0,0); 
		$months_comments = array(0,0,0,0,0,0,0,0,0,0,0,0); 
		$top_themes      = array();       
		$top_comments    = array();       
		$top_likes       = array();       
		$top_dislikes    = array();       
		$top_users       = array();       
		$top_users_likes = array();       
		$top_users_dislikes = array();       
		$top_users_points   = array();       


		$role  = UserRol::where('ext_id','web_user')->first();

		$users = User::where('rol_id',$role->id)->get();
		$user_count = ($users->count()>0 ) ? $users->count() : 0;

		$catStatus   = YtCategorystatus::where('ext_id','open')->first();
		$themeStatus = YtThemeStatus::where('ext_id','open')->first();

		$themes = YtTheme::selectRaw('yt_themes.ext_id, yt_themes.title, yt_themes.summary summary ,yt_themes.highlight_one
			,highlight_two, highlight_three
			,yt_themes.likes, yt_themes.dislikes
			,yt_themes.createdBy createdBy ,yt_themes.created_at,  yt_themes.updatedBy
			,coalesce(comments.count,0) comments
			,yt_categories.name category_name')
		->join('yt_categories','yt_categories_id','=','yt_categories.id')
		->leftJoin(DB::raw('(select yt_themes_id , count(*) count from yt_comments group by yt_themes_id) comments'),
			function($join){
				$join->on('yt_themes.id', '=', 'comments.yt_themes_id');
			} )
		->where('yt_categories.yt_categorystatuses_id',$catStatus->id)
		->where('yt_theme_statuses_id',$themeStatus->id)

		->orderby('yt_themes.created_at','desc')
		->get();

		$themes_count = ($themes->count()>0) ? $themes->count() : 0;

		$current = Carbon::now();

		$current_date = date_parse_from_format("Y-m-d", $current);

		/*Gets registered users this year for chart*/
		$year_users = User::whereRaw('YEAR(created_at) = '.$current_date['year'].' and rol_id = '.$role->id)->get();

		foreach ($year_users as $key => $usr) 
		{
			$c_date = date_parse_from_format("Y-m-d", $usr->created_at);
			$m = $c_date['month'];
			$index = $m-1;
			$months_users[$index] = $months_users[$index] + 1;
		}
		$months_users = json_encode($months_users);

		/*Gets User Global Comments Activity from YezzTalk*/
		$comments = YtComment::withTrashed()
		->select('yt_comments.ext_id','yt_comments.created_at')
		->whereRaw('YEAR(yt_comments.created_at) = '.$current_date['year'])
		->get();

		if($comments!=null)
		{
			foreach ($comments as $key => $comment) 
			{

				$c_date = date_parse_from_format("Y-m-d", $comment->created_at);
				$m = $c_date['month'];
				$index = $m-1;
				$months_comments[$index] = $months_comments[$index] + 1;

			}
			$months_comments = json_encode($months_comments);
		}


		/*Gets Most Commented Themes Top 7*/
		$topthemes = YtTheme::selectRaw('yt_themes.ext_id, yt_themes.title, yt_themes.likes, yt_themes.dislikes
			,coalesce(comments.count,0) comments')
		->join('yt_categories','yt_categories_id','=','yt_categories.id')
		->leftJoin(DB::raw('(select yt_themes_id , count(*) count from yt_comments group by yt_themes_id) comments'),
			function($join){
				$join->on('yt_themes.id', '=', 'comments.yt_themes_id');
			} )
		->where('yt_categories.yt_categorystatuses_id',$catStatus->id)
		->where('yt_theme_statuses_id',$themeStatus->id)
		->orderby('comments','desc')
		->take(10)->get();

		if($topthemes!=null)
		{
			foreach ($topthemes as $key => $theme) 
			{
				array_push($top_themes,  $theme->title);
				array_push($top_comments,$theme->comments);
				array_push($top_likes,   $theme->likes);
				array_push($top_dislikes,$theme->dislikes);
			}

			$top_themes   = json_encode($top_themes);
			$top_comments = json_encode($top_comments);
			$top_likes    = json_encode($top_likes);
			$top_dislikes = json_encode($top_dislikes);
		}

		/*Gets top User with most likes*/
		$tusers = User::selectRaw('name, email, comments.likes , comments.dislikes, comments.points')
		->leftJoin(DB::raw('(select user_id, coalesce(sum(likes),0) likes , coalesce(sum(dislikes),0) dislikes 
			,coalesce(sum(likes) - sum(dislikes),0) as points
			from yt_comments 
			where yt_banreasons_id = 0 group by user_id) comments'),
		function($join){
			$join->on('users.id', '=', 'comments.user_id');
		} )
		->where('rol_id',$role->id)
		->orderby('comments.points','desc')
		->take(10)->get();

		if($tusers!=null)
		{
			foreach ($tusers as $key => $usr) 
			{
				array_push($top_users, $usr->name);
				array_push($top_users_likes, $usr->likes);
				array_push($top_users_dislikes,$usr->dislikes);
				array_push($top_users_points,$usr->points);
			}

			$top_users          = json_encode($top_users);
			$top_users_likes    = json_encode($top_users_likes);
			$top_users_dislikes = json_encode($top_users_dislikes);
			$top_users_points   = json_encode($top_users_points);
		}

		$subscriptions = Subscription::get()->count();


		return view('home', compact('user_count','themes_count','months_users','months_comments','top_themes','top_likes','top_dislikes','top_comments',
			'top_users','top_users_likes','top_users_dislikes','top_users_points','subscriptions'));
	}
}
