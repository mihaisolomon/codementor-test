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

        return $ideas->items();
    }

    public function update(array $attributes, $id)
    {
        $idea = $this->find($id);

        if (is_null($idea)) {
            return false;
        }

        if (isset($attributes['user'])) {
            $user = $attributes['user'];

            unset($attributes['user']);

            if ($user->id !== $idea->user_id) {
                return false;
            }

            $idea->update($attributes);

            return $idea;
        }
    }

    public function delete($id)
    {
        if (is_array($id)) {
            $idea = $this->find($id['id']);
            if(isset($id['user']) && $idea->user_id === $id['user']->id) {
                $idea->delete();
                return true;
            }
            return false;
        }
    }
}
