<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function users()
{
    return $this->belongsToMany(User::class)->withPivot('permission');
}

/*$user->posts()->attach($postId, ['permission' => 'editor']); 
$permission = $user->posts()->where('post_id', $postId)->first()->pivot->permission;
$user->posts()->updateExistingPivot($postId, ['permission' => 'owner']); */

}
