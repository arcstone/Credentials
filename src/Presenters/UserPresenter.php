<?php

/**
 * This file is part of Laravel Credentials by Graham Campbell.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at http://bit.ly/UWsjkb.
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace GrahamCampbell\Credentials\Presenters;

use GrahamCampbell\Credentials\Models\User;
use Illuminate\Support\Facades\App;
use McCool\LaravelAutoPresenter\BasePresenter;

/**
 * This is the user presenter class.
 *
 * @author    Graham Campbell <graham@mineuk.com>
 * @copyright 2013-2014 Graham Campbell
 * @license   <https://github.com/GrahamCampbell/Laravel-Credentials/blob/master/LICENSE.md> Apache 2.0
 */
class UserPresenter extends BasePresenter
{
    /**
     * Create a new instance.
     *
     * @param \GrahamCampbell\Credentials\Models\User $user
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->wrappedObject = $user;
    }

    /**
     * Get the user's name.
     *
     * @return string
     */
    public function name()
    {
        return $this->wrappedObject->first_name.' '.$this->wrappedObject->last_name;
    }

    /**
     * Get the user's security history.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function securityHistory()
    {
        $presenter = App::make('McCool\LaravelAutoPresenter\PresenterDecorator');
        $history = $this->wrappedObject->security()->get();

        $history->each(function ($item) {
            $item->security = true;
        });

        return $presenter->decorate($history);
    }

    /**
     * Get the user's action history.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function actionHistory()
    {
        $presenter = App::make('McCool\LaravelAutoPresenter\PresenterDecorator');
        $history = $this->wrappedObject->actions()->get();

        return $presenter->decorate($history);
    }
}
