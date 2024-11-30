<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matche;
use App\Models\Tournament;
use App\Models\FixedQuestion;
use App\Models\BetOption;
use App\Models\Category;
use App\Models\MatchQuestion;
use App\Models\SiteConfig;
use App\Models\MatchAnswer;
use App\Models\Team;
use Session;

class BroadCastController extends Controller
{

	public function getCategory(){
		$data = [];
		$category = Category::all();
		if(count((array)$category)>0):
			$data = $category;
		endif;
        return json_encode($data);
	}
    public function broadcast($ctId=0){

    	$data 	= [];
		if($ctId=="all" || $ctId=='null'):
			$category = Category::all(['name','id','catLogo']);
		endif;
		if(count((array)$category)>0):
		
        $sd    = SiteConfig::first(['id','minBet','maxBet']);
        if(count((array)$sd)>0):
            $siteDetails = $sd;
        endif;
			$olduserId	= '';
			$oldsiteDetails = '';
			$oldcsrfToken = '';

			foreach($category as $catKey=>$cat):
				$data[$catKey] = $cat;
				$matchList = Matche::where(['category'=>$cat->id])->where(['status'=>1])->orderBy('matchTime','ASC')->get(['id','matchName','tournament','teamA','teamB','matchTime','status']);
				if(count((array)$matchList)>0):
					$data[$catKey]['matchList'] = $matchList;
					$data[$catKey]['matchNull'] = 1;
					foreach($matchList as $mlKey=>$ml):
						$tournament = Tournament::find($ml->tournament,['id','cupName']);
						$data[$catKey]['matchList'][$mlKey]['tournamentName'] = $tournament->cupName;
						//Get tournament name
						//Fixed question query
						$fixedQuestion = FixedQuestion::where(['matchId'=>$ml->id])->where(function($query) {
							$query->where(['status'=>1])
							->orWhere(['status'=>2]);
						})->orderBy('id', 'ASC')->get(['id','teamA','teamB','quesId','status','draw']);
						if(count((array)$fixedQuestion)>0):
							$teamA = Team::find($ml->teamA,['id','team']);
							$teamB = Team::find($ml->teamB,['id','team']);
							$data[$catKey]['matchList'][$mlKey]['fixedQuestion'] = $fixedQuestion;
							foreach($fixedQuestion as $fqKey=>$fq):
								$question = BetOption::find($fq->quesId,['id','optionName']);
								$data[$catKey]['matchList'][$mlKey]['fixedQuestion'][$fqKey]['options'] = $question;
								$data[$catKey]['matchList'][$mlKey]['fixedQuestion'][$fqKey]['team'] = [array('name'=>$teamA->team,'value'=>$fq->teamA),array('name'=>$teamB->team,'value'=>$fq->teamB)];
							endforeach;
						endif;

						//Custom question query
						$customQuestion = MatchQuestion::where(['matchId'=>$ml->id])->where(function($query) {
							$query->where(['status'=>1])
							->orWhere(['status'=>2]);
						})->get(['id','quesId','status']);
						if(count((array)$customQuestion)>0):	
							$data[$catKey]['matchList'][$mlKey]['customQuestion'] = $customQuestion;
							foreach($customQuestion as $cqKey=>$cq):
								$option = BetOption::find($cq->quesId,['id','optionName']);
								$data[$catKey]['matchList'][$mlKey]['customQuestion'][$cqKey]['options'] = $option;
								$customAnswer = MatchAnswer::where(['quesId'=>$cq->id])->orderBy('id', 'ASC')->get(['id','quesId','answer','returnValue']);
								$data[$catKey]['matchList'][$mlKey]['customQuestion'][$cqKey]['customAnswer'] = $customAnswer;
							endforeach;
						endif;
					endforeach;
				else:
					$data[$catKey]['matchList'] = [];
				endif;
				$newsiteDetails = $siteDetails;
				$newUserId = Session::get('betuser');
				$newCsrfToken = csrf_token();
				if($olduserId ==''):
					$data[$catKey]['sessionUser'] = $newUserId;
				else:
					$olduserId	= $newUserId;
				endif;
				if($oldsiteDetails ==''):
					$data[$catKey]['SD'] = $newsiteDetails;
				else:
					$oldsiteDetails = $newsiteDetails;
				endif;
				if($oldcsrfToken ==''):
					$data[$catKey]['csrf_field'] = $newCsrfToken;
				else:
					$oldcsrfToken = $newCsrfToken;
				endif;					
			endforeach;
		endif;
        return json_encode($data);
    }

}
