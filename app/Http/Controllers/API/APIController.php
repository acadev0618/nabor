<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use DateTime;
use Illuminate\Http\Request;
use DB;

class APIController extends Controller
{
    public function home()
    {
        $home_list = DB::select('select * from hometable where is_home = 1');
        if(!$home_list) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Field not exist.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $home_list]);
        }
    }

    public function parliament()
    {
        $parliament_list = DB::select('select * from hometable where is_parliament = 1');
        if(!$parliament_list) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Field not exist.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $parliament_list]);
        }
    }

    public function downloads()
    {
        $parliament_list = DB::select('select * from hometable where is_downloads = 1');
        if(!$parliament_list) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Field not exist.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $parliament_list]);
        }
    }

    public function votes()
    {
        $votes_list = DB::select('select * from votes');
        if(!$votes_list) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Field not exist.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $votes_list]);
        }
    }

    public function vote(Request $request) {
        $id = array('id' => $request->id);
        $current_vote = DB::select('select * from votes where id = '.$request->id);
        if ($request->vote_type == 0) {
            $data = array(
                'sum_yes' => $current_vote[0]->sum_yes+1
            );
        }
        if ($request->vote_type == 1) {
            $data = array(
                'sum_no' => $current_vote[0]->sum_no+1
            );
        }
        if ($request->vote_type == 2) {
            $data = array(
                'sum_not_sure' => $current_vote[0]->sum_not_sure+1
            );
        }
        if ($request->vote_type == -1) {
            $data = array(
                'sum_not_sure' => $current_vote[0]->sum_not_sure
            );
        }
        $result = DB::table('votes')
                ->where($id)
                ->update($data);
        
        if($result != 1) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Field not exist.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $data]);
        }
    }

    public function voteResult(Request $request) {
        $id = array('id' => $request->id);
        $votes_list = DB::select('select * from votes where id = '.$request->id);
        
        if(!$votes_list) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Field not exist.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $votes_list]);
        }
    }

    public function standingOrder()
    {
        $votes_list = DB::select('select * from standing_order');
        if(!$votes_list) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Field not exist.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $votes_list]);
        }
    }

    public function constitution()
    {
        $votes_list = DB::select('select * from constitution');
        if(!$votes_list) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Field not exist.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $votes_list]);
        }
    }

    public function stateOpening()
    {
        $stateOpening_list = DB::select('select * from downloads where kind = 6');
        if(!$stateOpening_list) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Field not exist.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $stateOpening_list]);
        }
    }

    public function searchStateOpening(Request $request) {
        $data = DB::select('select * from downloads where kind = 6 and title like "%'.$request->key.'%"', [1]);
        
        if(!$data) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Field not exist.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $data]);
        }
    }

    public function budget()
    {
        $budget_list = DB::select('select * from downloads where kind = 5');
        if(!$budget_list) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Field not exist.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $budget_list]);
        }
    }

    public function searchBudget(Request $request) {
        $data = DB::select('select * from downloads where kind = 5 and title like "%'.$request->key.'%"', [1]);
        
        if(!$data) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Field not exist.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $data]);
        }
    }

    public function gazettedActs()
    {
        $gazettedActs_list = DB::select('select * from downloads where kind = 0');
        if(!$gazettedActs_list) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Field not exist.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $gazettedActs_list]);
        }
    }

    public function searchGazettedActs(Request $request) {
        $data = DB::select('select * from downloads where kind = 0 and title like "%'.$request->key.'%"', [1]);
        
        if(!$data) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Field not exist.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $data]);
        }
    }

    public function govtAgreement()
    {
        $gazettedActs_list = DB::select('select * from downloads where kind = 1');
        if(!$gazettedActs_list) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Field not exist.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $gazettedActs_list]);
        }
    }

    public function searchGovtAgreement(Request $request) {
        $data = DB::select('select * from downloads where kind = 1 and title like "%'.$request->key.'%"', [1]);
        
        if(!$data) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Field not exist.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $data]);
        }
    }

    public function officailReport()
    {
        $officailReport_list = DB::select('select * from downloads where kind = 2');
        if(!$officailReport_list) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Field not exist.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $officailReport_list]);
        }
    }

    public function searchOfficailReport(Request $request) {
        $data = DB::select('select * from downloads where kind = 2 and title like "%'.$request->key.'%"', [1]);
        
        if(!$data) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Field not exist.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $data]);
        }
    }

    public function committeesReports()
    {
        $committeesReports_list = DB::select('select * from downloads where kind = 3');
        if(!$committeesReports_list) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Field not exist.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $committeesReports_list]);
        }
    }

    public function searchCommitteesReports(Request $request) {
        $data = DB::select('select * from downloads where kind = 3 and title like "%'.$request->key.'%"', [1]);
        
        if(!$data) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Field not exist.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $data]);
        }
    }

    public function researchMaterials()
    {
        $committeesReports_list = DB::select('select * from downloads where kind = 4');
        if(!$committeesReports_list) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Field not exist.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $committeesReports_list]);
        }
    }

    public function searchResearchMaterials(Request $request) {
        $data = DB::select('select * from downloads where kind = 4 and title like "%'.$request->key.'%"', [1]);
        
        if(!$data) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Field not exist.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $data]);
        }
    }

    public function aboutUs()
    {
        $aboutUs_list = DB::select('select * from about_us');
        if(!$aboutUs_list) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Field not exist.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $aboutUs_list]);
        }
    }

    public function parliamentMembers()
    {
        $parliamentMembers_list = DB::select('select * from members_parilament');
        if(!$parliamentMembers_list) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Field not exist.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $parliamentMembers_list]);
        }
    }

    public function searchParliamentMembers(Request $request) {
        $data = DB::select('select * from members_parilament where name like "%'.$request->key.'%"', [1]);
        
        if(!$data) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Field not exist.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $data]);
        }
    }

    public function parliamentMember(Request $request)
    {
        $parliament_member = DB::select('select * from members_parilament where id ='. $request->id);
        if(!$parliament_member) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Field not exist.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $parliament_member]);
        }
    }

    public function parliamentChiefMembers()
    {
        $parliamentChiefMembers_list = DB::select('select * from members_parliament_chief');
        if(!$parliamentChiefMembers_list) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Field not exist.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $parliamentChiefMembers_list]);
        }
    }

    public function searchParliamentChiefMembers(Request $request) {
        $data = DB::select('select * from members_parliament_chief where name like "%'.$request->key.'%"', [1]);
        
        if(!$data) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Field not exist.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $data]);
        }
    }

    public function parliamentChiefMember(Request $request)
    {
        $parliamentChiefMember = DB::select('select * from members_parliament_chief where id ='. $request->id);
        if(!$parliamentChiefMember) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Field not exist.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $parliamentChiefMember]);
        }
    }

    public function parliamentSpeaker()
    {
        $parliamentSpeaker = DB::select('select * from parliament_speaker');
        if(!$parliamentSpeaker) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Field not exist.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $parliamentSpeaker]);
        }
    }

    public function parliamentDirectory()
    {
        $parliamentDirectory = DB::select('select * from parliament_directory');
        if(!$parliamentDirectory) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Field not exist.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $parliamentDirectory]);
        }
    }

    public function parliamentClerk()
    {
        $parliamentClerk = DB::select('select * from parliament_clerk');
        if(!$parliamentClerk) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Field not exist.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $parliamentClerk]);
        }
    }

    public function parliamentCalendar()
    {
        $parliamentClerk = DB::select('select * from parliament_calendar');
        if(!$parliamentClerk) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Field not exist.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $parliamentClerk]);
        }
    }

    public function videoStreaming()
    {
        $videoStreaming = DB::select('select * from video_streaming');
        if(!$videoStreaming) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Field not exist.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $videoStreaming]);
        }
    }

    public function getImage()
    {
        $images = DB::select('select * from settings');
        if(!$images) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Field not exist.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $images]);
        }
    }

    // ================= Online Forum ======================
    public function getThread()
    {
        $thread_list = DB::select('SELECT
            T1.id,
            T1.title,
            T1.contents,
            T1.categoryid,
            T1.category,
            T1.user,
            T1.username,
            T1.photo,
            T1.is_login,
            T1.typeid,
            T1.type,
            T1.created_date,
            T1.latest_reply_date,
            T1.view,
            T1.reply,
            T1.complain,
            T2.username complain_user,
            T1.up_vote,
            T1.down_vote,
            T1.sub_category sub_category_id,
            T3.title sub_category,
            T1.is_active 
        FROM
            (
            SELECT
                T1.id,
                T1.title,
                T1.contents,
                T1.user,
                T1.category categoryid,
                T2.title category,
                T3.username,
                T3.photo,
                T3.is_login,
                T1.type typeid,
                T4.title type,
                T1.created_date,
                T1.latest_reply_date,
                T1.view,
                T1.reply,
                T1.complain,
                T1.complain_user,
                T1.up_vote,
                T1.down_vote,
                T1.sub_category,
                T1.is_active 
            FROM
                forum_thread T1
                LEFT JOIN forum_category T2 ON T1.category = T2.id
                LEFT JOIN forum_users T3 ON T1.USER = T3.id
                LEFT JOIN forum_type T4 ON T1.type = T4.id
                WHERE T1.is_complain = 0 AND T1.is_active = 1
            ) T1
            LEFT JOIN forum_users T2 ON T1.complain_user = T2.id
            LEFT JOIN forum_category T3 ON T1.sub_category = T3.id', [1]
        );
        $category = DB::select('select * from forum_category', [1]);
        if(!$thread_list && !$category) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Field not exist.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $thread_list, 'category' => $category]);
        }
    }

    public function register(Request $request) {
        $data = array(
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password
        );
        $result = DB::table('forum_users')->insert($data);
        
        if(!$result) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Faild to register.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $data]);
        }
    }

    public function login(Request $request) {
        $data = array(
            'email' => $request->email,
            'password' => $request->password
        );
        $user = DB::table('forum_users')->where($data)->first();
        
        if(!$user) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Faild to find.']);
        } else {
            $where = array(
                'id' => $user->id
            );
            $update = array(
                'is_login' => 1
            );
            $result = DB::table('forum_users')
                ->where($where)
                ->update($update);
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $user]);
        }
    }

    public function logout(Request $request) {
        $where = array(
            'id' => $request->id
        );
        $update = array(
            'is_login' => 0
        );
        $result = DB::table('forum_users')
            ->where($where)
            ->update($update);
        
        if($result != 1) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Faild to find.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'successfully logout']);
        }
    }

    public function getDataforAddThread()
    {
        $category = DB::select('select * from forum_category', [1]);
        $type = DB::select('select * from forum_type', [1]);
        if(!$category || !$type) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Field not exist.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'category' => $category, 'type' => $type]);
        }
    }

    public function addThread(Request $request) {        
        $dt = new DateTime();
        $currentdatetime = $dt->format('Y-m-d H:i:s');
        $data = array(
            'category' => $request->category,
            'sub_category' => $request->sub_category,
            'title' => $request->title,
            'contents' => $request->contents,
            'type' => $request->type,
            'user' => $request->user,
            'created_date' => $currentdatetime
        );
        $result = DB::table('forum_thread')->insert($data);
        if(!$result) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Faild to register.']);
        } else {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $data]);
        }
    }

    public function editThread(Request $request) {        
        $id = array('id' => $request->thread_id);
        $data = array(
            'category' => $request->category,
            'sub_category' => $request->sub_category,
            'title' => $request->title,
            'contents' => $request->contents,
            'type' => $request->type
        );
        
        $result = DB::table('forum_thread')
                ->where($id)
                ->update($data);
        if ($result != null) {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success']);
        } else {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Faild to edit this thread.']);
        }
    }

    public function deleteThread(Request $request) {
        $id = array(
            'id' => $request->id
        );

        $result = DB::table('forum_thread')->where($id)->delete();

        if($result == 1) {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success']);
        } else {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Faild to delete this thread.']);
        }
    }

    public function complain(Request $request) {
        $id = array('id' => $request->thread_id);
        $data = array(
            'complain' => $request->message,
            'complain_user' => $request->user_id,
            'is_complain' => 1
        );
        $result = DB::table('forum_thread')
                ->where($id)
                ->update($data);
        if ($result == 1) {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success']);
        } else {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Faild to complain.']);
        }
    }

    public function getDataforThreadDetail(Request $request) {
        $result = DB::select('select * from forum_users where id = '.$request->id, [1]);
        $thread = DB::select('select * from forum_thread where id = '.$request->thread_id, [1]);
        $voted = DB::select('select * from forum_vote where thread = '.$request->thread_id.' and user = '.$request->current_user, [1]);
        $reply = DB::select('SELECT
            T1.id,
            T1.contents,
            T1.user user_id,
            T2.username,
            T2.photo,
            T2.is_login
        FROM
            forum_reply T1
            LEFT JOIN forum_users T2 ON T1.user = T2.id
            WHERE T1.thread = '.$request->thread_id
        );
        if ($result) {
            DB::table('forum_thread')->where(array('id' => $request->thread_id))->update(array('view' => $thread[0]->view+1));
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $result, 'voted' => $voted, 'reply' => $reply]);
        } else {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Faild to get user created this thread.']);
        }
    }

    public function upVote(Request $request) {
        $thread = DB::select('select * from forum_thread where id = '.$request->thread_id, [1]);
        $result = DB::table('forum_thread')->where(array('id' => $request->thread_id))->update(array('up_vote' => $thread[0]->up_vote+1));
        $data = array(
            'user' => $request->user_id,
            'thread' => $request->thread_id
        );
        if ($result == 1) {
            DB::table('forum_vote')->insert($data);
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $thread]);
        } else {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Faild to vote.']);
        }
    }

    public function downVote(Request $request) {
        $thread = DB::select('select * from forum_thread where id = '.$request->thread_id, [1]);
        $result = DB::table('forum_thread')->where(array('id' => $request->thread_id))->update(array('down_vote' => $thread[0]->down_vote+1));
        $data = array(
            'user' => $request->user_id,
            'thread' => $request->thread_id
        );
        if ($result == 1) {
            DB::table('forum_vote')->insert($data);
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $thread]);
        } else {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Faild to vote.']);
        }
    }

    public function reply(Request $request) {
        $dt = new DateTime();
        $currentdatetime = $dt->format('Y-m-d H:i:s');
        $data = array(
            'thread' => $request->thread_id,
            'contents' => $request->contents,
            'user' => $request->user,
            'created_date' => $currentdatetime
        );
        $result = DB::table('forum_reply')->insert($data);
        $thread = DB::select('select * from forum_thread where id = '.$request->thread_id, [1]);
        if(!$result) {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Faild to register.']);
        } else {
            DB::table('forum_thread')->where(array('id' => $request->thread_id))->update(array('reply' => $thread[0]->reply+1, 'latest_reply_date' => $currentdatetime));
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $data]);
        }
    }

    public function editProfile(Request $request) {
        $update_id = array('id' => $request->id);
        $photo = $request->file('photo');

        $data = array(
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "username" => $request->username,
            "phone" => $request->phone,            
            "email" => $request->email,
            "birthday" => $request->birthday,
            "gender" => $request->gender
        );
        if($photo) {
            $photo_name = $photo->getClientOriginalName();
            $destinationPath = 'forum/uploads';
            $photo->move($destinationPath,$photo_name);
            $photo_link = "forum/uploads/".$photo_name;
            $data += [ "photo" => $photo_link ];
        }

        $result = DB::table('forum_users')
                ->where($update_id)
                ->update($data);
        $user = DB::select('select * from forum_users where id = '.$request->id, [1]);
        if ($result == 1) {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $user]);
        } else {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Faild to edit this thread.']);
        }
    }

    public function changePassword(Request $request) {
        $update_id = array('id' => $request->user_id);

        $data = array(
            "password" => $request->new_password
        );

        $result = DB::table('forum_users')
                ->where($update_id)
                ->update($data);
        $user = DB::select('select * from forum_users where id = '.$request->user_id, [1]);
        if ($result == 1) {
            return response()->json(['status' => '200', 'error_code' => '0', 'message' => 'success', 'data' => $user]);
        } else {
            return response()->json(['status' => '404', 'error_code' => '1', 'message' => 'Faild to edit this thread.']);
        }
    }
}