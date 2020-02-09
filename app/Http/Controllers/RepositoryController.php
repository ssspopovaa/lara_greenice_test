<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \App\Favorite;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 *  Class for work with repositories
 */
class RepositoryController extends Controller
{
    // count results per page
    const PER_PAGE_PAGINATE = 5;
    
    /**
     * Action for a main page
     * 
     * @param Request $request
     * @return type
     */
    public function index(Request $request) {
        
        // Current page
        $page = $request->page ?? 1;
        
        // Total result count
        $totalCount = 0;
        
        $items = [];
        
        // If user set new request remember it
        if($request->search) {
           session(['search' => $request->search]);
        } 
  
        // find repos by remembering guery in session
        if(session('search')) {
            $repos = Favorite::getReposByName(session('search'), $page);

            // unregistered github users can fetch not more 1000 results
            $totalCount = ($repos->total_count > '999') ? '999' : $repos->total_count;
            $items = $repos->items;

            // manual pagination
            $repos = new LengthAwarePaginator($items, $totalCount, 30, $page);
            
        // if nothing to show in view
        } else {
            $repos = [];
        }
       
        return view('main' , compact('repos'));
    }
    
    /**
     * Save repository to the favorite table
     * 
     * @param type $id
     * 
     * @return type
     */
    public function save($id) {
        
        $repository = Favorite::getReposById($id);
        
        // Get user id and check login
        $userId = Auth::user()->id;
        
        if(!$userId) {
            
            return redirect()->route('get.index')->with('error', 'Вы должны быть зарегистрированы');
        }
        
        if($repository->id) {
            
            $isSaved = Favorite::where('repo_id', $repository->id)
                               ->where('user_id', $userId)
                               ->get()->toArray();
            
            if (!empty($isSaved)) {
                return redirect()->route('get.show')->with('error', 'У Вас уже есть этот репозиторий в избранных');
            }
            
            // Create object favorite model and save in database
            $favorite = new Favorite();
            $favorite->name = $repository->name;
            $favorite->user_id = $userId;
            $favorite->repo_id = $repository->id;
            $favorite->html_url = $repository->html_url;
            $favorite->description = $repository->description;
            $favorite->owner_login = $repository->owner->login;
            $favorite->stargazers_count = $repository->stargazers_count;
            $favorite->save();
            
            return redirect()->route('get.index')->with('success', 'Репозиторый '. $repository->name . ' добавлен в избранные');
            
        }
    }
    
    /**
     * Show all favorite repositories
     * 
     * @return type
     */
    public function show() {
        
        $userId = Auth::user()->id;
        
        $repos = Favorite::where('user_id', '=', $userId)->paginate(self::PER_PAGE_PAGINATE);
        
        return view('favorite', compact('repos'));
    }
    
    /**
     * Delete favorite repository
     * 
     * @param type $id
     * 
     * @return type
     */
    public function delete($id) {

        $favorite = Favorite::find($id)->delete();

        return redirect()->route('get.show')->with('success', 'Репозиторий удален из избранных');
    }
    
    public function clear(Request $request) {
        
        if(session('search')) {
            session(['search' => '']);
        }
        
        return redirect()->route('get.index')->with('success', 'Вы очистили запрос поиска');
    }
}
