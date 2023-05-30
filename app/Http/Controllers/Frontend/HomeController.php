<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use View;


class HomeController extends Controller
{

   public function index()
   {
      $latest_news = Blog::where('category', 'Latest News')->where('status', 1)->orderby('created_at', 'desc')->take(4)->get();
      $breeds = view::get('https://dog.ceo/api/breeds/list/random/5')['message'];
      return View::make('frontend.index', compact('latest_news','breeds'));
   }

   // News Details
   public function viewNews(Blog $blog)
   {
      return view('frontend.newsDetails', compact('blog'));
   }


}
