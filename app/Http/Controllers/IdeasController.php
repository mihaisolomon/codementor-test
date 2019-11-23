<?php
/**
 * Created by PhpStorm.
 * User: mihaisolomon
 * Date: 2019-04-27
 * Time: 14:29
 */

namespace App\Http\Controllers;

use App\Repositories\Ideas\IdeasRepository;
use App\Repositories\Ideas\IdeasRepositoryInterface;
use Illuminate\Http\Request;

class IdeasController extends Controller
{
    protected $ideasRepository;

    public function __construct(IdeasRepository $ideasRepository)
    {
        $this->ideasRepository = $ideasRepository;
    }

    public function index(Request $request)
    {
        $user = $request->auth;

        return $this->ideasRepository->getPaginated($user);
    }

    public function show(Request $request, $idea_id)
    {
        $user = $request->auth;

        if(!ctype_digit($idea_id)) {
            return response()->json(['success' => false], 422);
        }

        $idea = $this->ideasRepository->find($idea_id);

        if($user->id !== $idea->user_id) {
            return response()->json(['success' => false], 422);
        }

        return response()->json($idea, 200);

    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required',
            'impact' => 'required',
            'ease' => 'required',
            'confidence' => 'required'
        ]);

        $user = $request->auth;

        $avg = $this->calculateAvg($request);

        $data = $this->ideasRepository->newCreate([
            'user_id' => $user->id,
            'content' => $request->get('content'),
            'impact' => $request->get('impact'),
            'ease' => $request->get('ease'),
            'confidence' => $request->get('confidence'),
            //'average_score' => $avg
            'average_score' => $avg
        ]);

        return response()->json($data, 201);
    }

    public function update(Request $request, $idea_id)
    {
        \Log::info('Here 1');
        if(!ctype_digit($idea_id)) {
            return response("false", 422);
        }

        try {
            \Log::info('Here 11');
            $idea = $this->ideasRepository->findOneOrFail($idea_id);
        } catch (\Exception $exception) {
            \Log::info('Here 111');
            return response("false", 422);
        }

        $user = $request->auth;
        \Log::info('Here 11111');
        $params = $request->all();

        $avg = $this->calculateAvg($request);

        $params['user'] = $user;
        $params['average_score'] = $avg;

        if($idea = $this->ideasRepository->newUpdate($params, $idea_id)) {
            \Log::info('Here 111111');
            \Log::info($idea);
            return response()->json($idea, 200);
        }

        return response("false", 422);
    }

    public function destroy(Request $request, $idea_id)
    {
        $user = $request->auth;

        if(!ctype_digit($idea_id)) {
            return response()->json(['success' => false], 422);
        }

        $response = $this->ideasRepository->newDelete([
            'id' => $idea_id,
            'user' => $user
        ]);

        if($response) {
            return response('',204);
        }

        return response('', 422);

    }

    private function calculateAvg(Request $request)
    {
        $notes = $request->get('ease') +
            $request->get('confidence') +
            $request->get('impact');

        $avg =  $notes / 3;

        return number_format($avg,2);
    }
}
