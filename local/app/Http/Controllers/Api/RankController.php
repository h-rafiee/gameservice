<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RankController extends Controller
{
    public function global_rank(Request $request){
        $data['status']='fail';
        $file_json = app_path('../ranks/'.hash("gost",$request->device->game_id).'.json');
        if(file_exists($file_json)){
            $file_date = date("Y-m-d H:i:s",filemtime($file_json));
            $datetime1 = date_create($file_date);
            $datetime2 = date_create(date("Y-m-d H:i:s"));

            $interval = date_diff($datetime1, $datetime2);

            $days = $interval->format("%d");
            if($days < 7){
                $txt = file_get_contents($file_json);
                return response($txt)->header('Content-Type', "application/json");
            }else{
                unlink($file_json);
            }
        }else{
            if(is_dir(app_path("../ranks")) == FALSE)
                mkdir(app_path("../ranks"),0755,TRUE);
            $game_leaderboard = \App\GameLeaderboard::where('game_id',$request->device->game_id)->orderBy('priority','DESC')->get();
            if(empty($game_leaderboard)){
                $data['message']='None Leaderboard';
                return response(json_encode($data),444);
            }
            $sortQry = [];
            $stringQry = [];
            foreach($game_leaderboard as $glval){
                $stringQry[] = "(select score FROM user_game_leaderboards where user_game_id = ug.id and game_leaderboard_id = {$glval->id}) as {$glval->title}";
                $sortQry[] = "l.{$glval->title} DESC";
            }
            $query = "SELECT * FROM (
            SELECT
            l.* ,
            @rownum := @rownum + 1 AS rank
            FROM (
                SELECT
                u.id as user_id,
                u.username,
                u.name,
                u.profile_pic,".implode(",",$stringQry)."
                FROM user_games as ug
                JOIN users as u ON u.id = ug.user_id
            ) AS l , (SELECT @rownum := 0) r
            ORDER BY ".implode(",",$sortQry)."
            ) as t
                ";
            $queryBLD = $query." LIMIT 10 OFFSET 0;";
            $excQuery = DB::select($queryBLD, []);
            $data['status']='done';
            $data['leaderboard'] = $excQuery;
            $queryBLD = $query." WHERE t.user_id = {$request->device->user_id} LIMIT 1 OFFSET 0;";
            $excQuery = DB::select($queryBLD, []);
            $data['current_user_rank'] = $excQuery;
            $txt = json_encode($data);
            $myfile = fopen($file_json, "w") or die("Unable to open file!");
            fwrite($myfile, $txt);
            fclose($myfile);
            $txt = file_get_contents($file_json);
            return response($txt)->header('Content-Type', "application/json");
        }



    }
}
