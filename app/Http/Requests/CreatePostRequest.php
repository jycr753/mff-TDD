<?php

namespace App\Http\Requests;

use App\Exceptions\ThrottleException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use App\Notifications\YouWereMentioned;
use App\User;

class CreatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('create', new \App\Reply);
    }

    /**
     * Handle a failed authorization attempt.
     *
     * @return void
     * 
     * @throws ThrottleException
     */
    protected function failedAuthorization()
    {
        throw new ThrottleException('You are repling too frequently, Please take a break');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'body' => 'required|spamfree'
        ];
    }

    public function persist($thread)
    {
        $reply = $thread->addReply(
            [
                'body' => request('body'),
                'user_id' => auth()->id()
            ]
        );
        
        // Inspect the body of the reply for username
        preg_match_all('/\@([^\s\.]+)/', $reply->body, $matchs);

        $names = $matchs[1];
       
        // for each menthioned user notify them
        foreach ($names as $name) {
            $user = User::whereName($name)->first();

            if ($user) {
                $user->notify(new YouWereMentioned($reply));
            }
        }

        return $reply->load('owner');
    }
}
