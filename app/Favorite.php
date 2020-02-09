<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Class Favorite for a "favorite" table
 */
class Favorite extends Model
{
    /**
     * Get repositories by name
     *  
     * @param type $name
     * @param type $page
     * @return type
     */
    public static function getReposByName($name, $page = 1) {
        
        // use curl or Guzzle library
        
        $totalCount = 0;
        $items = [];
        
        $url = "https://api.github.com/search/repositories?q=$name+in%3Aname&type=Repositories&page=".$page;
        $curlInit = curl_init($url);
        curl_setopt($curlInit,CURLOPT_RETURNTRANSFER,true);
        curl_setopt ($curlInit, CURLOPT_USERAGENT, "Mozilla");
        
        //Get response
        $response = curl_exec($curlInit);
        curl_close($curlInit);
        
        return json_decode($response);
    }
    
    /**
     * Get repository by id
     * 
     * @param type $id
     * @return type
     */
    public static function getReposById($id) {
        
        $url = "https://api.github.com/repositories/" . $id;
        $curlInit = curl_init($url);
        curl_setopt($curlInit,CURLOPT_RETURNTRANSFER,true);
        curl_setopt ($curlInit, CURLOPT_USERAGENT, "Mozilla");
        
        //Get response
        $response = curl_exec($curlInit);
        curl_close($curlInit);
        
        return $response = json_decode($response);
    }
}
