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
        $user = \Auth::user();

        return $this->ideasRepository->getPaginated($user);
    }

    public function show(Request $request, $idea_id)
    {
        $user = \Auth::user();

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

        $user = \Auth::user();

        $avg = $this->calculateAvg($request);

        $data = $this->ideasRepository->create([
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
        $user = \Auth::user();

        $params = $request->all();

        $avg = $this->calculateAvg($request);

        $params['user'] = $user;
        $params['average_score'] = $avg;

        if($idea = $this->ideasRepository->update($params, $idea_id)) {
            return response()->json($idea, 200);
        }

        return response()->json(['success' => false], 422);
    }

    public function destroy(Request $request, $idea_id)
    {
        $user = \Auth::user();

        $response = $this->ideasRepository->delete([
            'id' => $idea_id,
            'user' => $user
        ]);

        if($response) {
            return response()->json(['success' => true], 200);
        }

        return response()->json(['success' => false], 422);

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
