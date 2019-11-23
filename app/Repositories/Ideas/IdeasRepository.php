<?php
/**
 * Created by PhpStorm.
 * User: mihaisolomon
 * Date: 2019-04-27
 * Time: 13:51
 */

namespace App\Repositories\Ideas;

use App\Models\Idea;
use App\Repository\BaseRepository;
use App\User;

class IdeasRepository extends BaseRepository implements IdeasRepositoryInterface
{
    public function __construct(Idea $model)
    {
        parent::__construct($model);
    }

    public function getPaginated(User $user)
    {
        $ideas = $this->model
            ->where('user_id', $user->id)
            ->paginate(10);

        $aIdeas = [];
        foreach ($ideas as $idea) {
            $aIdeas[] = [
                'id' => $idea->id,
                'content' => $idea->content,
                'impact' => floatval($idea->impact),
                'ease' => floatval($idea->ease),
                'confidence' => floatval($idea->confidence),
                'average_score' => floatval($idea->average_score),
                'created_at' => $idea->created_at
            ];
        }

        return $aIdeas;
    }

    public function newFind($id)
    {
        $idea = $this->find($id);

        return [
            'id' => $idea->id,
            'content' => $idea->content,
            'impact' => floatval($idea->impact),
            'ease' => floatval($idea->ease),
            'confidence' => floatval($idea->confidence),
            'average_score' => floatval($idea->average_score),
            'created_at' => $idea->created_at
        ];
    }

    public function newCreate(array $attributes)
    {
        $idea = $this->create($attributes);

        return [
            'id' => $idea->id,
            'content' => $idea->content,
            'impact' => floatval($idea->impact),
            'ease' => floatval($idea->ease),
            'confidence' => floatval($idea->confidence),
            'average_score' => floatval($idea->average_score),
            'created_at' => $idea->created_at
        ];
    }

    public function newUpdate(array $attributes, $id)
    {
        $idea = $this->find($id);

        if (is_null($idea)) {
            return false;
        }

        if (isset($attributes['user'])) {
            $user = $attributes['user'];

            unset($attributes['user']);

            if ($user->id !== $idea['user_id']) {
                return false;
            }

            $this->update($attributes, $idea['user_id']);

            return $idea;
        }
    }

    public function delete($id)
    {
        if (is_array($id)) {
            $idea = $this->find($id['id']);
            if(is_null($idea)) {
                return false;
            }
            if(isset($id['user']) && $idea->user_id === $id['user']->id) {
                $idea->delete();
                return true;
            }
            return false;
        }

        return false;
    }
}
